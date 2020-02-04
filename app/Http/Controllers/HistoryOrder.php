<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\HistoryOrderCollection;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class HistoryOrder extends Controller
{

    public function store(Request $request)
    {
        try{
            $data = \App\HistoryOrder::create($request->all());
        }
        catch ( Exception $e)
        {
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
            'isSuccess'    => true,
            'message'      => 'El registro ha sido creado con exito!.',
            'status'       => 200,
            'objects'      => $data,
          ]
        );
    }
}
