<?php

namespace App\Http\Controllers;

use App\Department;
use App\City;
use App\Trajectory;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\City as CityResource;

use App\Http\Resources\CityCollection;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\TrajectoriesImport;

class CityController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
//        $data = Category::all();
        $data = new CityCollection(City::all());

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
            $data = City::create($request->all());

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
            $data = City::findOrFail($id)->update($request->all());
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
                'message'   => 'EL atributo se ha actualizado con exito!.',
                'objects'   => $data

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
            $data = City::findOrFail($id);
            $data[ 'products' ] = $data->products;
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
                'objects'   => $data
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
            City::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'isSuccess' => false,
                    'status'    => 400,
                    'message'   => 'No se encontro atributo para eliminar',
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
                'message'   => 'El item ha sido eliminado!.',
                'status'    => 200,
            ]
        );
    }


    public function loadsinrecaudo(){
        Excel::import(new TrajectoriesImport('SIN RECAUDO'), 'SIN_RECAUDO.xlsx');
    }

    public function loadconrecaudo(){
        Excel::import(new TrajectoriesImport('CON RECAUDO'), 'CON_RECAUDO.xlsx');
    }


}
