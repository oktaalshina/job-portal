<?php

namespace App\Jobs;

use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobAppliedMail;

class SendApplicationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $jobId;
    public $userId;

    public function __construct($jobId, $userId)
    {
        $this->jobId = $jobId;
        $this->userId = $userId;
    }

    public function handle()
    {
        \Log::info('Job starting', [
            'job_id' => $this->jobId,
            'user_id' => $this->userId
        ]);

        $jobVacancy = JobVacancy::find($this->jobId);
        $user = User::find($this->userId);

        if (!$user || !$jobVacancy) {
            \Log::error("Data not found", [
                'user_id' => $this->userId,
                'job_id' => $this->jobId,
                'user_exists' => User::where('id', $this->userId)->exists(),
                'job_exists' => JobVacancy::where('id', $this->jobId)->exists()
            ]);
            return;
        }

        // \Log::info('Sending email to: ' . $user->email);

        Mail::to($user->email)
            ->send(new JobAppliedMail($jobVacancy, $user));
    }
}