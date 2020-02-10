<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\City;
use App\Trajectory;

use App\Http\Resources\City as CityResource;
use App\Http\Resources\CityCollection;

use App\Http\Resources\TrajectoryCollection;
use App\Http\Resources\Trajectory as TrajectoryResource;

use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TrajectoriesImport;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;


class TrajectoryController extends Controller
{

    public function index()
    {
        $data = new TrajectoryCollection(Trajectory::all());

        return response()->json(
            [
                'isSuccess' => true,
                'count' => $data->count(),
                'status' => 200,
                'objects' => $data,
            ]
        );
    }

    public function deletedatatra()
    {
        Trajectory::where('id', '>', 0)->delete();
        City::where('id', '>', 0)->delete();
        Department::where('id', '>', 0)->delete();
        $data = new TrajectoryCollection(Trajectory::all());

        return response()->json(
            [
                'isSuccess' => true,
                'count' => $data->count(),
                'status' => 200,
                'objects' => $data,
            ]
        );
    }

    public function loadsinrecaudo()
    {

        try {
            Excel::import(new TrajectoriesImport('SIN RECAUDO'), request()->file('file'));
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
    }

    public function loadconrecaudo()
    {

        try {
            Excel::import(new TrajectoriesImport('CON RECAUDO'), request()->file('file'));
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
    }

    public function bycity(Request $request)
    {

        $data = new CityCollection(City::where('rate_type', 'LIKE', "%".$request->rate_type."%")->get());

        // ImportList Array
        $il = [];

        foreach ($data as $row) {
            $city = City::findOrFail($row->id);
            $city->precios = new TrajectoryCollection(Trajectory::where(['rate_type'=>$request->rate_type,'name'=>$row->trajectory_type])->get());

            array_push($il, $city);
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

        $object = ['cities' => $il];

        return response()->json(
            [
                'isSuccess' => true,
                'status' => 200,
                'objects' => $object,
            ]
        );
    }
}
