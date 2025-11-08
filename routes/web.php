<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\ProfileController;

// =====================================
// HALAMAN UTAMA
// =====================================
Route::get('/', fn() => redirect('/mahasiswa'));

// =====================================
// ROUTES UNTUK SEMUA USER LOGIN (ADMIN & USER)
// =====================================
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Semua user login bisa melihat daftar data (read only)
    // 🧩 Pindahkan route 'create' ke atas agar tidak ketimpa oleh '/{id}'
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');

    // Fakultas dan Prodi (read only)
    Route::get('/fakultas', [FakultasController::class, 'index'])->name('fakultas.index');
    Route::get('/prodi', [ProgramStudiController::class, 'index'])->name('prodi.index');

    // Nilai (read only)
    Route::get('/mahasiswa/{id}/nilai', [NilaiController::class, 'showByMahasiswa'])->name('nilai.index');

    // API: Prodi berdasarkan Fakultas
    Route::get('/api/fakultas/{id}/prodi', [ProgramStudiController::class, 'byFakultas']);
});

// =====================================
// ROUTES KHUSUS UNTUK ADMIN (CRUD PENUH)
// =====================================
Route::middleware(['auth', 'admin'])->group(function () {

    // 🧠 PENTING: Tempatkan route 'create' sebelum '/{id}'
    Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');

    // CRUD Mahasiswa
    Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::get('/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

    // Batasi route /mahasiswa/{id} agar hanya angka
    Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show'])
        ->whereNumber('id')
        ->name('mahasiswa.show');

    // CRUD Nilai
    Route::get('/mahasiswa/{id}/nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
    Route::post('/mahasiswa/{id}/nilai', [NilaiController::class, 'store'])->name('nilai.store');
    Route::get('/mahasiswa/{id}/nilai/{nilai_id}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');
    Route::put('/mahasiswa/{id}/nilai/{nilai_id}', [NilaiController::class, 'update'])->name('nilai.update');
    Route::delete('/mahasiswa/{id}/nilai/{nilai_id}', [NilaiController::class, 'destroy'])->name('nilai.destroy');

    // CRUD Fakultas & Prodi
    Route::resource('fakultas', FakultasController::class)
        ->parameters(['fakultas' => 'fakultas'])
        ->except(['index']);

    Route::resource('prodi', ProgramStudiController::class)->except(['index']);
});

// =====================================
// PROFILE (dari Breeze)
// =====================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
