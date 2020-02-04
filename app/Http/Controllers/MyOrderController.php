<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyOrderCollection;
use App\Mail\MyOrder as MailMyOrder;
use App\MyOrder;
use App\Product;
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

            $user = User::findOrFail($request->user_id);
            $wallet = $user->wallet;
            $product = Product::findOrFail($request->product_id);

            // Valida que el saldo en la wallet sea mayor al total de la orden
            if ($request->total_order > $wallet->amount) {
                return response()->json(
                  [
                    'isSuccess' => false,
                    'message'   => 'No posee saldo suficiente en la wallet',
                    'status'    => 400,
                  ]
                );
            }

            // Valida que la colicitud de producto sea menor a la existencia en stock
            if ($request->quantity > $product->stock) {
                return response()->json(
                  [
                    'isSuccess' => false,
                    'message'   => 'No posee producto suficiente en stock',
                    'status'    => 400,
                  ]
                );
            }

            $data = MyOrder::create($request->all());

            // Actualiza el saldo de la wallet
            $newSaldo = $wallet->amount - $request->total_order;
            $wallet->amount = $newSaldo;
            $wallet->save();

            // Actualiza el stock de producto
            $newStock = $product->stock - $request->quantity;
            $product->stock = $newStock;
            $product->save();

        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'message'   => 'No se encontro registro',
                'status'    => 400,
                'error'     => $e
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

        $user = User::findOrFail($request->get('suplier_id'));
        $status = '';
        $notification = $this->sendNotification($user[ 'email' ], $status);

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
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {

            $data = MyOrder::findOrFail($id);
            $user = User::findOrFail($data->user_id);
            $supplier = User::findOrFail($data->suplier_id);


            // Si es rechazado se repone el monto a la wallet
            if ($request->status === 'RECHAZADO') {
                $wallet = $user->wallet;
                $newSaldo = $wallet->amount + $data->total_order;
                $wallet->amount = $newSaldo;
                $wallet->save();
            }

            $data->status = $request->status;
            $data->save();

            $this->sendNotification($user->email, $request->status);
            $this->sendNotification($supplier->email, $request->status);

        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'No se encontro registro',
                '$error'    => $e
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
            'message'   => 'La orden se ha actualizado con exito!.',
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

    private function sendNotification($email, $status)
    {
        try {
            // Usando queue en lugar de send, el correo se envia en segundo plano!
            Mail::to($email)->queue(new MailMyOrder($status));
        } catch (Exception $e) {
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
