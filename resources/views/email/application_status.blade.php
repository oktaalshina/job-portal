<!DOCTYPE html>
<html>
<head>
    <title>Status Lamaran</title>
</head>
<body>
    <h2>Halo {{ $application->user->name }},</h2>

    @if($status === 'Accepted')
        <p>Selamat! Lamaran Anda untuk posisi <b>{{ $application->job->title }}</b> di {{ $application->job->company }} diterima.</p>
    @else
        <p>Mohon maaf, lamaran Anda untuk posisi <b>{{ $application->job->title }}</b> di {{ $application->job->company }} belum diterima.</p>
    @endif

    <p>Terimakasih telah melamar di {{ config('app.name') }}.</p>
    <p>Salam,</p>
    <p><b>Tim HR {{ config('app.name') }}</b></p>
</body>
</html>