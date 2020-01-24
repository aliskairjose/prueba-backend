<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\MyOrder;
use App\Product;
use App\Http\Resources\MyOrder as MyOrderResource;
use App\Http\Resources\MyOrderCollection;
use App\Mail\MyOrder as MailMyOrder;
use Exception;
use App\User;
use Illuminate\Support\Facades\Mail;


class MyOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
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
                ]
            );
        }
        $user = User::findOrFail($request->get('suplier_id'));
        $notification = $this->sendNotification($user['email']);
        return response()->json(
            [
                'isSuccess'     => true,
                'message'       => 'El producto ha sido creado con exito!.',
                'status'        => 200,
                'Notification'  => $notification,
                'objects'       => $data,
            ]
        );
    }

    /**
     * Display the specified resource.
     * Recide el id del usuario
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $data = new MyOrderResource(MyOrder::where('user_id', $id));
        } catch (Exception $th) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'message'   => 'Ha ocurrido un error',
                    'status'    => 400,
                ]
            );
        }
        return response()->json(
            [
                'isSuccess' => true,
                'status'    => 200,
                'objects'   => $data
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
        //
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
}
