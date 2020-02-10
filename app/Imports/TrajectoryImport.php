<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TrajectoryImport implements ToCollection
{
    protected $rate_type;

    public function __construct($rate_type)
    {
        $this->rate_type = $rate_type; //tipo de tarifa
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

        $cont = 0;
        var_dump($cont);



    }

    private function existeString($buscar, $opcion)
    {
        return $opcion == $buscar ? true : false;
    }
}
