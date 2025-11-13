<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function () {
    return "Halo, ini halaman percobaan route!";
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Jobs routes
Route::resource('jobs', JobController::class)
    ->middleware(['auth', 'isAdmin'])
    ->except(['index', 'show']);

Route::resource('jobs', JobController::class)
    ->middleware(['auth'])
    ->only(['index', 'show']);

// ⚠️ PENTING: Route spesifik HARUS di atas resource!
Route::get('/applications/export', [ApplicationController::class, 'export'])
    ->name('applications.export')
    ->middleware('isAdmin');

Route::post('/jobs/import', [JobController::class, 'import'])
    ->name('jobs.import')
    ->middleware('isAdmin');

// Applications routes
Route::resource('applications', ApplicationController::class)
    ->middleware(['auth', 'isAdmin'])
    ->except(['index', 'show']);

Route::resource('applications', ApplicationController::class)
    ->middleware(['auth'])
    ->only(['index', 'show']);

// Custom routes
Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])
    ->name('apply.store')
    ->middleware('auth');

Route::get('/jobs/{job}/applicants', [ApplicationController::class, 'index'])
    ->name('applications.index')
    ->middleware('isAdmin');

Route::get('/admin', function () {
    return "Halaman Admin";
})->middleware(['auth', 'isAdmin']);

require __DIR__.'/auth.php';