<?php

namespace App\Imports;

use App\Models\JobVacancy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new JobVacancy([
            'title' => $row['title'],
            'description' => $row['description'],
            'location' => $row['location'],
            'company' => $row['company'],
            'salary' => $row['salary'],
            'job_type' => $row['job_type'] ?? null,
        ]);
    }
}
