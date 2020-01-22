<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImportListCollection;
use App\ImportList;
use App\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ImportListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = new ImportListCollection(ImportList::all());

        return response()->json([
          [
            'isSuccess' => true,
            'count'     => $data->count(),
            'status'    => 200,
            'objects'   => $data,
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
            $data = ImportList::create($request->all());
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
            'message'   => 'La lista de importacion ha sido creada con exito!.',
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

        // return ImportList::findOrFail($id);
        try {
            $data = ImportList::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => true,
                'status'    => 200,
                'message'   => 'No se encontro coincidencia',
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
            $data = ImportList::findOrFail($id);
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
    public function delete(Request $request)
    {

        try {
            $user = $request->user_id;
            $product = $request->product_id;
            $data = new ImportListCollection(ImportList::where('user_id', $user)->where('product_id', $product)->get());
            $idImportList = $data[ 0 ][ 'id' ];
            $importDelete = ImportList::where('id', $idImportList)->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'No se encontro lista de importacion para eliminar',
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
            'message'   => 'El producto ha sido eliminado!.',
            'status'    => 200,
            'deletes'   => $importDelete
          ]
        );
    }

    public function myImportList($id)
    {

        try {
            $user = $this->getAuthenticatedUser();
            $data = ImportList::where('user_id', $user->id)->get();

            // ImportList Array
            $il = [];

            foreach ($data as $d) {
                array_push($il, $d->product_id);
            }

            if ($data->isEmpty()) {
                return response()->json(
                  [
                    'isSuccess' => true,
                    'status'    => 200,
                    'message'   => 'No se encontro data',
                    'objects'   => $data
                  ]
                );
            }

            $object = [];
            $il_products = Product::whereIn('id', $il)->get();
            $object = ['user_id' => $id, 'products' => $il_products];

        } catch (Exception $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'Ha ocurrido un error inesperado',
                'error'     => $e
              ]
            );
        }
        return response()->json(
          [
            'isSuccess' => true,
            'status'    => 200,
            'objects'   => $object,
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
