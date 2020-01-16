<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = new UserCollection(User::all());

        return response()->json([
            [
                'count'     => $data->count(),
                'isSuccess' => true,
                'objects'   => $data,
                'status'    => 200
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
            $data->update($request->all());
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
                'message'   => 'EL producto se ha actualizado con exito!.',
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'new_password' => 'required',
                    'c_password' => 'required|same:new_password',
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
                'messagge' => 'Error',
                'status' => 409,
                'error' => $error
            ]);
        }

        return response()->json(
            [
                'isSuccess' => true,
                'status' => 200,
                'message' => 'Contraseña actualizada',
            ]
        );
    }

    private function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(
                [
                    'status' => 401,
                    'message' => 'Token expirado',
                    'error' => $e->getStatusCode()
                ]
            );
        } catch (TokenInvalidException $e) {
            return response()->json(
                [
                    'status' => 401,
                    'message' => 'Token inválido',
                    'error' => $e->getStatusCode()
                ]
            );
        } catch (JWTException $e) {
            return response()->json(
                [
                    'status' => 401,
                    'message' => 'Token absent',
                    'error' => $e->getStatusCode()
                ]
            );
        }
        return $user;
    }
}
