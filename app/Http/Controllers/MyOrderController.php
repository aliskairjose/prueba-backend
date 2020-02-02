<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyOrderCollection;
use App\Mail\MyOrder as MailMyOrder;
use App\MyOrder;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;


class MyOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * Lista todas las ordenes
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $data = new MyOrderCollection(MyOrder::all());
        } catch (Exception $e) {
            return response()->json(
              [
                'isSUccess' => false,
                'status'    => 400,
                'error'     => $e
              ]
            );
        }
        return response()->json(
          [
            'isSucess' => true,
            'status'   => 200,
            'count'    => $data->count(),
            'objects'  => $data
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
            $data = MyOrder::create($request->all());
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
        $user = User::findOrFail($request->get('suplier_id'));
        $notification = $this->sendNotification($user[ 'email' ]);
        return response()->json(
          [
            'isSuccess'    => true,
            'message'      => 'El registro ha sido creado con exito!.',
            'status'       => 200,
            'Notification' => $notification,
            'objects'      => $data,
          ]
        );
    }

    /**
     * Display the specified resource.
     * Recide el id del usuario supplier y lista todas las ordenes de ese usuario Supplier
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function supplier($id)
    {
        try {

            $data = new MyOrderCollection(MyOrder::where('suplier_id', $id)->get());

        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'error'     => $e,
              ]
            );
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'error'     => $e,
              ]
            );
        }

        return response()->json(
          [
            'isSuccess' => true,
            'count'     => $data->count(),
            'status'    => 200,
            'objects'   => $data,
          ]
        );
    }

    /**
     * Display the specified resource.
     * Recide el id del usuario dropshipper y lista todas las ordenes de ese usuario Supplier
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function dropshipper($id)
    {
        try {

            $data = new MyOrderCollection(MyOrder::where('user_id', $id)->get());

        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'error'     => $e,
              ]
            );
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'error'     => $e,
              ]
            );
        }

        return response()->json(
          [
            'isSuccess' => true,
            'count'     => $data->count(),
            'status'    => 200,
            'objects'   => $data,
          ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
        $data = MyOrder::findOrFail($id);
        $data->status = $request->status;
        $data->save();

        }
        catch( ModelNotFoundException $e){
            return response()->json(
                [
                    'isSuccess' => false,
                    'status'    => 400,
                    'message'   => 'No se encontro registro',
                    '$error'    => $e
                ]
            );
        }
        catch (Exception $e) {
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
                'message'   => 'La orden se ha actualizado con exito!.',
                // 'objects'   => $data

            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        //
    }

    private function sendNotification($email)
    {
        try {
            // Usando queue en lugar de send, el correo se envia en segundo plano!
            Mail::to($email)->queue(new MailMyOrder());
        } catch (\Exception $e) {
            return 'Error al mandar la notificacion';
        }

        return 'Notificacion enviada con exito';
    }

    private function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired']);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid']);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent']);
        }
        return $user;
    }
}
