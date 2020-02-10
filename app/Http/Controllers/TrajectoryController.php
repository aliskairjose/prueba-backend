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

    public function loadsinrecaudo()
    {

        try {
            Excel::import(new TrajectoriesImport('SIN RECAUDO'), 'order/sinrecaudo.xlsx');
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

            Excel::import(new TrajectoriesImport('CON RECAUDO'), 'conrecaudo.xlsx');
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
}
