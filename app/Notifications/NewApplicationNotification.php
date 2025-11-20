<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification
{
    use Queueable;
    public $application;

    public function __construct($application)
    {
        $this->application = $application;
    }
    public function via(object $notifiable): array
    {
        return ['mail'];
    }
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Lamaran Baru Diterima')
            ->line('Ada lamaran baru untuk pekerjaan: ' .$this->application->job->title)
            ->line('Pelamar: ' .$this->application->user->name)
            ->line('Lihat Lamaran: ' .url('/applications'))
            ->action('Download CV', url('storage/' .$this->application->cv));
    }

}
