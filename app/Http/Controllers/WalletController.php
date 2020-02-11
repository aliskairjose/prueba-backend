<?php

namespace App\Http\Controllers;

use App\Http\Resources\Wallet as WalletResource;
use App\Wallet;
use App\Currency;
use App\Role;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Wallet::all();
        return response()->json(
            [
                'isSuccess' => true,
                'status' => 200,
                'objects' => $data
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {

            $data = Wallet::create($request->all());
        } catch (Exception $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'message' => 'Ha ocurrido un error',
                    'status' => 400,
                ]
            );
        }
        return response()->json(
            [
                'isSuccess' => true,
                'message' => 'El registro ha sido creado con exito!.',
                'status' => 200,
                'objects' => $data,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $data = new WalletResource(Wallet::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'message' => 'No se encontro registro',
                    'status' => 400,
                    'error' => $e
                ]
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'message' => 'Ha ocurrido un error',
                    'status' => 400,
                    'error' => $e
                ]
            );
        }

        return response()->json(
            [
                'isSuccess' => true,
                'status' => 200,
                'objects' => $data
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            Wallet::findOrFail($id)->update($request->all());
        } catch (Exception $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status' => 400,
                    'message' => $e,
                ]
            );
        }
        return response()->json(
            [
                'isSuccess' => true,
                'status' => 200,
                'message' => 'EL registro se ha actualizado con exito!.',
            ]
        );
    }

    public function addBalance(Request $request, $id)
    {

        try {
            $user = Wallet::getAuthenticatedUser();

            $rol= Role::where('id', $user->role_id)->first();
            if ($rol->name === 'ADMIN') {
                $currency = Currency::where('code', 'COP')->first();
                $wallet = Wallet::firstOrNew(['user_id' => $id, 'currency_id' => $currency->id]);
                $wallet->currency_id = $currency->id;

                if ($wallet->id) {
                    $wallet->amount = $wallet->amount + $request->amount;
                } else {
                    $wallet->user_id = $id;
                    $wallet->amount = $request->amount;
                }
                $wallet->currency_id = $currency->id;
                $wallet->save();
            } else {
                return response()->json(
                    [
                        'isSuccess' => false,
                        'status' => 400,
                        'message' => 'Solo el Admin puede agregar saldo'
                    ]
                );
            }
        } catch (Exception $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status' => 400,
                    'message' => $e,
                ]
            );
        }
        return response()->json(
            [
                'isSuccess' => true,
                'status' => 200,
                'message' => 'EL registro se ha actualizado con exito!.',
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
