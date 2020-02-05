<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Mail\User as UserMail;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Swift_SwiftException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {

        $role = new RoleCollection(Role::where('name', $request->type_user)->get());
        $data = new UserCollection(User::where('role_id', $role[ 0 ]->id)->get());

        return response()->json(
          [
            'count'     => $data->count(),
            'isSuccess' => true,
            'objects'   => $data,
            'status'    => 200
          ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $password = Str::random(10);
            $data = User::create(
              [
                'name'              => $request->name,
                'surname'           => $request->surname,
                'email'             => $request->email,
                'birthday'          => $request->birthday,
                'type_user'         => 'supplier',
                'status'            => $request->status,
                'register_approved' => $request->register_approved,
                'banned'            => $request->banned,
                'approve_product'   => $request->approve_product,
                'password'          => Hash::make($password),
              ]
            );

        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'message'   => 'Ha ocurrido un error',
                'status'    => 400,
                'error'     => $e
              ]
            );
        }

        $this->sendNotification($request->email, $password);

        return response()->json(
          [
            'isSuccess' => true,
            'message'   => 'El supplier se ha sido creado con exito!.',
            'status'    => 200,
            'objects'   => $data
          ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $data = new UserResource((User::findOrFail($id)));
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => $e,
              ]
            );
        }

        return response()->json(
          [
            'isSuccess' => true,
            'objects'   => $data,
            'status'    => 200
          ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $data = User::findOrFail($id);

            $data->name = $request->name;
            $data->surname = $request->surname;
            $data->email = $request->email;
            $data->birthday = $request->birthday;
            $data->status = $request->status;
            $data->register_approved = $request->register_approved;
            $data->banned = $request->banned;
            $data->approve_product = $request->approve_product;
            $data->save();

        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'message'   => 'No se encontro registro a actualizar',
                'status'    => 400
              ]
            );
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'message'   => 'Ha ocurrido un error inesperado',
                'status'    => 400,
                'error'     => $e
              ]
            );
        }

        return response()->json(
          [
            'isSuccess' => true,
            'message'   => 'El registro se actualizo con exito',
            'status'    => 200,
            'objects'   => $data
          ]
        );
    }


    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make(
              $request->all(),
              [
                'email'        => 'required|email',
                'new_password' => 'required',
                'c_password'   => 'required|same:new_password',
              ]
            );
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            // Trae el usuario
            $user = $this->getAuthenticatedUser();
            $user->password = Hash::make($request->new_password);
            $user->save();
        } catch (QueryException $e) {
            $error = $e->getMessage();

            return response()->json([
              'isSuccess' => false,
              'messagge'  => 'Error',
              'status'    => 409,
              'error'     => $error
            ]);
        }

        return response()->json(
          [
            'isSuccess' => true,
            'status'    => 200,
            'message'   => 'Contraseña actualizada',
          ]
        );
    }

    private function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return $user;
    }

    /**
     * Update the column banned to specific user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function banUser(Request $request)
    {
        try {
            $rules = [
              'user_id' => 'required',
              'banea'   => 'required'
            ];
            $customMessages = [
              'required' => 'The :attribute field is required.',
            ];
            $this->validate($request, $rules, $customMessages);

            $user_post = User::findOrFail($request->user_id);
            $user_post->banned = $request->banea;
            $user_post->save();

        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'No se encontro el usuario',
              ]
            );
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => $e,
              ]
            );
        }

        return response()->json(
          [
            'isSuccess' => true,
            'status'    => 200,
            'message'   => 'EL usuario se ha actualizado con exito!.',
          ]
        );
    }

    public function sendMail(Request $request)
    {
//        return $request->all();
        try {
            // Usando queue en lugar de send, el correo se envia en segundo plano!
            Mail::to($request->email)->queue(new UserMail($request->password));
        }
        catch ( Swift_SwiftException $e){
            return response()->json(
              [
                'isSuccess' => false,
                'error'     => $e,
                'message'   => 'Error al enviar el mail'
              ]
            );
        }
        catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'error'     => $e,
                'message'   => 'Error al mandar la notificacion'
              ]
            );
        }

        return 'Notificacion enviada con exito';
    }

    private function sendNotification($email, $password)
    {
        try {
            // Usando queue en lugar de send, el correo se envia en segundo plano!
            Mail::to($email)->queue(new UserMail($password));
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'error'     => $e,
                'message'   => 'Error al mandar la notificacion'
              ]
            );
        }

        return 'Notificacion enviada con exito';
    }
}
