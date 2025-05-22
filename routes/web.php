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
use App\Http\Controllers\ProporsiFairnessController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Select2Controller;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SettingRadiusController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SumberController;
use App\Http\Controllers\RemunerasiBatchController;
use App\Http\Controllers\RemunerasiSourceController;
use App\Http\Controllers\DetailSourceController;
use App\Http\Controllers\PembagianKlaimController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\PendaftaranController;
use App\Models\PegawaiMaster;
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

    // Remunerasi Batch routes
    Route::get('remunerasi-batch', [RemunerasiBatchController::class, 'index'])->name('remunerasi-batch.index');
    Route::post('remunerasi-batch', [RemunerasiBatchController::class, 'store'])->name('remunerasi-batch.store');
    Route::get('remunerasi-batch/{id}', [RemunerasiBatchController::class, 'show'])->name('remunerasi-batch.show');
    Route::put('remunerasi-batch/{id}', [RemunerasiBatchController::class, 'update'])->name('remunerasi-batch.update');
    Route::delete('remunerasi-batch/{id}', [RemunerasiBatchController::class, 'destroy'])->name('remunerasi-batch.destroy');

    // Remunerasi Source routes
    Route::get('remunerasi-source', [RemunerasiSourceController::class, 'index'])->name('remunerasi-source.index');
    Route::get('remunerasi-source/addbyidxdaftar', [RemunerasiSourceController::class, 'addSourcebyidxdaftar'])->name('remunerasi-source.addSourcebyidxdaftar');
    Route::post('remunerasi-source', [RemunerasiSourceController::class, 'store'])->name('remunerasi-source.store');
    
    // Import Admission routes
    Route::get('remunerasi-source/import-admission', [RemunerasiSourceController::class, 'importAdmission'])->name('remunerasi-source.import-admission');
    Route::post('remunerasi-source/store-from-admission', [RemunerasiSourceController::class, 'storeFromAdmission'])->name('remunerasi-source.store-from-admission');
    
    // Resource routes with parameters
    Route::get('remunerasi-source/{id}', [RemunerasiSourceController::class, 'show'])->name('remunerasi-source.show');
    Route::put('remunerasi-source/{id}', [RemunerasiSourceController::class, 'update'])->name('remunerasi-source.update');
    Route::delete('remunerasi-source/{id}', [RemunerasiSourceController::class, 'destroy'])->name('remunerasi-source.destroy');
    
    Route::get('admission/list', [RemunerasiSourceController::class, 'getAdmissionList'])->name('admission.list');

    // List source by batch
    Route::get('remunerasi-batch/{id}/sources', [RemunerasiSourceController::class, 'listByBatch'])->name('remunerasi-source.list-by-batch');
    Route::get('remunerasi-batch/{id}/sources/data', [RemunerasiSourceController::class, 'getByBatch'])->name('remunerasi-source.by-batch');

    // Proporsi Fairness routes
    Route::get('proporsi-fairness/export', [ProporsiFairnessController::class, 'export'])->name('proporsi-fairness.export');
    Route::get('proporsi-fairness/template/download', [ProporsiFairnessController::class, 'downloadTemplate'])->name('proporsi-fairness.template');
    Route::post('proporsi-fairness/import', [ProporsiFairnessController::class, 'import'])->name('proporsi-fairness.import');
    Route::resource('proporsi-fairness', ProporsiFairnessController::class);

    Route::resource('sumber', SumberController::class);

    Route::resource('remunerasi-batch', RemunerasiBatchController::class);
    Route::post('remunerasi-batch/{id}/finalize', [RemunerasiBatchController::class, 'finalize'])->name('remunerasi-batch.finalize');

    Route::resource('detail-source', DetailSourceController::class);
    Route::get('detail-source/list/{sourceId}', [DetailSourceController::class, 'listBySource'])->name('detail-source.listBySource');
    Route::get('detail-source/data/{sourceId}', [DetailSourceController::class, 'getBySource'])->name('detail-source.getBySource');
    Route::post('detail-source/import/{sourceId}', [DetailSourceController::class, 'import'])->name('detail-source.import');
    Route::get('detail-source/template/download', [DetailSourceController::class, 'downloadTemplate'])->name('detail-source.template');

    // Detail Source routes
    Route::get('detail-source', [DetailSourceController::class, 'index'])->name('detail-source.index');
    Route::post('detail-source', [DetailSourceController::class, 'store'])->name('detail-source.store');
    Route::get('detail-source/{id}', [DetailSourceController::class, 'show'])->name('detail-source.show');
    Route::put('detail-source/{id}', [DetailSourceController::class, 'update'])->name('detail-source.update');
    Route::delete('detail-source/{id}', [DetailSourceController::class, 'destroy'])->name('detail-source.destroy');
    
    // List detail source by remunerasi source
    Route::get('remunerasi-source/{id}/details', [DetailSourceController::class, 'listBySource'])->name('detail-source.listBySource');
    Route::get('remunerasi-source/{id}/details/data', [DetailSourceController::class, 'getBySource'])->name('detail-source.getBySource');

    // Routes untuk Pembagian Klaim
    Route::get('pembagian-klaim', [PembagianKlaimController::class, 'index'])->name('pembagian-klaim.index');
    Route::get('pembagian-klaim/hitung', [PembagianKlaimController::class, 'hitung'])->name('pembagian-klaim.hitung');
    Route::get('pembagian-klaim/updateSepPasien', [PembagianKlaimController::class, 'updateSepPasien'])->name('pembagian-klaim.updateSepPasien');
    Route::post('pembagian-klaim', [PembagianKlaimController::class, 'store'])->name('pembagian-klaim.store');
    Route::get('pembagian-klaim/{id}', [PembagianKlaimController::class, 'show'])->name('pembagian-klaim.show');
    Route::put('pembagian-klaim/{id}', [PembagianKlaimController::class, 'update'])->name('pembagian-klaim.update');
    Route::delete('pembagian-klaim/{id}', [PembagianKlaimController::class, 'destroy'])->name('pembagian-klaim.destroy');
    
    // Route untuk mendapatkan data pembagian klaim berdasarkan detail source
    Route::get('detail-source/{id}/pembagian-klaim', [PembagianKlaimController::class, 'getByDetailSource'])
        ->name('pembagian-klaim.getByDetailSource');

    Route::get('detail-source/get-unsynced-count/{sourceId}', [DetailSourceController::class, 'getUnsyncedCount'])->name('detail-source.get-unsynced-count');
    Route::post('detail-source/sync-batch/{sourceId}', [DetailSourceController::class, 'syncBatch'])->name('detail-source.sync-batch');

    Route::get('/admission/list', [AdmissionController::class, 'listAdmission'])->name('admission.list');
    Route::get('/admission/export-excel', [AdmissionController::class, 'exportExcel'])->name('admission.export-excel');
    Route::get('admission/detail/{id}', [AdmissionController::class, 'showDetail'])->name('admission.detail');
  
    Route::get('/pendaftaran/list', [PendaftaranController::class, 'listPendaftaran'])->name('pendaftaran.list');
    Route::get('/pendaftaran/export-excel', [PendaftaranController::class, 'exportExcel'])->name('pendaftaran.export-excel');
    Route::get('pendaftaran/detail/{id}', [PendaftaranController::class, 'showDetail'])->name('pendaftaran.detail');


    // Import Admission di Detail Source
    Route::get('detail-source/admission/list', [DetailSourceController::class, 'getAdmissionList'])->name('detail-source.admission.list');
    Route::post('detail-source/store-from-admission/{sourceId}', [DetailSourceController::class, 'storeFromAdmission'])->name('detail-source.store-from-admission');

    Route::get('/pembagian-klaim/laporan', [PembagianKlaimController::class, 'laporan'])->name('pembagian-klaim.laporan');
});

require __DIR__.'/auth.php';
