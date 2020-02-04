<?php

namespace App\Http\Controllers;

use App\Http\Resources\WithdrawalRequestCollection;
use App\WithdrawalRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class WithdrawalRequestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = new WithdrawalRequestCollection(WithdrawalRequest::all());

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
            $data = WithdrawalRequest::create($request->all());
        }
        catch (Exception $e) {
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

}
