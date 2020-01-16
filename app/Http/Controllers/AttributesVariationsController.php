<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\AttributeVariation as AttributeVariationModel;
use App\Http\Resources\AttributesVariations as AttributeVariationResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AttributesVariationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = AttributeVariationModel::create($request->all());
        } catch (Exception $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'message'   => 'Ha ocurrido un error',
                    'status'    => 400,
                    'error' => $e
                ]
            );
        }

        return response()->json(
            [
                'isSuccess' => true,
                'message'   => 'El valor del atributo ha sido creado con exito!.',
                'status'    => 200,
                'objects'   => $data,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = new AttributeVariationResource((AttributeVariationModel::findOrFail($id)));
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
                'objects'   => $data,
                'status'    => 200
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $data = AttributeVariationModel::findOrFail($id);
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
