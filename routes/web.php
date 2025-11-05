<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\ProfileController;

// Halaman utama -> redirect ke mahasiswa
Route::get('/', fn() => redirect('/mahasiswa'));

// =====================================
// ROUTES YANG TERPROTEKSI LOGIN
// =====================================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // =====================================
    // MAHASISWA
    // =====================================
    Route::resource('mahasiswa', MahasiswaController::class);

    // Tambahan: Detail Mahasiswa (Show)
    Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');

    // =====================================
    // NILAI (nested di bawah mahasiswa)
    // =====================================
    Route::get('/mahasiswa/{id}/nilai', [NilaiController::class, 'showByMahasiswa'])->name('nilai.index');
    Route::get('/mahasiswa/{id}/nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
    Route::post('/mahasiswa/{id}/nilai', [NilaiController::class, 'store'])->name('nilai.store');
    Route::get('/mahasiswa/{id}/nilai/{nilai_id}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');
    Route::put('/mahasiswa/{id}/nilai/{nilai_id}', [NilaiController::class, 'update'])->name('nilai.update');
    Route::delete('/mahasiswa/{id}/nilai/{nilai_id}', [NilaiController::class, 'destroy'])->name('nilai.destroy');

    // =====================================
    // FAKULTAS & PROGRAM STUDI
    // =====================================
    Route::resource('fakultas', FakultasController::class)
     ->parameters(['fakultas' => 'fakultas']);
    Route::resource('prodi', ProgramStudiController::class);

    // API: Prodi berdasarkan Fakultas
    Route::get('/api/fakultas/{id}/prodi', [ProgramStudiController::class, 'byFakultas']);
});

// =====================================
// PROFILE (dari Breeze)
// =====================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
