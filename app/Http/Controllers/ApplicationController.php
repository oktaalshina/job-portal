<?php
namespace App\Http\Controllers;

use App\Exports\ApplicationsExport;
use App\Jobs\SendApplicationMailJob;
use App\Models\Application;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\JobAppliedMail;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewApplicationNotification;
use App\Models\User;

class ApplicationController extends Controller
{
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

    public function store(Request $request, $jobId)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        $application = Application::create([
            'user_id' => auth()->id(),
            'job_id' => $jobId,
            'cv' => $cvPath,
            'status' => 'Pending', // status awal
        ]);

        // //kirim email ke user
        // Mail::to(auth()->user()->email)
        // ->send(new JobAppliedMail($application->job, auth()->user()));

        // Ambil data job dan user
        $job = JobVacancy::findOrFail($jobId);
        $user = auth()->user();

        // \Log::info('User ID: ' . $user->id);
        // \Log::info('User Email: ' . $user->email);

        $job = JobVacancy::findOrFail($jobId);
        dispatch(new SendApplicationMailJob($job->id, auth()->id(), $application))
        ->delay(now()->addSeconds(1));

        $admin = User::where('role', 'admin')->first();
        $admin->notify(new NewApplicationNotification($application));

        return back()->with('success', 'Lamaran berhasil dikirim!');
    }

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
    public function create() {}
    public function show(string $id) {}
    public function edit(string $id) {}
    public function destroy(string $id) {}
}