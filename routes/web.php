<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ============================
// Halaman Percobaan
// ============================
Route::get('/hello', function () {
    return "Halo, ini halaman percobaan route!";
});

// ============================
// Halaman Utama & Dashboard
// ============================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================
// Profile Routes
// ============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================
// Jobs Routes
// ⚠️ Route spesifik HARUS di atas resource
// ============================

// Download template import (Admin Only)
Route::get('/jobs/template', [JobController::class, 'downloadTemplate'])
    ->name('jobs.template')
    ->middleware('isAdmin');

// Import data lowongan (Admin Only)
Route::post('/jobs/import', [JobController::class, 'import'])
    ->name('jobs.import')
    ->middleware('isAdmin');

// Resource routes untuk admin (create, edit, delete)
Route::resource('jobs', JobController::class)
    ->middleware(['auth', 'isAdmin'])
    ->except(['index', 'show']);

// Resource routes untuk user biasa (index, show)
Route::resource('jobs', JobController::class)
    ->middleware(['auth'])
    ->only(['index', 'show']);

// ============================
// Applications Routes
// ============================

// Export pelamar per lowongan (Admin Only)
Route::get('/applications/export/{job}', [ApplicationController::class, 'export'])
    ->name('applications.export')
    ->middleware('isAdmin');

// Download CV pelamar (Admin Only)
Route::get('/applications/{id}/download', [ApplicationController::class, 'download'])
    ->name('applications.download')
    ->middleware('isAdmin');

// Resource routes untuk admin (update, delete, etc.)
Route::resource('applications', ApplicationController::class)
    ->middleware(['auth', 'isAdmin'])
    ->except(['index', 'show']);

// Resource routes untuk user (lihat daftar pelamar)
Route::resource('applications', ApplicationController::class)
    ->middleware(['auth'])
    ->only(['index', 'show']);

// Lamar pekerjaan (user)
Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])
    ->name('apply.store')
    ->middleware('auth');

// Lihat pelamar per lowongan (Admin Only)
Route::get('/jobs/{job}/applicants', [ApplicationController::class, 'index'])
    ->name('applications.index')
    ->middleware('isAdmin');

// ============================
// Admin Dashboard
// ============================
Route::get('/admin', function () {
    return "Halaman Admin";
})->middleware(['auth', 'isAdmin']);

// ============================
// Auth routes
// ============================
require __DIR__.'/auth.php';
