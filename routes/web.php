<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\IndexKategoriController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JadwalKerjaController;
use App\Http\Controllers\JamKerjaController;
use App\Http\Controllers\LaporanAbsensiController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MonitoringAbsensiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PegawaiMasterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Select2Controller;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SettingRadiusController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/faces/{filename}', function ($filename) {
    $path = storage_path('app/public/faces/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
});


Route::get('/wa',function(){
    $test = apiwa('085281411550','halo');

    if($test){
        print_r($test);
    }

});



Route::post('/send-otp', [DashboardController::class, 'sendOtp'])->name('send.otp');

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect('dashboard');
    });


    Route::get('/dashboard/getData', [DashboardController::class, 'getData'])->name('dashboard.getData');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    Route::get('/setting-radius', [SettingRadiusController::class, 'index'])->name('settings.radius');
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings/save-or-update', [SettingController::class, 'saveOrUpdateWebsiteProfile'])->name('settings.save-or-update');
    Route::resource('user', UserController::class);
    Route::resource('divisi', DivisiController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::post('/shift/{uuid}/update-jam', [ShiftController::class, 'updateJamKerja'])->name('shift.update_jam');

    // Export Shift
    Route::get('/shift/export', [ShiftController::class, 'export'])->name('shift.export');

    // Import Shift
    Route::post('/shift/import', [ShiftController::class, 'import'])->name('shift.import');

    Route::resource('shift', ShiftController::class);


    Route::get('/landmarks', [PegawaiMasterController::class, 'landmarks'])->name('pegawai_master.landmarks');

    Route::get('/pegawai-master/face', [PegawaiMasterController::class, 'face'])->name('pegawai_master.face');
    Route::post('/pegawai-master/face', [PegawaiMasterController::class, 'faceSave'])->name('pegawai_master.faceSave');
    Route::delete('/pegawai-master/faceDelete/{uuid}', [PegawaiMasterController::class, 'faceDelete'])->name('pegawai_master.faceDelete');
    Route::get('/pegawai-master/export-template', [PegawaiMasterController::class, 'export'])->name('pegawai_master.export');

    Route::get('/pegawai/export', [PegawaiController::class, 'export'])->name('pegawai.export');

    Route::resource('pegawai', PegawaiController::class);
    Route::resource('pegawai-master', PegawaiMasterController::class);


    Route::post('/jadwal-kerja/set', [JadwalKerjaController::class, 'set'])->name('jadwal-kerja.set');

    Route::get('/jadwal-kerja/export', [JadwalKerjaController::class, 'exportExcel'])->name('jadwal-kerja.export');
    Route::get('/jadwal-kerja/import', [JadwalKerjaController::class, 'import'])->name('jadwal-kerja.import');
    Route::post('/jadwal-absensi/import', [JadwalKerjaController::class, 'importExcel'])->name('jadwal-absensi.importExcel');


    Route::resource('/jadwal-kerja',JadwalKerjaController::class);
    Route::get('/absensi/detail',[AbsensiController::class,'detail'])->name('absensi.detail');
    Route::get('/absensi/count',[AbsensiController::class,'count'])->name('absensi.count');
    Route::resource('/absensi',AbsensiController::class);


    Route::get('/monitoring/detail', [MonitoringAbsensiController::class, 'detail'])->name('monitoring-absensi.detail');
    Route::get('/monitoring/absensi', [MonitoringAbsensiController::class, 'index'])->name('monitoring-absensi.index');





    Route::get('/jam-kerja/table', [JamKerjaController::class, 'table'])->name('jam-kerja.table');
    Route::get('/jam-kerja/export', [JamKerjaController::class, 'export'])->name('jam-kerja.export');
    Route::post('/jam-kerja/import', [JamKerjaController::class, 'import'])->name('jam-kerja.import');

    Route::resource('/jam-kerja',JamKerjaController::class);
    // Route::get('/jam-kerja', [JamKerjaController::class, 'index'])->name('jam-kerja.index');
    Route::get('/role/menu/create', [RoleController::class, 'createMenu'])->name('role.menu.create');
    Route::post('/role/menu/{id}', [RoleController::class, 'storeMenu'])->name('role.menu.store');

    Route::resource('role', RoleController::class);

    Route::post('/menu/reorder', [MenuController::class, 'reorder'])->name('menu.reorder');
    Route::post('/menu/update-order', [MenuController::class, 'updateOrder'])->name('menu.updateOrder');
    Route::resource('menu', MenuController::class);
    Route::post('/save-radius', [SettingRadiusController::class, 'store'])->name('radius.store');
    Route::delete('/delete-radius', [SettingRadiusController::class, 'destroy'])->name('radius.destroy');
    Route::post('/check-location', [SettingRadiusController::class, 'checkLocation'])->name('radius.checkLocation');


    Route::get('/select2/divisi', [Select2Controller::class, 'divisi'])->name('select2.divisi');
    Route::get('/select2/pegawai', [Select2Controller::class, 'pegawai'])->name('select2.pegawai');
    Route::get('/select2/pegawai-master', [Select2Controller::class, 'pegawaiMaster'])->name('select2.pegawaiMaster');
    Route::get('/select2/shift', [Select2Controller::class, 'shift'])->name('select2.shift');
    Route::get('/select2/jabatan', [Select2Controller::class, 'jabatan'])->name('select2.jabatan');

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/bulanan', [LaporanAbsensiController::class, 'bulanan'])->name('bulanan');
        Route::get('/getLaporanAbsensi', [LaporanAbsensiController::class, 'getLaporanAbsensi'])->name('getLaporanAbsensi');
        Route::get('/bulanan/pdf', [LaporanAbsensiController::class, 'printPdf'])->name('bulanan.pdf');

        Route::get('/keterlambatan', [LaporanAbsensiController::class, 'keterlambatan'])->name('keterlambatan');

        Route::get('/getLaporanKeterlambatan', [LaporanAbsensiController::class, 'getLaporanKeterlambatan'])->name('getLaporanKeterlambatan');

    });

    Route::resource('index-kategori', IndexKategoriController::class);
    Route::resource('index', IndexController::class);
    Route::post('/index/import', [IndexController::class, 'import'])->name('index.import');

    // Grade routes
    Route::get('grade', [GradeController::class, 'index'])->name('grade.index');
    Route::post('grade', [GradeController::class, 'store'])->name('grade.store');
    Route::get('grade/{id}', [GradeController::class, 'show'])->name('grade.show');
    Route::put('grade/{id}', [GradeController::class, 'update'])->name('grade.update');
    Route::delete('grade/{id}', [GradeController::class, 'destroy'])->name('grade.destroy');

    });

require __DIR__.'/auth.php';
