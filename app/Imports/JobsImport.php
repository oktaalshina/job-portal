<?php

namespace App\Imports;

use App\Models\Job;
use Maatwebsite\Excel\Concerns\ToModel;

class JobsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Job([
            'title' => $row[0],
            'description' => $row[1],
            'location' => $row[2],
            'company' => $row[3],
            'salary' => $row[4],
        ]);
    }
}
