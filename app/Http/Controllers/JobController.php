<?php

namespace App\Http\Controllers;

use App\Exports\JobTemplateExport;
use App\Imports\JobsImport;
use Illuminate\Http\Request;
// use Illuminate\Queue\Jobs\Job;
use App\Models\JobVacancy as Job;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class JobController extends Controller
{
    public function index() {
        // return "Daftar Lowongan Kerja";
        $jobs = Job::all();
        return view('jobs.index', compact('jobs'));
    }

    public function create() {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'logo' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'company' => $request->company,
            'salary' => $request->salary,
            'job_type' => $request->job_type,
            'logo' => $logoPath
        ]);

        return redirect()->route('jobs.index')->with('success', 
        'Lowongan berhasil ditambahkan');
    }

    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        // 1. Validasi data (logo tidak 'required' saat update)
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'company' => 'required',
            'logo' => 'image|mimes:jpg,png,jpeg|max:2048' // 'logo' tetap divalidasi JIKA ada
        ]);

        // 2. Siapkan data untuk di-update
        $data = $request->only('title', 'description', 'location', 'company', 'salary', 'job_type');

        // 3. Cek jika ada file logo BARU yang di-upload
        if ($request->hasFile('logo')) {
            
            // 4. Hapus logo LAMA (jika ada)
            if ($job->logo) {
                Storage::delete('public/' . $job->logo);
            }

            // 5. Simpan logo BARU dan masukkan path-nya ke data
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // 6. Update data lowongan di database
        $job->update($data);

        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil diperbarui');
    }

    public function destroy(Job $job)
    {
        // 1. Cek jika lowongan ini punya logo
        if ($job->logo) {
            Storage::delete('public/' . $job->logo);
        }
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Lowongan berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        Excel::import(new JobsImport, $request->file('file'));
        return back()->with('success', 'Data lowongan berhasil diimport');
    }

    public function downloadTemplate()
    {
        return Excel::download(new JobTemplateExport, 'job_import_template.xlsx');
    }
}
