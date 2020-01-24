<?php

namespace App\Http\Controllers;

use App\ImportList;
use App\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Tymon\JWTAuth\Facades\JWTAuth;

class ImportListController extends Controller
{
    /**
     * Muestra los productos de Mi lista de importacion
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $user = $this->getAuthenticatedUser();
            $data = ImportList::where('user_id', $user->id)->get();

            // ImportList Array
            $il = [];

            foreach ($data as $d) {
//                array_push($il, $d->product_id);
                $product = Product::where('id', $d->product_id)->get();
                $product[0]['id'] = $d->id;
                array_push($il, $product[0]);

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

            $object = ['user_id' => $user->id, 'products' => $il];

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

    /**
     * Agrega producto a mi lista de importacion
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $user = $this->getAuthenticatedUser();
            $data = ImportList::create(
              [
                'user_id'      => $user->id,
                'product_id'   => $request->product_id,
                'variation_id' => $request->variation_id,
                'date_imported_store' => now()
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
            'message'   => 'La lista de importacion ha sido creada con exito!.',
            'status'    => 200,
            'objects'   => $data,
          ]
        );
    }

    /**
     * Actualiza los productos de mi lista de importacion
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
     * Elimina producto de mi lista de importacion usando el id del producto
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function delete($id)
    {

        try {
            ImportList::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(
              [
                'isSuccess' => false,
                'status'    => 400,
                'message'   => 'No se producto en lista de importacion para eliminar',
                'error'     => $e
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
