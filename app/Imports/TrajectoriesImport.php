<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TrajectoriesImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {

        }
    }
}