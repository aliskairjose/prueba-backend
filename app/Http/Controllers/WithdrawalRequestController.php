<?php

namespace App\Http\Controllers;

use App\HistoryWithdrawal;
use App\Http\Resources\WithdrawalRequest as WithdrawalRequestResource;
use App\Http\Resources\WithdrawalRequestCollection;
use App\WithdrawalRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class WithdrawalRequestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {

        if (isset($request->user_id)) {
            $data = new WithdrawalRequestCollection(
                WithdrawalRequest::where('user_id',$request->user_id)->orderBy('created_at', 'asc')->get()
            );
        }else{
            $data = new WithdrawalRequestCollection(WithdrawalRequest::orderBy('create_at', 'asc')->all());
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
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $data = new WithdrawalRequestResource(WithdrawalRequest::findOrFail($id));
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
                'objects'   => $data
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

            $user = $this->getAuthenticatedUser();

            $wallet = $user->wallet;

            // Valida que el usuario tenga saldo suficiente en la wallet
            if ($request->amount > $wallet->amount) {
                return response()->json(
                    [
                        'isSuccess' => false,
                        'message'   => 'No posee saldo suficiente en la wallet',
                        'status'    => 400,
                    ]
                );
            }


            $data = WithdrawalRequest::create(
                [
                    'amount'  => $request->amount,
                    'user_id' => $request->user_id,
                    'status'  => "PENDIENTE"
                ]
            );

            HistoryWithdrawal::create(
                [
                    'user_id'               => $user->id,
                    'amount'                => $request->amount,
                    'withdrawal_request_id' => $data->id,
                    'status'                => "PENDIENTE"
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

        return response()->json(
            [
                'isSuccess' => true,
                'message'   => 'El item ha sido creado con exito!.',
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
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {

            $data = WithdrawalRequest::findOrFail($id);
            $data->status = $request->status;
            $data->save();

            if($request->status === 'APROBADO'){
                $wallet = \App\Wallet::where('user_id', 1)->get();
                $wallet = $wallet[0];
                $wallet->amount = $wallet->amount - $data->amount;
                $wallet->save();
            }

            HistoryWithdrawal::create(
                [
                    'user_id'               => $data->user_id,
                    'amount'                => $data->amount,
                    'withdrawal_request_id' => $data->id,
                    'status'                => $request->status
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
                'message'   => 'EL status se ha actualizado con exito!.',
            ]
        );
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
