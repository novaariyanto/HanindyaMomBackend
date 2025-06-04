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
use App\Http\Controllers\IndeksStrukturalController;
use App\Http\Controllers\IndeksJasaTidakLangsungController;
use App\Http\Controllers\IndeksJasaLangsungNonMedisController;
use App\Http\Controllers\TransaksiRemunerasiPegawaiController;
use App\Http\Controllers\IndeksPegawaiController;
use App\Http\Controllers\PegawaiJasaNonMedisController;
use App\Http\Controllers\KategoriIndeksJasaLangsungNonMedisController;
use App\Http\Controllers\PegawaiJasaTidakLangsungController;
use App\Http\Controllers\KategoriIndeksJasaTidakLangsungController;
use App\Http\Controllers\PegawaiStrukturalController;

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

    Route::get('/pembagian-klaim/laporan/{sourceId}', [PembagianKlaimController::class, 'laporan'])->name('pembagian-klaim.laporan');

    // Indeks Struktural
    Route::get('indeks-struktural', [IndeksStrukturalController::class, 'index'])->name('indeks-struktural.index');
    Route::post('indeks-struktural', [IndeksStrukturalController::class, 'store'])->name('indeks-struktural.store');
    Route::get('indeks-struktural/{id}', [IndeksStrukturalController::class, 'show'])->name('indeks-struktural.show');
    Route::put('indeks-struktural/{id}', [IndeksStrukturalController::class, 'update'])->name('indeks-struktural.update');
    Route::delete('indeks-struktural/{id}', [IndeksStrukturalController::class, 'destroy'])->name('indeks-struktural.destroy');

    // Indeks Jasa Tidak Langsung
    Route::get('indeks-jasa-tidak-langsung', [IndeksJasaTidakLangsungController::class, 'index'])->name('indeks-jasa-tidak-langsung.index');
    Route::post('indeks-jasa-tidak-langsung', [IndeksJasaTidakLangsungController::class, 'store'])->name('indeks-jasa-tidak-langsung.store');
    Route::get('indeks-jasa-tidak-langsung/{id}', [IndeksJasaTidakLangsungController::class, 'show'])->name('indeks-jasa-tidak-langsung.show');
    Route::put('indeks-jasa-tidak-langsung/{id}', [IndeksJasaTidakLangsungController::class, 'update'])->name('indeks-jasa-tidak-langsung.update');
    Route::delete('indeks-jasa-tidak-langsung/{id}', [IndeksJasaTidakLangsungController::class, 'destroy'])->name('indeks-jasa-tidak-langsung.destroy');

    // Indeks Jasa Langsung Non Medis
    Route::get('indeks-jasa-langsung-non-medis', [IndeksJasaLangsungNonMedisController::class, 'index'])->name('indeks-jasa-langsung-non-medis.index');
    Route::post('indeks-jasa-langsung-non-medis', [IndeksJasaLangsungNonMedisController::class, 'store'])->name('indeks-jasa-langsung-non-medis.store');
    Route::get('indeks-jasa-langsung-non-medis/{id}', [IndeksJasaLangsungNonMedisController::class, 'show'])->name('indeks-jasa-langsung-non-medis.show');
    Route::put('indeks-jasa-langsung-non-medis/{id}', [IndeksJasaLangsungNonMedisController::class, 'update'])->name('indeks-jasa-langsung-non-medis.update');
    Route::delete('indeks-jasa-langsung-non-medis/{id}', [IndeksJasaLangsungNonMedisController::class, 'destroy'])->name('indeks-jasa-langsung-non-medis.destroy');

    // Pegawai
    Route::get('pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::post('pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawai.show');
    Route::put('pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

  

    // Transaksi Remunerasi Pegawai
    Route::get('transaksi-remunerasi-pegawai', [TransaksiRemunerasiPegawaiController::class, 'index'])->name('transaksi-remunerasi-pegawai.index');
    Route::post('transaksi-remunerasi-pegawai', [TransaksiRemunerasiPegawaiController::class, 'store'])->name('transaksi-remunerasi-pegawai.store');
    Route::get('transaksi-remunerasi-pegawai/{id}', [TransaksiRemunerasiPegawaiController::class, 'show'])->name('transaksi-remunerasi-pegawai.show');
    Route::put('transaksi-remunerasi-pegawai/{id}', [TransaksiRemunerasiPegawaiController::class, 'update'])->name('transaksi-remunerasi-pegawai.update');
    Route::delete('transaksi-remunerasi-pegawai/{id}', [TransaksiRemunerasiPegawaiController::class, 'destroy'])->name('transaksi-remunerasi-pegawai.destroy');
    
    // Import dan Template untuk Transaksi Remunerasi Pegawai
    Route::post('transaksi-remunerasi-pegawai/import', [TransaksiRemunerasiPegawaiController::class, 'import'])->name('transaksi-remunerasi-pegawai.import');
    Route::get('transaksi-remunerasi-pegawai/template/download', [TransaksiRemunerasiPegawaiController::class, 'template'])->name('transaksi-remunerasi-pegawai.template');
    
    // Sinkronisasi Batch untuk Transaksi Remunerasi Pegawai
    Route::get('transaksi-remunerasi-pegawai/get-unsynced-count', [TransaksiRemunerasiPegawaiController::class, 'getUnsyncedCount'])->name('transaksi-remunerasi-pegawai.get-unsynced-count');
    Route::post('transaksi-remunerasi-pegawai/sync-batch', [TransaksiRemunerasiPegawaiController::class, 'syncBatch'])->name('transaksi-remunerasi-pegawai.sync-batch');

    // Indeks Pegawai
    Route::get('indeks-pegawai', [IndeksPegawaiController::class, 'index'])->name('indeks-pegawai.index');
    Route::post('indeks-pegawai', [IndeksPegawaiController::class, 'store'])->name('indeks-pegawai.store');
    Route::get('indeks-pegawai/{id}', [IndeksPegawaiController::class, 'show'])->name('indeks-pegawai.show');
    Route::get('indeks-pegawai/{id}/detail', [IndeksPegawaiController::class, 'show'])->name('indeks-pegawai.detail');
    Route::put('indeks-pegawai/{id}', [IndeksPegawaiController::class, 'update'])->name('indeks-pegawai.update');
    Route::delete('indeks-pegawai/{id}', [IndeksPegawaiController::class, 'destroy'])->name('indeks-pegawai.destroy');
    Route::post('indeks-pegawai/{id}/restore', [IndeksPegawaiController::class, 'restore'])->name('indeks-pegawai.restore');
    Route::delete('indeks-pegawai/{id}/force-delete', [IndeksPegawaiController::class, 'forceDelete'])->name('indeks-pegawai.force-delete');
    Route::post('indeks-pegawai/sync', [IndeksPegawaiController::class, 'sync'])->name('indeks-pegawai.sync');

    // Pegawai Jasa Non Medis
    Route::get('pegawai-jasa-non-medis', [PegawaiJasaNonMedisController::class, 'index'])->name('pegawai-jasa-non-medis.index');
    Route::post('pegawai-jasa-non-medis', [PegawaiJasaNonMedisController::class, 'store'])->name('pegawai-jasa-non-medis.store');
    Route::get('pegawai-jasa-non-medis/{id}', [PegawaiJasaNonMedisController::class, 'show'])->name('pegawai-jasa-non-medis.show');
    Route::get('pegawai-jasa-non-medis/{id}/edit', [PegawaiJasaNonMedisController::class, 'edit'])->name('pegawai-jasa-non-medis.edit');
    Route::put('pegawai-jasa-non-medis/{id}', [PegawaiJasaNonMedisController::class, 'update'])->name('pegawai-jasa-non-medis.update');
    Route::delete('pegawai-jasa-non-medis/{id}', [PegawaiJasaNonMedisController::class, 'destroy'])->name('pegawai-jasa-non-medis.destroy');

    // Pegawai Jasa Non Medis
    Route::get('pegawai-jasa-tidak-langsung', [PegawaiJasaTidakLangsungController::class, 'index'])->name('pegawai-jasa-tidak-langsung.index');
    Route::post('pegawai-jasa-tidak-langsung', [PegawaiJasaTidakLangsungController::class, 'store'])->name('pegawai-jasa-tidak-langsung.store');
    Route::get('pegawai-jasa-tidak-langsung/{id}', [PegawaiJasaTidakLangsungController::class, 'show'])->name('pegawai-jasa-tidak-langsung.show');
    Route::get('pegawai-jasa-tidak-langsung/{id}/edit', [PegawaiJasaTidakLangsungController::class, 'edit'])->name('pegawai-jasa-tidak-langsung.edit');
    Route::put('pegawai-jasa-tidak-langsung/{id}', [PegawaiJasaTidakLangsungController::class, 'update'])->name('pegawai-jasa-tidak-langsung.update');
    Route::delete('pegawai-jasa-tidak-langsung/{id}', [PegawaiJasaTidakLangsungController::class, 'destroy'])->name('pegawai-jasa-tidak-langsung.destroy');
   
    // Kategori Non Medis
    Route::get('kategori-non-medis', [KategoriIndeksJasaLangsungNonMedisController::class, 'index'])->name('kategori-non-medis.index');
    Route::post('kategori-non-medis', [KategoriIndeksJasaLangsungNonMedisController::class, 'store'])->name('kategori-non-medis.store');
    Route::get('kategori-non-medis/{id}', [KategoriIndeksJasaLangsungNonMedisController::class, 'show'])->name('kategori-non-medis.show');
    Route::get('kategori-non-medis/{id}/edit', [KategoriIndeksJasaLangsungNonMedisController::class, 'edit'])->name('kategori-non-medis.edit');
    Route::put('kategori-non-medis/{id}', [KategoriIndeksJasaLangsungNonMedisController::class, 'update'])->name('kategori-non-medis.update');
    Route::delete('kategori-non-medis/{id}', [KategoriIndeksJasaLangsungNonMedisController::class, 'destroy'])->name('kategori-non-medis.destroy');

    // Kategori Tidak Langsung
    Route::get('kategori-tidak-langsung', [KategoriIndeksJasaTidakLangsungController::class, 'index'])->name('kategori-tidak-langsung.index');
    Route::post('kategori-tidak-langsung', [KategoriIndeksJasaTidakLangsungController::class, 'store'])->name('kategori-tidak-langsung.store');
    Route::get('kategori-tidak-langsung/{id}', [KategoriIndeksJasaTidakLangsungController::class, 'show'])->name('kategori-tidak-langsung.show');
    Route::get('kategori-tidak-langsung/{id}/edit', [KategoriIndeksJasaTidakLangsungController::class, 'edit'])->name('kategori-tidak-langsung.edit');
    Route::put('kategori-tidak-langsung/{id}', [KategoriIndeksJasaTidakLangsungController::class, 'update'])->name('kategori-tidak-langsung.update');
    Route::delete('kategori-tidak-langsung/{id}', [KategoriIndeksJasaTidakLangsungController::class, 'destroy'])->name('kategori-tidak-langsung.destroy');

    // Pegawai Struktural
    Route::get('pegawai-struktural', [PegawaiStrukturalController::class, 'index'])->name('pegawai-struktural.index');
    Route::post('pegawai-struktural', [PegawaiStrukturalController::class, 'store'])->name('pegawai-struktural.store');
    Route::get('pegawai-struktural/{id}', [PegawaiStrukturalController::class, 'show'])->name('pegawai-struktural.show');
    Route::get('pegawai-struktural/{id}/edit', [PegawaiStrukturalController::class, 'edit'])->name('pegawai-struktural.edit');
    Route::put('pegawai-struktural/{id}', [PegawaiStrukturalController::class, 'update'])->name('pegawai-struktural.update');
    Route::delete('pegawai-struktural/{id}', [PegawaiStrukturalController::class, 'destroy'])->name('pegawai-struktural.destroy');
    
});

require __DIR__.'/auth.php';
