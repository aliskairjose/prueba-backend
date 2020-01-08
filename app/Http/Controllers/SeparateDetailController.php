<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeparateDetail as SeparateDetailResource;
use App\Http\Resources\SeparateDetailCollection;
use App\SeparateDetail;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeparateDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = new SeparateDetailCollection(SeparateDetail::all());

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
            $data = SeparateDetail::create($request->all());
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
            'message'   => 'El producto ha sido creado con exito!.',
            'status'    => 200,
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
            $data = new SeparateDetailResource((SeparateDetail::findOrFail($id)));
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
     * Display the specified resource by Separate Inventory ID.
     *
     * @param  int  $id
     * @return JsonResponse
     */

    public function getBySeparateInventoryId($id)
    {
        $data = new SeparateDetailResource(SeparateDetail::where('separate_inventory_id', $id)->get());
        return $data;
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
            $data = SeparateDetail::findOrFail($id);
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
            'message'   => 'EL producto se ha actualizado con exito!.',
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
            $data = SeparateDetail::find($id);
            $data->delete();
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
            'message'   => 'El producto ha sido eliminado!.',
            'status'    => 200,
          ]
        );
    }
}
