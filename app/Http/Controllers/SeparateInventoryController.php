<?php

namespace App\Http\Controllers;

use App\HistoryWallet;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\SeparateInventory as SeparateInventoryResource;
use App\Http\Resources\SeparateInventoryCollection;
use App\Product;
use App\SeparateInventory;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class SeparateInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {

        $data = new SeparateInventoryCollection(SeparateInventory::all());

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
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
//            $user = $this->getAuthenticatedUser();

            $user = User::findOrFail($request->user_id);
            $wallet = $user->wallet;

            $product = Product::findOrFail($request->product_id);
            $total = $request->quantity * $product->sale_price;

            // Valida que el usuario tenga saldo suficiente en la wallet
            if ($total > $wallet->amount) {
                return response()->json(
                  [
                    'isSuccess' => false,
                    'message'   => 'No posee saldo suficiente en la wallet',
                    'status'    => 400,
                  ]
                );
            }

            // Valida que la solicitud de producto sea menor a la existencia en stock
            if ($request->quantity > $product->stock) {
                return response()->json(
                  [
                    'isSuccess' => false,
                    'message'   => 'No posee producto suficiente en stock',
                    'status'    => 400,
                  ]
                );
            }

            $data = SeparateInventory::create(
              [
                'user_id'      => $user->id,
                'suplier_id'   => $request->supplier_id,
                'status'       => $request->status,
                'quantity'     => $request->quantity,
                'product_id'   => $request->product_id,
                'variation_id' => $request->variation_id
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

        // Actualiza el saldo de la wallet
        $newSaldo = $wallet->amount - $request->total_order;
        $wallet->amount = $newSaldo;
        $wallet->save();

        // Actualiza el stock de producto
        $newStock = $product->stock - $request->quantity;
        $product->stock = $newStock;
        $product->save();

        // Crea registro en History Wallet
        HistoryWallet::create(
          [
            'wallet_id' => $wallet->id,
            'amount'    => $wallet->amount,
            'status'    => 'PENDIENTE',
            'type'      => 'Type'
          ]
        );

        $user = User::findOrFail($request->get('user_id'));
        $notification = $this->sendNotification($user[ 'email' ]);

        return response()->json(
          [
            'isSuccess'    => true,
            'message'      => 'Se ha creado con exito!.',
            'status'       => 200,
            'Notification' => $notification,
            'objects'      => $data,
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
            $data = new SeparateInventoryResource((SeparateInventory::findOrFail($id)));
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

    public function dropshipperProducts($id)
    {
        try {
            $data = DB::table('separate_inventories')
                      ->select('product_id')
                      ->where('user_id', '=', $id)
                      ->get();
            $products_id = [];

            foreach ($data as $d) {
                array_push($products_id, $d->product_id);
            }

            $products = new ProductCollection(Product::whereIn('id', $products_id)->get());

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
            'objects'   => $products
          ]
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function myProducts($id)
    {
        try {
            $data = new SeparateInventoryCollection(SeparateInventory::where('user_id', $id)->get());
            if (count($data) === 0) {
                return response()->json(
                  [
                    'isSuccess' => true,
                    'message'   => 'No se encontro inventario separado',
                    'status'    => 200,
                    'objects'   => $data
                  ]
                );
            }
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => $e
              ]
            );
        }

        return response()->json(
          [
            'isSuccess' => true,
            'status'    => 200,
            'count'     => count($data),
            'objects'   => $data
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
            SeparateInventory::findOrFail($id)->update($request->all());

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
            'message'   => 'Se ha actualizado con exito!.',
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
            SeparateInventory::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'No se encontro Separate Inventory para eliminar',
              ]
            );
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'Ha ocurrido un error inesperado',
              ]
            );
        }

        return response()->json(
          [
            'isSuccess' => true,
            'message'   => 'Se ha eliminado con exito!.',
            'status'    => 200,
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
