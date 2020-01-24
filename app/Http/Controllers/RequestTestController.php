<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyOrderCollection;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\RequestTest as RequestTestResource;
use App\Http\Resources\RequestTestCollection;
use App\MyOrder;
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
        $this->sendNotification('kervingonzalez@gmail.com');
        /*try {
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
        $user = User::findOrFail($request->get('suplier_id'));
        $notification = $this->sendNotification($user['email']);

        return response()->json(
            [
                'isSuccess'     => true,
                'message'       => 'El request test ha sido creado con exito!.',
                'status'        => 200,
                'Notification'  => $notification,
                'objects'       => $data,
            ]
        );*/
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
            RequestTest::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status'    => 400,
                    'message'   => 'No se encontro RequestTest para eliminar',
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
                'message'   => 'El request test ha sido eliminado!.',
                'status'    => 200,
            ]
        );
    }

    /**
     * Muestra mi Request Test donde coincida el id del usuario y el type (Sample Test)
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function myRequestTest($id)
    {

        try {
            // $data = new RequestTestCollection(RequestTest::where('user_id', $id)->get());
            $data = new MyOrderCollection(MyOrder::where('user_id', $id)->where('type', 'SAMPLE TEST')->get());

            if ($data->isEmpty()) {
                return response()->json(
                    [
                        'isSuccess' => true,
                        'status'    => 200,
                        'message'   => 'No se encontro data',
                        'objects'   => $data
                    ]
                );
            }
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
                'message'   => '',
                'objects'   => $data
            ]
        );
    }

     /**
     * Muestra mi Request Test
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function myRequestTestDropshiper($id)
    {
        try {
            $data = new RequestTestCollection(RequestTest::where('user_id', $id)->get());
            if ($data->isEmpty()) {
                return response()->json(
                    [
                        'isSuccess' => true,
                        'status'    => 200,
                        'message'   => 'No se encontro data',
                        'objects'   => $data
                    ]
                );
            }
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
                'message'   => '',
                'objects'   => $data
            ]
        );
    }

    private function sendNotification($email)
    {
        try {
            // Usando queue en lugar de send, el correo se envia en segundo plano!
            Mail::to($email)->queue(new \App\Mail\SeparateInventory());
        } catch (\Exception $e) {
            return 'Error al mandar la notificacion';
        }

        return 'Notificacion enviada con exito';
    }
}
