<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;



use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class TrajectoriesImport implements ToCollection
{
    protected $rate_type;

    public function __construct($rate_type='CON RECAUDO')
    {
        $this->rate_type = $rate_type; //tipo de tarifa
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $cont = 0;
        foreach ($collection as $row) {
            if ($cont > 0) {

                $implodeDep = explode('-', $row[8]); //ciudad y departamento destino

                if (count($implodeDep) == 2) {

                    $trajectory_1a3 = Trajectory::firstOrCreate(
                            [
                                'name' => trim(strtoupper($row[12])),
                                'rate_type' => $this->rate_type,
                                'from'=>'1.00',
                                'until'=>'3.00',
                            ]
                    );

                    $trajectory_1a3->price=trim(strtoupper($row[18]));
                    $trajectory_1a3->save();

                    $trajectory_4a12 = Trajectory::firstOrCreate(
                        [
                            'name' => trim(strtoupper($row[12])),
                            'rate_type' => $this->rate_type,
                            'from'=>'4.00',
                            'until'=>'12.00',
                        ]
                    );

                    $trajectory_4a12->price=trim(strtoupper($row[19]));
                    $trajectory_4a12->save();

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
                        $ciudad->rate_type = '["' . $this->rate_type . '"]';
                    } else {

                        $jsondecode = json_decode($ciudad->rate_type,true);
                        $encontro_tipo = false;
                        foreach ($jsondecode as $opcion) {
                            $encontro_tipo = $this->existeString($this->rate_type, $opcion);
                            if ($encontro_tipo == true) {
                                break;
                            }
                        }

                        if ($encontro_tipo == false) {
                            //si el registro que existia, estaba solo en el tipo que le pasé por correo
                            $jsondecode[1] = '';
                            $jsondecode[1] = $this->rate_type;
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
