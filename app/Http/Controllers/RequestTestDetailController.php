<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use App\Http\Resources\RequestTestDetail as RequestTestDetailResource;
use App\Http\Resources\RequestTestDetailCollection;
use App\RequestTestDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RequestTestDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = new RequestTestDetailCollection(RequestTestDetail::all());

        return response()->json([
          [
            'isSuccess' => true,
            'count'     => $data->count(),
            'status'    => 200,
            'objects'    => $data,
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
            $data = RequestTestDetail::create($request->all());
        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'message'   => 'Ha ocurrido un error',
                'status'    => 400,
              ]
            );
        }

        return response()->json(
          [
            'isSuccess' => true,
            'message'   => 'El request test ha sido creado con exito!.',
            'status'    => 200,
            'objects'      => $data,
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
            $data = new RequestTestDetailResource((RequestTestDetail::findOrFail($id)));
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
            $data = RequestTestDetail::findOrFail($id);
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
            $data = RequestTestDetail::findOrFail($id);
            $data->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'No se encontro RequestTestDetail para eliminar',
              ]
            );
        }
        catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'Ha ocurrido un erro inesperado',
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
}