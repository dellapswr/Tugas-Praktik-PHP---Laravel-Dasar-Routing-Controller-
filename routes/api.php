<?php

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MahasiswaController as ApiMahasiswaController;
use App\Http\Controllers\Api\FakultasController as ApiFakultasController;
use App\Http\Controllers\Api\ProgramStudiController as ApiProgramStudiController;

// =====================================
// LOGIN API
// =====================================
Route::post('/login', [AuthController::class, 'login']);

// =====================================
// ROUTE UNTUK TEST POSTMAN TANPA LOGIN (non-CSRF)
// =====================================
// Route::get('/fakultas', [FakultasController::class, 'index']);
// Route::post('/fakultas', [FakultasController::class, 'store']);

// =====================================
// ROUTE YANG BUTUH AUTENTIKASI TOKEN (SANCTUM)
// =====================================
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // ✅ API MAHASISWA
    Route::apiResource('/mahasiswa', ApiMahasiswaController::class)->names([
        'index'   => 'api.mahasiswa.index',
        'store'   => 'api.mahasiswa.store',
        'show'    => 'api.mahasiswa.show',
        'update'  => 'api.mahasiswa.update',
        'destroy' => 'api.mahasiswa.destroy',
    ]);

    // ✅ API FAKULTAS
    Route::apiResource('/fakultas', ApiFakultasController::class)->names([
        'index'   => 'api.fakultas.index',
        'store'   => 'api.fakultas.store',
        'show'    => 'api.fakultas.show',
        'update'  => 'api.fakultas.update',
        'destroy' => 'api.fakultas.destroy',
    ]);

    // ✅ API PROGRAM STUDI
    Route::apiResource('/prodi', ApiProgramStudiController::class)->names([
        'index'   => 'api.prodi.index',
        'store'   => 'api.prodi.store',
        'show'    => 'api.prodi.show',
        'update'  => 'api.prodi.update',
        'destroy' => 'api.prodi.destroy',
    ]);

    // ✅ Dropdown Prodi berdasarkan Fakultas
    Route::get('/fakultas/{id}/prodi', function ($id) {
        return response()->json(Prodi::where('fakultas_id', $id)->get());
    })->name('api.fakultas.prodi');
});
