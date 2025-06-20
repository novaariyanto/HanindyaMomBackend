@extends('root')
@section('title', 'Data Indeks Pegawai Source')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Data Indeks Pegawai Source - ' . $remunerasiSource->nama_source,
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('remunerasi-source.index'), 'label' => 'Remunerasi Source'],
        ],
        'current' => 'Indeks Pegawai Source'
    ])
    
    <div class="widget-content searchable-container list">
      <div class="card card-body">
        <div class="row">
          <div class="col-md-4 col-xl-3">
            <form class="position-relative">
              <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Cari Data">
              <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </form>
          </div>
          <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-success" onclick="startSync()">
                    <i class="ti ti-refresh me-1"></i> Sinkronisasi Data
                </button>
                <button type="button" class="btn btn-info" onclick="checkSyncCount()">
                    <i class="ti ti-info-circle me-1"></i> Cek Data
                </button>
            </div>
            <div class="btn-group me-2">
                <button type="button" class="btn btn-warning" onclick="startHitungRemunerasi()">
                    <i class="ti ti-calculator me-1"></i> Hitung Remunerasi
                </button>
                <button type="button" class="btn btn-secondary" onclick="checkHitungCount()">
                    <i class="ti ti-info-circle me-1"></i> Cek Perhitungan
                </button>
            </div>
            <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
              <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Indeks Pegawai
            </a>
          </div>
        </div>
      </div>

      <div class="card card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Pegawai</th>
                        <th>Unit Kerja</th>
                        <th>Dasar</th>
                        <th>Kompetensi</th>
                        <th>Resiko</th>
                        <th>Emergensi</th>
                        <th>Posisi</th>
                        <th>Kinerja</th>
                        <th>Jumlah</th>
                        <th>Rekening</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated via DataTables AJAX -->
                </tbody>
            </table>
        </div>
      </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Indeks Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('indeks-pegawai.store', $sourceId) }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control" name="nik" required maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Pegawai</label>
                                <input type="text" class="form-control" name="nama_pegawai" required maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">ID Pegawai</label>
                                <input type="number" class="form-control" name="id_pegawai" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Unit Kerja ID</label>
                                <input type="number" class="form-control" name="unit_kerja_id" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dasar</label>
                                <input type="number" step="0.01" class="form-control" name="dasar" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kompetensi</label>
                                <input type="number" step="0.01" class="form-control" name="kompetensi" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Resiko</label>
                                <input type="number" step="0.01" class="form-control" name="resiko" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Emergensi</label>
                                <input type="number" step="0.01" class="form-control" name="emergensi" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Posisi</label>
                                <input type="number" step="0.01" class="form-control" name="posisi" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kinerja</label>
                                <input type="number" step="0.01" class="form-control" name="kinerja" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rekening</label>
                                <input type="text" class="form-control" name="rekening" maxlength="50">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pajak</label>
                                <input type="number" step="0.01" class="form-control" name="pajak">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Indeks Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control" name="nik" id="edit_nik" required maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Pegawai</label>
                                <input type="text" class="form-control" name="nama_pegawai" id="edit_nama_pegawai" required maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">ID Pegawai</label>
                                <input type="number" class="form-control" name="id_pegawai" id="edit_id_pegawai" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Unit Kerja ID</label>
                                <input type="number" class="form-control" name="unit_kerja_id" id="edit_unit_kerja_id" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dasar</label>
                                <input type="number" step="0.01" class="form-control" name="dasar" id="edit_dasar" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kompetensi</label>
                                <input type="number" step="0.01" class="form-control" name="kompetensi" id="edit_kompetensi" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Resiko</label>
                                <input type="number" step="0.01" class="form-control" name="resiko" id="edit_resiko" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Emergensi</label>
                                <input type="number" step="0.01" class="form-control" name="emergensi" id="edit_emergensi" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Posisi</label>
                                <input type="number" step="0.01" class="form-control" name="posisi" id="edit_posisi" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kinerja</label>
                                <input type="number" step="0.01" class="form-control" name="kinerja" id="edit_kinerja" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rekening</label>
                                <input type="text" class="form-control" name="rekening" id="edit_rekening" maxlength="50">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pajak</label>
                                <input type="number" step="0.01" class="form-control" name="pajak" id="edit_pajak">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sinkronisasi Progress -->
<div class="modal fade" id="syncModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Progress Sinkronisasi Indeks Pegawai</h5>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <div class="spinner-border text-primary" role="status" id="syncSpinner">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" id="syncProgressBar">0%</div>
                </div>
                <div class="row text-center">
                    <div class="col-md-3">
                        <h5 class="mb-0" id="totalProcessed">0</h5>
                        <small class="text-muted">Total Diproses</small>
                    </div>
                    <div class="col-md-3">
                        <h5 class="mb-0 text-success" id="totalSynced">0</h5>
                        <small class="text-muted">Ditambahkan</small>
                    </div>
                    <div class="col-md-3">
                        <h5 class="mb-0 text-info" id="totalUpdated">0</h5>
                        <small class="text-muted">Diupdate</small>
                    </div>
                    <div class="col-md-3">
                        <h5 class="mb-0 text-warning" id="totalSkipped">0</h5>
                        <small class="text-muted">Dilewati</small>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="alert alert-info mb-0">
                        <div id="syncStatus">Memulai sinkronisasi...</div>
                    </div>
                </div>
                <div class="mt-3" id="syncErrors" style="display: none;">
                    <div class="alert alert-warning">
                        <h6>Error yang terjadi:</h6>
                        <ul id="errorList"></ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCancelSync" onclick="cancelSync()">Batalkan</button>
                <button type="button" class="btn btn-primary" id="btnCloseSync" onclick="closeSync()" style="display: none;">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Info Data -->
<div class="modal fade" id="infoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informasi Data Sinkronisasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h3 class="mb-0 text-primary" id="infoTotalData">0</h3>
                        <small class="text-muted">Total Data JTL</small>
                    </div>
                    <div class="col-md-4">
                        <h3 class="mb-0 text-success" id="infoExistingData">0</h3>
                        <small class="text-muted">Sudah Ada</small>
                    </div>
                    <div class="col-md-4">
                        <h3 class="mb-0 text-warning" id="infoNewData">0</h3>
                        <small class="text-muted">Data Baru</small>
                    </div>
                </div>
                <hr>
                <div class="alert alert-info">
                    <i class="ti ti-info-circle me-2"></i>
                    <strong>Informasi:</strong><br>
                    Data akan disinkronisasi dari tabel <strong>JtlPegawaiIndeks</strong> ke <strong>JtlPegawaiIndeksSource</strong> untuk source ini.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" onclick="confirmSync()">Mulai Sinkronisasi</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Progress Perhitungan Remunerasi -->
<div class="modal fade" id="hitungModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Progress Perhitungan Remunerasi</h5>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <div class="spinner-border text-warning" role="status" id="hitungSpinner">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 0%" id="hitungProgressBar">0%</div>
                </div>
                <div class="row text-center">
                    <div class="col-md-3">
                        <h5 class="mb-0" id="hitungTotalProcessed">0</h5>
                        <small class="text-muted">Total Diproses</small>
                    </div>
                    <div class="col-md-3">
                        <h5 class="mb-0 text-success" id="hitungTotalSynced">0</h5>
                        <small class="text-muted">Ditambahkan</small>
                    </div>
                    <div class="col-md-3">
                        <h5 class="mb-0 text-info" id="hitungTotalUpdated">0</h5>
                        <small class="text-muted">Diupdate</small>
                    </div>
                    <div class="col-md-3">
                        <h5 class="mb-0 text-warning" id="hitungTotalSkipped">0</h5>
                        <small class="text-muted">Dilewati</small>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="alert alert-info mb-0">
                        <div id="hitungStatus">Memulai perhitungan remunerasi...</div>
                    </div>
                </div>
                <div class="mt-3" id="hitungErrors" style="display: none;">
                    <div class="alert alert-warning">
                        <h6>Error yang terjadi:</h6>
                        <ul id="hitungErrorList"></ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCancelHitung" onclick="cancelHitung()">Batalkan</button>
                <button type="button" class="btn btn-primary" id="btnCloseHitung" onclick="closeHitung()" style="display: none;">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Info Data Perhitungan -->
<div class="modal fade" id="infoHitungModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informasi Data Perhitungan Remunerasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h3 class="mb-0 text-primary" id="infoHitungTotalData">0</h3>
                        <small class="text-muted">Total Data Indeks</small>
                    </div>
                    <div class="col-md-4">
                        <h3 class="mb-0 text-success" id="infoHitungExistingData">0</h3>
                        <small class="text-muted">Sudah Dihitung</small>
                    </div>
                    <div class="col-md-4">
                        <h3 class="mb-0 text-warning" id="infoHitungNewData">0</h3>
                        <small class="text-muted">Data Baru</small>
                    </div>
                </div>
                <hr>
                <div id="jtlDataInfo">
                    <div class="alert alert-info">
                        <i class="ti ti-info-circle me-2"></i>
                        <strong>Nilai Indeks JTL:</strong> <span id="nilaiIndeksJtl">0</span><br>
                        <small>Data akan dihitung dengan rumus:<br>
                        <strong>JTL Bruto</strong> = Jumlah × Nilai Indeks<br>
                        <strong>Potongan Pajak</strong> = (Pajak% × JTL Bruto)<br>
                        <strong>JTL Net</strong> = JTL Bruto - Potongan Pajak</small>
                    </div>
                </div>
                <div id="jtlDataWarning" style="display: none;">
                    <div class="alert alert-warning">
                        <i class="ti ti-alert-triangle me-2"></i>
                        <strong>Peringatan:</strong><br>
                        Data JTL tidak tersedia untuk source ini. Pastikan data JTL sudah dibuat terlebih dahulu.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning" id="btnStartHitung" onclick="confirmHitung()">Mulai Perhitungan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('indeks-pegawai.data', $sourceId) }}',
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {data: 'nik', name: 'nik'},
            {data: 'nama_pegawai', name: 'nama_pegawai'},
            {data: 'unit_kerja_id', name: 'unit_kerja_id'},
            {data: 'dasar', name: 'dasar'},
            {data: 'kompetensi', name: 'kompetensi'},
            {data: 'resiko', name: 'resiko'},
            {data: 'emergensi', name: 'emergensi'},
            {data: 'posisi', name: 'posisi'},
            {data: 'kinerja', name: 'kinerja'},
            {data: 'jumlah', name: 'jumlah'},
            {data: 'rekening', name: 'rekening'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });

    $('#input-search').on('keyup', function () {
        datatable.search(this.value).draw();
    });

  
    // Handle Edit Button Click
    $(document).on('click', '.btn-edit', function() {
        var url = $(this).data('url');
        
        $.get(url, function(response) {
            if (response.meta.status === 'success') {
                var data = response.data;
                $('#editForm').attr('action', url);
                $('#edit_nik').val(data.nik);
                $('#edit_nama_pegawai').val(data.nama_pegawai);
                $('#edit_id_pegawai').val(data.id_pegawai);
                $('#edit_unit_kerja_id').val(data.unit_kerja_id);
                $('#edit_dasar').val(data.dasar);
                $('#edit_kompetensi').val(data.kompetensi);
                $('#edit_resiko').val(data.resiko);
                $('#edit_emergensi').val(data.emergensi);
                $('#edit_posisi').val(data.posisi);
                $('#edit_kinerja').val(data.kinerja);
                $('#edit_rekening').val(data.rekening);
                $('#edit_pajak').val(data.pajak);
                $('#editModal').modal('show');
            }
        });
    });



 

    // Reset form when modal is closed
    $('#createModal').on('hidden.bs.modal', function () {
        $('#createForm')[0].reset();
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $('#editForm')[0].reset();
    });
});

// Variables untuk sinkronisasi
let syncInProgress = false;
let syncCancelled = false;

// Fungsi untuk cek jumlah data yang akan disinkronisasi
function checkSyncCount() {
    $.get('{{ route('indeks-pegawai.sync-count', $sourceId) }}', function(response) {
        if (response.success) {
            $('#infoTotalData').text(response.total);
            $('#infoExistingData').text(response.existing);
            $('#infoNewData').text(response.new);
            $('#infoModal').modal('show');
        } else {
            toastr.error('Gagal mengambil informasi data');
        }
    }).fail(function() {
        toastr.error('Terjadi kesalahan saat mengambil informasi data');
    });
}

// Fungsi untuk memulai sinkronisasi
function startSync() {
    Swal.fire({
        title: 'Konfirmasi Sinkronisasi',
        text: 'Apakah Anda yakin ingin memulai sinkronisasi data indeks pegawai?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Mulai Sinkronisasi',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            confirmSync();
        }
    });
}

// Fungsi untuk konfirmasi dan memulai sinkronisasi
function confirmSync() {
    $('#infoModal').modal('hide');
    $('#syncModal').modal('show');
    
    // Reset progress
    resetSyncProgress();
    
    // Mulai sinkronisasi batch
    syncInProgress = true;
    syncCancelled = false;
    processSyncBatch(0);
}

// Reset progress sinkronisasi
function resetSyncProgress() {
    $('#syncProgressBar').css('width', '0%').text('0%');
    $('#totalProcessed').text('0');
    $('#totalSynced').text('0');
    $('#totalUpdated').text('0');
    $('#totalSkipped').text('0');
    $('#syncStatus').text('Memulai sinkronisasi...');
    $('#syncErrors').hide();
    $('#errorList').empty();
    $('#syncSpinner').show();
    $('#btnCancelSync').show();
    $('#btnCloseSync').hide();
}

// Proses sinkronisasi batch
function processSyncBatch(offset) {
    if (syncCancelled) {
        return;
    }

    const limit = 50; // Process 50 records per batch
    
    $.ajax({
        url: '{{ route('indeks-pegawai.sync-batch', $sourceId) }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            limit: limit,
            offset: offset
        },
        success: function(response) {
            if (response.status === 'success') {
                const data = response.data;
                
                // Update progress
                const progress = Math.round((data.processedRecords / data.totalRecords) * 100);
                $('#syncProgressBar').css('width', progress + '%').text(progress + '%');
                
                // Update counters
                const currentProcessed = parseInt($('#totalProcessed').text());
                const currentSynced = parseInt($('#totalSynced').text());
                const currentUpdated = parseInt($('#totalUpdated').text());
                const currentSkipped = parseInt($('#totalSkipped').text());
                
                $('#totalProcessed').text(currentProcessed + data.processed);
                $('#totalSynced').text(currentSynced + data.synced);
                $('#totalUpdated').text(currentUpdated + data.updated);
                $('#totalSkipped').text(currentSkipped + data.skipped);
                
                // Update status
                $('#syncStatus').text(`Memproses data... ${data.processedRecords} dari ${data.totalRecords} record`);
                
                // Handle errors
                if (data.errors && data.errors.length > 0) {
                    data.errors.forEach(function(error) {
                        $('#errorList').append('<li>' + error + '</li>');
                    });
                    $('#syncErrors').show();
                }
                
                // Continue if there's more data
                if (data.hasMore && !syncCancelled) {
                    setTimeout(function() {
                        processSyncBatch(offset + limit);
                    }, 100); // Small delay to prevent overwhelming the server
                } else {
                    // Sinkronisasi selesai
                    finishSync();
                }
            } else {
                // Error occurred
                $('#syncStatus').text('Terjadi kesalahan: ' + response.message);
                $('#syncSpinner').hide();
                $('#btnCancelSync').hide();
                $('#btnCloseSync').show();
                syncInProgress = false;
                toastr.error('Sinkronisasi gagal: ' + response.message);
            }
        },
        error: function(xhr) {
            const errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan tidak terduga';
            $('#syncStatus').text('Terjadi kesalahan: ' + errorMessage);
            $('#syncSpinner').hide();
            $('#btnCancelSync').hide();
            $('#btnCloseSync').show();
            syncInProgress = false;
            toastr.error('Sinkronisasi gagal: ' + errorMessage);
        }
    });
}

// Finish sinkronisasi
function finishSync() {
    $('#syncStatus').text('Sinkronisasi selesai!');
    $('#syncSpinner').hide();
    $('#btnCancelSync').hide();
    $('#btnCloseSync').show();
    syncInProgress = false;
    
    // Reload datatable
    datatable.ajax.reload();
    
    // Show success message
    const totalSynced = parseInt($('#totalSynced').text());
    const totalUpdated = parseInt($('#totalUpdated').text());
    toastr.success(`Sinkronisasi selesai! ${totalSynced} data ditambahkan, ${totalUpdated} data diupdate`);
}

// Cancel sinkronisasi
function cancelSync() {
    if (syncInProgress) {
        Swal.fire({
            title: 'Batalkan Sinkronisasi?',
            text: 'Apakah Anda yakin ingin membatalkan proses sinkronisasi?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Lanjutkan'
        }).then((result) => {
            if (result.isConfirmed) {
                syncCancelled = true;
                syncInProgress = false;
                $('#syncStatus').text('Sinkronisasi dibatalkan');
                $('#syncSpinner').hide();
                $('#btnCancelSync').hide();
                $('#btnCloseSync').show();
                toastr.warning('Sinkronisasi dibatalkan');
            }
        });
    } else {
        closeSync();
    }
}

// Close sync modal
function closeSync() {
    $('#syncModal').modal('hide');
    syncInProgress = false;
    syncCancelled = false;
}

// Variables untuk perhitungan remunerasi
let hitungInProgress = false;
let hitungCancelled = false;

// Fungsi untuk cek jumlah data yang akan dihitung remunerasinya
function checkHitungCount() {
    $.get('{{ route('hitung-remunerasi.sync-count', $sourceId) }}', function(response) {
        if (response.success) {
            $('#infoHitungTotalData').text(response.total);
            $('#infoHitungExistingData').text(response.existing);
            $('#infoHitungNewData').text(response.new);
            
            if (response.jtl_available) {
                $('#nilaiIndeksJtl').text(new Intl.NumberFormat('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(response.nilai_indeks));
                $('#jtlDataInfo').show();
                $('#jtlDataWarning').hide();
                $('#btnStartHitung').prop('disabled', false);
            } else {
                $('#jtlDataInfo').hide();
                $('#jtlDataWarning').show();
                $('#btnStartHitung').prop('disabled', true);
            }
            
            $('#infoHitungModal').modal('show');
        } else {
            toastr.error('Gagal mengambil informasi data perhitungan');
        }
    }).fail(function() {
        toastr.error('Terjadi kesalahan saat mengambil informasi data perhitungan');
    });
}

// Fungsi untuk memulai perhitungan remunerasi
function startHitungRemunerasi() {
    Swal.fire({
        title: 'Konfirmasi Perhitungan Remunerasi',
        text: 'Apakah Anda yakin ingin memulai perhitungan remunerasi?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Mulai Perhitungan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            confirmHitung();
        }
    });
}

// Fungsi untuk konfirmasi dan memulai perhitungan remunerasi
function confirmHitung() {
    $('#infoHitungModal').modal('hide');
    $('#hitungModal').modal('show');
    
    // Reset progress
    resetHitungProgress();
    
    // Mulai perhitungan batch
    hitungInProgress = true;
    hitungCancelled = false;
    processHitungBatch(0);
}

// Reset progress perhitungan
function resetHitungProgress() {
    $('#hitungProgressBar').css('width', '0%').text('0%');
    $('#hitungTotalProcessed').text('0');
    $('#hitungTotalSynced').text('0');
    $('#hitungTotalUpdated').text('0');
    $('#hitungTotalSkipped').text('0');
    $('#hitungStatus').text('Memulai perhitungan remunerasi...');
    $('#hitungErrors').hide();
    $('#hitungErrorList').empty();
    $('#hitungSpinner').show();
    $('#btnCancelHitung').show();
    $('#btnCloseHitung').hide();
}

// Proses perhitungan batch
function processHitungBatch(offset) {
    if (hitungCancelled) {
        return;
    }

    const limit = 50; // Process 50 records per batch
    
    $.ajax({
        url: '{{ route('hitung-remunerasi.sync-batch', $sourceId) }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            limit: limit,
            offset: offset
        },
        success: function(response) {
            if (response.status === 'success') {
                const data = response.data;
                
                // Update progress
                const progress = Math.round((data.processedRecords / data.totalRecords) * 100);
                $('#hitungProgressBar').css('width', progress + '%').text(progress + '%');
                
                // Update counters
                const currentProcessed = parseInt($('#hitungTotalProcessed').text());
                const currentSynced = parseInt($('#hitungTotalSynced').text());
                const currentUpdated = parseInt($('#hitungTotalUpdated').text());
                const currentSkipped = parseInt($('#hitungTotalSkipped').text());
                
                $('#hitungTotalProcessed').text(currentProcessed + data.processed);
                $('#hitungTotalSynced').text(currentSynced + data.synced);
                $('#hitungTotalUpdated').text(currentUpdated + data.updated);
                $('#hitungTotalSkipped').text(currentSkipped + data.skipped);
                
                // Update status
                $('#hitungStatus').text(`Memproses perhitungan... ${data.processedRecords} dari ${data.totalRecords} record`);
                
                // Handle errors
                if (data.errors && data.errors.length > 0) {
                    data.errors.forEach(function(error) {
                        $('#hitungErrorList').append('<li>' + error + '</li>');
                    });
                    $('#hitungErrors').show();
                }
                
                // Continue if there's more data
                if (data.hasMore && !hitungCancelled) {
                    setTimeout(function() {
                        processHitungBatch(offset + limit);
                    }, 100); // Small delay to prevent overwhelming the server
                } else {
                    // Perhitungan selesai
                    finishHitung();
                }
            } else {
                // Error occurred
                $('#hitungStatus').text('Terjadi kesalahan: ' + response.message);
                $('#hitungSpinner').hide();
                $('#btnCancelHitung').hide();
                $('#btnCloseHitung').show();
                hitungInProgress = false;
                toastr.error('Perhitungan gagal: ' + response.message);
            }
        },
        error: function(xhr) {
            const errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan tidak terduga';
            $('#hitungStatus').text('Terjadi kesalahan: ' + errorMessage);
            $('#hitungSpinner').hide();
            $('#btnCancelHitung').hide();
            $('#btnCloseHitung').show();
            hitungInProgress = false;
            toastr.error('Perhitungan gagal: ' + errorMessage);
        }
    });
}

// Finish perhitungan
function finishHitung() {
    $('#hitungStatus').text('Perhitungan remunerasi selesai!');
    $('#hitungSpinner').hide();
    $('#btnCancelHitung').hide();
    $('#btnCloseHitung').show();
    hitungInProgress = false;
    
    // Show success message
    const totalSynced = parseInt($('#hitungTotalSynced').text());
    const totalUpdated = parseInt($('#hitungTotalUpdated').text());
    toastr.success(`Perhitungan remunerasi selesai! ${totalSynced} data ditambahkan, ${totalUpdated} data diupdate`);
}

// Cancel perhitungan
function cancelHitung() {
    if (hitungInProgress) {
        Swal.fire({
            title: 'Batalkan Perhitungan?',
            text: 'Apakah Anda yakin ingin membatalkan proses perhitungan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Lanjutkan'
        }).then((result) => {
            if (result.isConfirmed) {
                hitungCancelled = true;
                hitungInProgress = false;
                $('#hitungStatus').text('Perhitungan dibatalkan');
                $('#hitungSpinner').hide();
                $('#btnCancelHitung').hide();
                $('#btnCloseHitung').show();
                toastr.warning('Perhitungan dibatalkan');
            }
        });
    } else {
        closeHitung();
    }
}

// Close hitung modal
function closeHitung() {
    $('#hitungModal').modal('hide');
    hitungInProgress = false;
    hitungCancelled = false;
}
</script>
@endpush 