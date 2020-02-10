<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Department;
use App\City;
use App\Trajectory;

class TrajectoriesImport implements ToCollection
{


    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            User::create([
                'name' => $row[0],
            ]);
        }
    }

    private function existeString($buscar, $opcion)
    {
        return $opcion == $buscar ? true : false;
    }
}
