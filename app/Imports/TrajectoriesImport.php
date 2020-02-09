<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Department;
use App\City;
use App\Trajectory;

class TrajectoriesImport implements ToCollection
{
    protected $tipo_tarifa;

    public function  __construct($tipo_tarifa)
    {
        $this->tipo_tarifa = $tipo_tarifa;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $cont = 0;
        foreach ($collection as $row) {
            if ($cont > 0) {

                $implodeDep = explode('-', $row[8]);

                if (count($implodeDep) == 2) {

                    $name_dep = trim(strtoupper($implodeDep[1]));
                    //si el encoding no es utf8 entonces lo codifico

                    if (mb_detect_encoding($name_dep, 'UTF-8', true) == false) {
                        $name_dep = utf8_encode($name_dep);
                    }
                    $departamento = Department::firstOrCreate(
                        ['name' => $name_dep],
                        ['country_id' => 1]
                    );

                    $name_city = trim(strtoupper($implodeDep[0]));
                    //si el encoding no es utf8 entonces lo codifico

                    if (mb_detect_encoding($name_city, 'UTF-8', true) == false) {
                        $name_city = utf8_encode($name_city);
                    }
                    $ciudad = City::firstOrCreate(
                        ['name' => $name_city, 'department_id' => $departamento->id]
                    );

                    if ($ciudad->rate_type == null || $ciudad->rate_type == '') {
                        $ciudad->rate_type = '{"0":"'.$this->tipo_tarifa.'"}';
                    } else {

                        $jsondecode = json_decode($ciudad->rate_type);
                        $encontro_sin_recaudo = false;
                        foreach ($jsondecode as $opcion) {
                            $encontro_sin_recaudo = $this->existeString($this->tipo_tarifa, $opcion);
                            if ($encontro_sin_recaudo == true) {
                                break;
                            } else {
                            }
                        }

                        if ($encontro_sin_recaudo == false) {
                            //si el registro que existia, estaba solo en "CON RECAUDO"
                            $jsondecode[1] = '';
                            $jsondecode[1] = $this->tipo_tarifa;
                        }

                        $ciudad->rate_type = json_encode($jsondecode);
                        $ciudad->trajectory_type = trim(strtoupper($row[12]));
                    }
                    $ciudad->save();

                }


            }
            $cont++;
        }
    }

    private function existeString($buscar, $opcion)
    {
        return $opcion == $buscar ? true : false;
    }
}
