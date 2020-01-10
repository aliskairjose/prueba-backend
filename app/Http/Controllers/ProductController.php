<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\Product as ProductResource;
use App\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = new ProductCollection(Product::all());

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
            $data = Product::create($request->all());
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
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $data = new ProductResource((Product::findOrFail($id)));
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
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function myProducts($id)
    {
        try {
            $data = new ProductCollection(Product::where('user_id', $id)->get());
            if (count($data) === 0) {
                return response()->json(
                    [
                        'isSuccess' => true,
                        'message'   => 'No existen producto asignados al usuario',
                        'status'    => 200,
                        'objects'    => $data
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
                'objects'    => $data
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
            $data = Product::findOrFail($id);
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
            $data = Product::findOrFail($id);
            $data->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status'    => 400,
                    'message'   => 'No se encontro producto para eliminar',
                ]
            );
        }
        catch (Exception $e) {
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
