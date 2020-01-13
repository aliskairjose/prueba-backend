<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\MyOrder;
use App\Http\Resources\MyOrder as MyOrderResource;
use App\Http\Resources\MyOrderCollection;
use App\Mail\MyOrder as MailMyOrder;
use Exception;
use Illuminate\Contracts\Mail\Mailer;
use App\Mail\MyOrder;

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
     * @return Response
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

        return response()->json(
            [
                'isSuccess' => true,
                'message'   => 'El producto ha sido creado con exito!.',
                'status'    => 200,
                'objects'   => $data,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
            Mailer::to($email)->queue(new MailMyOrder());
        } catch (\Exception $e) {
            return 'Error al mandar la notificacion';
        }

        return 'Notificacion enviada con exito';
    }

}
