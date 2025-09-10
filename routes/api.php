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
use App\Http\Controllers\Api\V1\AuthController as V1AuthController;
use App\Http\Controllers\Api\V1\BabyController as V1BabyController;
use App\Http\Controllers\Api\V1\FeedingController as V1FeedingController;
use App\Http\Controllers\Api\V1\DiaperController as V1DiaperController;
use App\Http\Controllers\Api\V1\SleepController as V1SleepController;
use App\Http\Controllers\Api\V1\GrowthController as V1GrowthController;
use App\Http\Controllers\Api\V1\VaccineController as V1VaccineController;
use App\Http\Controllers\Api\V1\SettingsController as V1SettingsController;
use App\Http\Controllers\Api\V1\TimelineController as V1TimelineController;
use App\Http\Controllers\Api\V1\DashboardController as V1DashboardController;
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

// =========================
// API V1 (Mobile HanindyaMom)
// Prefix: /api/v1
// =========================
Route::prefix('v1')->group(function () {
    // Auth (public)
    Route::post('/auth/register', [V1AuthController::class, 'register']);
    Route::post('/auth/login', [V1AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [V1AuthController::class, 'logout']);

        // Babies
        Route::get('/babies', [V1BabyController::class, 'index']);
        Route::post('/babies', [V1BabyController::class, 'store']);
        Route::get('/babies/{id}', [V1BabyController::class, 'show']);
        Route::put('/babies/{id}', [V1BabyController::class, 'update']);
        Route::delete('/babies/{id}', [V1BabyController::class, 'destroy']);

        // Feeding
        Route::get('/feeding', [V1FeedingController::class, 'index']);
        Route::post('/feeding', [V1FeedingController::class, 'store']);
        Route::get('/feeding/{id}', [V1FeedingController::class, 'show']);
        Route::put('/feeding/{id}', [V1FeedingController::class, 'update']);
        Route::delete('/feeding/{id}', [V1FeedingController::class, 'destroy']);

        // Diapers
        Route::get('/diapers', [V1DiaperController::class, 'index']);
        Route::post('/diapers', [V1DiaperController::class, 'store']);
        Route::get('/diapers/{id}', [V1DiaperController::class, 'show']);
        Route::put('/diapers/{id}', [V1DiaperController::class, 'update']);
        Route::delete('/diapers/{id}', [V1DiaperController::class, 'destroy']);

        // Sleep
        Route::get('/sleep', [V1SleepController::class, 'index']);
        Route::post('/sleep', [V1SleepController::class, 'store']);
        Route::get('/sleep/{id}', [V1SleepController::class, 'show']);
        Route::put('/sleep/{id}', [V1SleepController::class, 'update']);
        Route::delete('/sleep/{id}', [V1SleepController::class, 'destroy']);

        // Growth
        Route::get('/growth', [V1GrowthController::class, 'index']);
        Route::post('/growth', [V1GrowthController::class, 'store']);
        Route::get('/growth/{id}', [V1GrowthController::class, 'show']);
        Route::put('/growth/{id}', [V1GrowthController::class, 'update']);
        Route::delete('/growth/{id}', [V1GrowthController::class, 'destroy']);

        // Vaccines
        Route::get('/vaccines', [V1VaccineController::class, 'index']);
        Route::post('/vaccines', [V1VaccineController::class, 'store']);
        Route::get('/vaccines/{id}', [V1VaccineController::class, 'show']);
        Route::put('/vaccines/{id}', [V1VaccineController::class, 'update']);
        Route::delete('/vaccines/{id}', [V1VaccineController::class, 'destroy']);

        // Settings
        Route::get('/settings', [V1SettingsController::class, 'show']);
        Route::put('/settings', [V1SettingsController::class, 'update']);

        // Timeline & Dashboard
        Route::get('/timeline', [V1TimelineController::class, 'index']);
        Route::get('/dashboard', [V1DashboardController::class, 'index']);
    });
});

