<?php

namespace App\Imports;

use App\Models\PlanContable;
use Maatwebsite\Excel\Concerns\ToModel;

class PlanContableImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PlanContable([
            //
        ]);
    }
}
