<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicationsExport implements FromCollection, WithHeadings
{
    protected $jobId;

    public function __construct($jobId)
    {
        $this->jobId = $jobId;
    }
    /**
    * @ return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // code praktikum
        // return Application::all();

        // code tugas/latihan nomor 7
        return Application::with('user', 'job')
            ->where('job_id', $this->jobId)
            ->get()
            ->map(function($app) {
                return [
                    'Nama Pelamar' => $app->user->name,
                    'Lowongan' => $app->job->title,
                    'Status' => $app->status,
                    'Tanggal Lamar' => $app->created_at->format('d-m-Y'),
                ];
            }); 
    }

    public function headings(): array 
    {
        return [
            'Nama pelamar',
            'Lowongan',
            'Status',
            'Tanggal Lamar',
        ];
    }
}
