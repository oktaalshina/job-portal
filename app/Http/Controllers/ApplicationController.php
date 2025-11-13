<?php
namespace App\Http\Controllers;

use App\Exports\ApplicationsExport;
use App\Models\Application;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // ← Tambahkan ini

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // ← Hapus $jobId
    {
        $applications = Application::with('user', 'job')->get();
        return view('applications.index', compact('applications'));
    }
    
    // method praktikum
    // public function export() 
    // {
    //     return Excel::download(new ApplicationsExport, 'applications.xlsx');
    // }

    // method tugas/latihan nomor 7
    public function export($jobId)
    {
        return Excel::download(new ApplicationsExport($jobId), 'applications-' . $jobId . '.xlsx');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        Application::create([
            'user_id' => auth()->id(),
            'job_id' => $jobId,
            'cv' => $cvPath,
            'status' => 'Pending', // status awal
        ]);

        return back()->with('success', 'Lamaran berhasil dikirim!'); // ← Fixed typo
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Accepted,Rejected',
        ]);

        $application = Application::findOrFail($id);
        $application->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status pelamar berhasil diperbarui!');
    }

    public function download($id)
    {
        $application = Application::findOrFail($id);
        $filePath = storage_path('app/public/' . $application->cv);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File CV tidak ditemukan.');
        }

        return response()->download($filePath);
    }



    // Sisanya bisa dikosongkan atau dihapus
    public function create() {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function destroy(string $id) {}
}