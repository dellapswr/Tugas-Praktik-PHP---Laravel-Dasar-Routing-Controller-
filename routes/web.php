<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProgramStudiController;

// Halaman utama langsung ke daftar mahasiswa
Route::get('/', fn() => redirect('/mahasiswa'));

// ===============================
// ROUTE MAHASISWA
// ===============================
Route::resource('mahasiswa', MahasiswaController::class);

// ===============================
// ROUTE NILAI
// ===============================
Route::get('/mahasiswa/{id}/nilai', [NilaiController::class, 'showByMahasiswa'])->name('nilai.index');
Route::get('/mahasiswa/{id}/nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
Route::post('/mahasiswa/{id}/nilai', [NilaiController::class, 'store'])->name('nilai.store');
Route::get('/mahasiswa/{id}/nilai/{nilai_id}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');
Route::put('/mahasiswa/{id}/nilai/{nilai_id}', [NilaiController::class, 'update'])->name('nilai.update');
Route::delete('/mahasiswa/{id}/nilai/{nilai_id}', [NilaiController::class, 'destroy'])->name('nilai.destroy');

// ===============================
// ROUTE FAKULTAS & PRODI
// ===============================
Route::resource('fakultas', FakultasController::class)->parameters(['fakultas' => 'fakultas']);
Route::resource('prodi', ProgramStudiController::class);

// ===============================
// API: Ambil Prodi per Fakultas
// ===============================
Route::get('/api/fakultas/{id}/prodi', [ProgramStudiController::class, 'byFakultas']);