<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FaceController;
use App\Http\Controllers\Api\JadwalAbsensiController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\PegawaiStrukturalApiController;
use App\Http\Controllers\Api\PegawaiJasaTidakLangsungApiController;
use App\Http\Controllers\Api\PegawaiJasaNonMedisApiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\KategoriIndeksJasaTidakLangsungController;
use App\Http\Controllers\KategoriIndeksJasaLangsungNonMedisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProporsiFairnessController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/register/verify-otp', [RegisterController::class, 'verifyOTP']);
Route::post('send-otp', [AuthController::class, 'sendOTP']);
Route::post('verify-otp', [AuthController::class, 'verifyOTP']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile']);
    Route::get('/history', [JadwalAbsensiController::class, 'historyAbsen']);

    Route::get('/dashboard', [JadwalAbsensiController::class, 'index']);
    Route::get('/jadwal-absensi/all', [JadwalAbsensiController::class, 'jadwal']);


    Route::post('/face/register', [FaceController::class, 'upload']);
    Route::post('/face/recognize', [FaceController::class, 'recognize']);
    Route::post('/face/verify', [FaceController::class, 'verify']);


    Route::get('/jadwal-absensi/belumAbsen', [JadwalAbsensiController::class, 'jadwalBelumAbsen']);

    Route::post('/absensi-masuk', [AbsensiController::class, 'clockIn']);
    Route::post('/absensi-keluar', [AbsensiController::class, 'clockOut']);


});

// Routes untuk ProporsiFairness
Route::prefix('proporsi-fairness')->group(function () {
    Route::get('/', [ProporsiFairnessController::class, 'index']);
    Route::post('/', [ProporsiFairnessController::class, 'store']);
    Route::get('/{id}', [ProporsiFairnessController::class, 'show']);
    Route::put('/{id}', [ProporsiFairnessController::class, 'update']);
    Route::delete('/{id}', [ProporsiFairnessController::class, 'destroy']);
});

// Routes untuk Pegawai Struktural API
Route::apiResource('pegawai-struktural', PegawaiStrukturalApiController::class);
Route::get('/indeks-struktural-options', [PegawaiStrukturalApiController::class, 'getIndeksOptions']);

// Routes untuk Pegawai Jasa Tidak Langsung API
Route::apiResource('pegawai-jasa-tidak-langsung', PegawaiJasaTidakLangsungApiController::class);
Route::get('/indeks-jasa-tidak-langsung-options', [PegawaiJasaTidakLangsungApiController::class, 'getIndeksOptions']);
Route::get('/kategori-jasa-tidak-langsung-options', [App\Http\Controllers\Api\IndeksJasaTidakLangsungApiController::class, 'getKategoriOptions']);

// Routes untuk Pegawai Jasa Non Medis API
Route::apiResource('pegawai-jasa-non-medis', PegawaiJasaNonMedisApiController::class);
Route::get('/indeks-jasa-non-medis-options', [PegawaiJasaNonMedisApiController::class, 'getIndeksOptions']);
Route::get('/kategori-jasa-non-medis-options', [App\Http\Controllers\Api\IndeksJasaLangsungNonMedisApiController::class, 'getKategoriOptions']);

Route::get('/pegawai-by-unit/{unitId}', [PegawaiController::class, 'getByUnit']);
Route::get('/jasa-by-kategori/{kategoriId}', [KategoriIndeksJasaTidakLangsungController::class, 'getByKategori']);
Route::get('/pegawai-info/{id}', [App\Http\Controllers\IndeksPegawaiController::class, 'getPegawaiInfo']);

