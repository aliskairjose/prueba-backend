<?php

namespace App\Http\Controllers;

use App\HistoryWallet;
use App\Http\Resources\MyOrderCollection;
use App\Mail\MyOrder as MailMyOrder;
use App\MyOrder;
use App\Product;
use App\SeparateInventory;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            $product = Product::findOrFail($request->product_id);
            $wallet = $user->wallet;
            $separateInventoy = SeparateInventory::where('product_id', $request->product_id)
                                                 ->where('user_id', $request->user_id)
                                                 ->get();

            if($request->amount > $wallet->amount)
            {
                return response()->json(
                  [
                    'isSuccess' => false,
                    'message'   => 'No posee saldo suficiente en la wallet',
                    'status'    => 400,
                  ]
                );
            }

            if ($product->stock > $request->quantity) {
                if ($separateInventoy->count > 0) {
                    $separateInventoy = $separateInventoy[ 0 ];
                    if ($separateInventoy->stock > $request->quantity) {
                        $separateInventoy->stock = $separateInventoy->stock - $request->quantity;
                        $separateInventoy->save();

                        // Actualiza el saldo en la wallet
                        $newSaldo = $wallet->amount - $request->total_order;
                        $wallet->amount = $newSaldo;
                        $wallet->save();
                    } else {
                        $newQuantity = $request->quantity - $separateInventoy->stock;

                        $separateInventoy->stock = 0;
                        $separateInventoy->save();

                        $product->stock = $product->stock - $newQuantity;
                        $product->save();

                        // Se calcula el nuevo monto a descontar usando el la nueva cantidad por el precio
                        $newAmount = $newQuantity * $request->price;

                        $wallet->amount = $wallet->amount - $newAmount;
                        $wallet->save();
                    }
                }

            } else {
                return response()->json(
                  [
                    'isSuccess' => false,
                    'message'   => 'No posee producto suficiente en stock',
                    'status'    => 400,
                  ]
                );
            }

            $data = MyOrder::create($request->all());

            // Crea registro en History Wallet
            HistoryWallet::create(
              [
                'wallet_id' => $wallet->id,
                'amount'    => $wallet->amount,
                'status'    => $request->status,
                'type'      => 'DESCUENTO'
              ]
            );


            \App\HistoryOrder::create(
              [
                'order_id' => $data->id,
                'user_id'  => $data->user_id,
                'status'   => $data->status
              ]
            );

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
                'message'   => $e->getMessage(),
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

            $uWallet = $user->wallet; // User wallet
            $sWallet = $supplier->wallet; // Supplier Wallet

            // Si es rechazado se repone el monto a la wallet
            if ($request->status === 'RECHAZADO') {

                $newSaldo = $uWallet->amount + $data->total_order;
                $uWallet->amount = $newSaldo;
                $uWallet->save();

                // Crea registro en History Wallet
                HistoryWallet::create(
                  [
                    'wallet_id' => $uWallet->id,
                    'amount'    => $data->total_order,
                    'status'    => $request->status,
                    'type'      => 'REINTEGRO'
                  ]
                );
            }

            // Cuando se entrega, al supplier se le carga a la wallet el sale_price del producto
            // y al dropshipper se le carga a la wallet el total_price de la orden menos el porcentaje
            if ($request->status === 'ENTREGADO' && $data->type === 'FINAL_ORDER') {

                $product = Product::findOrFail($data->product_id);

                // Retorna el monto de la comision y el porcentaje
                $resp = $this->calcularMonto($data->total_order);
                $amount = $data->total_order - $resp[ 'comision' ];
                $adminAmount = $resp[ 'comision' ];

                // Actualizo la waller del Dropshipper
                $uWallet->amount = $amount - $product->sale_price;
                $uWallet->save();

                // Actualizo la wallet del Supplier
                $sWallet->amount = $product->sale_price;
                $sWallet->save();

                // Crea registro en History Wallet
                HistoryWallet::create(
                  [
                    'wallet_id' => $uWallet->id,
                    'amount'    => $data->total_order,
                    'status'    => $request->status,
                    'type'      => 'ABONO'
                  ]
                );
            }

            \App\HistoryOrder::create(
              [
                'order_id' => $data->id,
                'user_id'  => $data->user_id,
                'status'   => $request->status
              ]
            );

            // Actualiza el status de la orden
            $data->status = $request->status;
            $data->save();

            // Envios de correos
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

    /**
     * Recibe el total de la orden y devuelve el porcentaje y el monto de la comision.
     * @param $total_order
     * @return array
     */
    private function calcularMonto($total_order)
    {
        if ($total_order <= 59000) {
            $comision = $total_order / 10;
            $porcentaje = 10;

            return $res = array(
              'comision'   => $comision,
              'porcentaje' => $porcentaje
            );
        }
        if ($total_order > 59000 && $total_order <= 99000) {
            $comision = $total_order / 8;
            $porcentaje = 8;

            return $res = array(
              'comision'   => $comision,
              'porcentaje' => $porcentaje
            );
        }
        if ($total_order > 99000) {
            $comision = $total_order / 6;
            $porcentaje = 6;

            return $res = array(
              'comision'   => $comision,
              'porcentaje' => $porcentaje
            );
        }
    }
}
