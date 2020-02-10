<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TrajectoriesImport implements ToCollection
{


    public function collection(Collection $rows)
    {
        var_dump($rows);

    }

    private function existeString($buscar, $opcion)
    {
        return $opcion == $buscar ? true : false;
    }
}
