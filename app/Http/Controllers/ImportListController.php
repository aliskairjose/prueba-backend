<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttributeCollection;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductPhotoCollection;
use App\Http\Resources\VariationCollection;
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
                $product = Product::findOrFail($d->product_id);
                $prod_res = new ProductResource(Product::findOrFail($d->product_id));
                $product->id = $d->id;
                $product->name = $d->product_name;
                $product->product_id = $d->product_id;
                $product->attributes = new AttributeCollection($prod_res->attributes);

                $product->variations = new VariationCollection($prod_res->variations);

                $product->gallery = new ProductPhotoCollection($prod_res->photos);
                $product->categories = $prod_res->categories;
                $product->imported_to_store = $d->imported_to_store;
                $product->woocomerse_url = $d->woocomerse_url;
                $product->woocomerse_id = $d->woocomerse_id;
                array_push($il, $product);
                // array_push($il, $prod_res);
            }

            if ($data->isEmpty()) {
                return response()->json(
                    [
                        'isSuccess' => true,
                        'status' => 200,
                        'message' => 'No se encontró data',
                        'objects' => $data
                    ]
                );
            }

            $object = ['user_id' => $user->id, 'products' => $il];

        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status' => 400,
                    'error' => $e
                ]
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status' => 400,
                    'message' => 'Ha ocurrido un error inesperado',
                    'error' => $e
                ]
            );
        }
        return response()->json(
            [
                'isSuccess' => true,
                'status' => 200,
                'objects' => $object,
            ]
        );
    }

    /**
     * Agrega producto a mi lista de importacion
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $user = $this->getAuthenticatedUser();
            $product = Product::find($request->product_id);
            $data = ImportList::create(
                [
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                    'variation_id' => $request->variation_id,
                    'woocomerse_url' => isset($request->woocomerse_url)?$request->woocomerse_url:null,
                    'woocomerse_id' => isset($request->woocomerse_id)?$request->woocomerse_id:null,
                    'product_name' => $product->name,
                    'date_imported_store' => now()
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
                'message' => 'La lista de importacion ha sido creada con exito!.',
                'status' => 200,
                'objects' => $data,
            ]
        );
    }

    /**
     * Actualiza los productos de mi lista de importacion
     *
     * @param  Request $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            ImportList::findOrFail($id)->update($request->all());
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'isSuccess' => true,
                    'status' => 200,
                    'message' => 'No se encontro registro!.',
                ]
            );
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
                'message' => 'EL producto se ha actualizado con exito!.',
            ]
        );
    }

    /**
     * Elimina producto de mi lista de importacion usando el id del producto
     *
     * @param  int $id
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
                    'status' => 400,
                    'message' => 'No se producto en lista de importacion para eliminar',
                    'error' => $e
                ]
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status' => 400,
                    'message' => 'Ha ocurrido un error inesperado',
                ]
            );
        }

        return response()->json(
            [
                'isSuccess' => true,
                'message' => 'El producto ha sido eliminado!.',
                'status' => 200,
            ]
        );
    }


    /**
     * @param  Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateImportedToStore(Request $request, $id)
    {

        try {
            ImportList::findOrFail($id)->update($request->all());
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'isSuccess' => true,
                    'status' => 200,
                    'message' => 'No se encontro registro!.',
                ]
            );
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
                'message' => 'El registro se ha actualizado con exito!.',
            ]
        );

    }

    /**
     * Actualiza el nombre del producto solo en la lista de importación
     * @param  Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateProductName(Request $request, $id)
    {
        try {
            $data = ImportList::find($id);
            $data->product_name = $request->product_name;
            $data->save();
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status' => 400,
                    'message' => $e,
                ]
            );
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
                'message' => 'Item actualizado',
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
