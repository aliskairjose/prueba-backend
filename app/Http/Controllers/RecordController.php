<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecordCollection;
use App\Http\Resources\Record as RecordResource;
use App\Record;
use Exception;
use Illuminate\Http\JsonResponse;
use JWTAuth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RecordController extends Controller
{

    public function index()
    {
        $data = new RecordCollection(Record::all());

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
            $data = Record::create($request->all());
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
                'message'   => 'El producto ha sido creado con exito!.',
                'status'    => 200,
                'objects'   => $data,
            ]
        );
    }

    /**
     * Muestra e Record de un usuario  por el id de usuario.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $user = $this->getAuthenticatedUser();
            $data = new RecordResource(Record::where('user_id', $user->id));
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
            Record::findOrFail($id)->update($request->all());
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
            Record::findOrFail($id)->delete();
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
                'message'   => 'El item ha sido eliminado!.',
                'status'    => 200,
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
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return $user;
    }
}
