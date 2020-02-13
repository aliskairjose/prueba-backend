<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;
use App\Product;
use App\ProductPhoto;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    /**
     * Importacion de data con excel
     * @return PendingDispatch|Excel|\Maatwebsite\Excel\Reader
     */
    public function import()
    {
        try {
            Excel::import(new ProductImport, request()->file('file'));
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
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = new ProductCollection(Product::all());

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

            $user = Product::getAuthenticatedUser();

            if ($request->type !== 'SIMPLE' && $request->type !== 'VARIABLE') {
                return response()->json(
                    [
                        'isSuccess' => false,
                        'status'    => 400,
                        'message'   => 'El tipo de producto, debe ser VARIABLE o SIMPLE',
                    ]
                );
            }

            $product = Product::create(
                [
                    'name'             => $request->name,
                    'description'      => $request->description,
                    'type'             => $request->type,
                    'stock'            => $request->stock,
                    'sale_price'       => $request->sale_price,
                    'suggested_price'  => $request->suggested_price,
                    'user_id'          => $user->id,
                    'privated_product' => $request->privated_product,
                    'active'           => $user->approve_product,
                    'sku'              => 'SP' . $user->id . $request->sku,
                    'weight'           => $request->weight,
                    'length'           => $request->length,
                    'width'            => $request->width,
                    'height'           => $request->height
                ]
            );

            foreach ($request->categories as $c) {
                $product->categories()->attach($c['id']);
            }

            if ($request->type === 'VARIABLE') {
                $variations = [];
                foreach ($request->variations as $d) {
                    $newVariation = $product->variations()->create([
                        'suggested_price' => $d['suggested_price'],
                        'sale_price'      => $d['sale_price'],
                        'stock'           => $d['stock'],
                    ]);
                    array_push($variations, $newVariation);
                }

                $product->variations = $variations;
            }

            if ($request->gallery) {
                $galleries = [];

                foreach ($request->gallery as $p) {
                    $path = $p->photo->store('public/images/products/' . $p->product_id);
                    $newPhoto = ProductPhoto::create(
                        [
                            'url'        => $path,
                            'main'       => $p->main,
                            'product_id' => $p->product_id
                        ]
                    );
                    array_push($galleries, $newPhoto);
                }
                $product->galley = $galleries;
            }

            if ($request->attribute) {
                $attributes = [];
                $values = [];

                foreach ($request->attribute as $a) {

                    $newAttribute = $product->attributes()->create([
                        'description' => $a['description']
                    ]);

                    array_push($attributes, $newAttribute);

                    foreach ($a['values'] as $value) {
                        $newValue = $newAttribute->attributeValues()->create([
                            'value' => $value['value']
                        ]);
                        array_push($values, $newValue);
                    }
                    $newAttribute->values = $values;
                }

                $product->attributes = $attributes;
            }
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
                'objects'   => $product
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
            $data = new ProductResource(Product::findOrFail($id));
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
     * Display the specified resource.
     *
     * @param  int  $id
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
                        'objects'   => $data
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
            $sku = $request->sku;

            $data = Product::findOrFail($id);
            $data = $request->name;
            $data = $request->description;
            $data = $request->type;
            $data = $request->stock;
            $data = $request->sale_price;
            $data = $request->suggested_price;
            $data = $request->user_id;
            $data = $request->privated_product;
            $data = $request->active;
            $data = $request->weight;
            $data = $request->length;
            $data = $request->width;
            $data = $request->height;

            if (Str::contains($request->sku, '-')) {
                $data->sku = $request->sku;
            } else {
                $data->sku = 'SP' . $request->user_id . '-SKU';
            }

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

            Product::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status'    => 400,
                    'message'   => 'No se encontro producto para eliminar',
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
                'message'   => 'El producto ha sido eliminado!.',
                'status'    => 200,
            ]
        );
    }

    public function filters(Request $request)
    {
        $data = Product::keyword($request->keywords)->category($request->category)->rango($request->minPrice, $request->maxPrice)->ordenar($request->sortBy);
        return response()->json(
            [
                'isSuccess' => true,
                'status'    => 200,
                'count'     => $data->count(),
                'objects'   => $data
            ]
        );
    }
}
