<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\RequestTest as RequestTestResource;
use App\Http\Resources\RequestTestCollection;
use App\RequestTest;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;

class RequestTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = new RequestTestCollection(RequestTest::all());

        return response()->json([
          [
            'isSuccess' => true,
            'count'     => $data->count(),
            'status'    => 200,
            'objects'   => $data,
          ]
        ]);
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
            $data = RequestTest::create($request->all());
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'message'   => 'Ha ocurrido un error',
                'status'    => 400,
              ]
            );
        }

        // Se debe cambiar usuario por supplier
        $user = User::findOrFail($request->get('user_id'));
        $notification = $this->sendNotification($user[ 'email' ]);

        return response()->json(
          [
            'isSuccess'     => true,
            'message'       => 'El request test ha sido creado con exito!.',
            'status'        => 200,
            'Notification'  => $notification,
            'objects'       => $data,
          ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $data = new RequestTestResource((RequestTest::findOrFail($id)));
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
            'objects'    => $data,
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
            $data = RequestTest::findOrFail($id);
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
            'message'   => 'EL request se ha actualizado con exito!.',
          ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            $data = RequestTest::findOrFail($id);
            $data->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'No se encontro RequestTest para eliminar',
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
            'message'   => 'El request test ha sido eliminado!.',
            'status'    => 200,
          ]
        );
    }

    private function sendNotification($email)
    {
        try {
            // Usando queue en lugar de send, el correo se envia en segundo plano!
            Mail::to($email)->queue( new \App\Mail\SeparateInventory());
        } catch (\Exception $e) {
            return 'Error al mandar la notificacion';
        }

        return 'Notificacion enviada con exito';
    }

}
