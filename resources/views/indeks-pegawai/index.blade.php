@extends('root')

@section('title', 'Indeks Pegawai')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Indeks Pegawai',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Indeks Pegawai'
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
                <div class="col-md-2 col-xl-2">
                    <select class="form-select" id="filter-unit">
                        <option value="">Semua Unit</option>
                    </select>
                </div>
                <div class="col-md-2 col-xl-2">
                    <select class="form-select" id="filter-jenis-pegawai">
                        <option value="">Semua Jenis</option>
                        <option value="PNS">PNS</option>
                        <option value="PPPK">PPPK</option>
                        <option value="KONTRAK">Kontrak</option>
                        <option value="HONORER">Honorer</option>
                    </select>
                </div>
                <div class="col-md-2 col-xl-2">
                    <select class="form-select" id="filter-profesi">
                        <option value="">Semua Profesi</option>
                    </select>
                </div>
                <div class="col-md-2 col-xl-3 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                    <button type="button" class="btn btn-success d-flex align-items-center me-2" id="btnSync">
                        <i class="ti ti-refresh text-white me-1 fs-5"></i> Sinkron Data
                    </button>
                    <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Indeks Pegawai
                    </button>
                </div>
            </div>
        </div>

        <div class="card card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>NIK</th>
                            <th>Unit</th>
                            <th>Jenis Pegawai</th>
                            <th>Profesi</th>
                            <th>Cluster 1</th>
                            <th>Cluster 2</th>
                            <th>Cluster 3</th>
                            <th>Cluster 4</th>
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
            <form id="createForm" method="POST" action="{{ route('indeks-pegawai.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" required maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" class="form-control" name="nip" required maxlength="30">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control" name="nik" required maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" name="unit" maxlength="255">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Pegawai</label>
                                <select class="form-select" name="jenis_pegawai">
                                    <option value="">Pilih Jenis Pegawai</option>
                                    <option value="PNS">Pegawai Negeri Sipil</option>
                                    <option value="PPPK">Pegawai Pemerintah dengan Perjanjian Kerja</option>
                                    <option value="KONTRAK">Pegawai Kontrak</option>
                                    <option value="HONORER">Tenaga Honorer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Profesi</label>
                                <select class="form-select" name="profesi_id">
                                    <option value="">Pilih Profesi</option>
                                    @foreach($profesi as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kolom Cluster -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cluster 1</label>
                                <input type="number" step="0.01" class="form-control" name="cluster_1" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cluster 2</label>
                                <input type="number" step="0.01" class="form-control" name="cluster_2" min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cluster 3</label>
                                <input type="number" step="0.01" class="form-control" name="cluster_3" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cluster 4</label>
                                <input type="number" step="0.01" class="form-control" name="cluster_4" min="0">
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
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" id="edit_nama" required maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" class="form-control" name="nip" id="edit_nip" required maxlength="30">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control" name="nik" id="edit_nik" required maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" name="unit" id="edit_unit" maxlength="255">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Pegawai</label>
                                <select class="form-select" name="jenis_pegawai" id="edit_jenis_pegawai">
                                    <option value="">Pilih Jenis Pegawai</option>
                                    <option value="PNS">Pegawai Negeri Sipil</option>
                                    <option value="PPPK">Pegawai Pemerintah dengan Perjanjian Kerja</option>
                                    <option value="KONTRAK">Pegawai Kontrak</option>
                                    <option value="HONORER">Tenaga Honorer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Profesi</label>
                                <select class="form-select" name="profesi_id" id="edit_profesi_id">
                                    <option value="">Pilih Profesi</option>
                                    @foreach($profesi as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kolom Cluster -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cluster 1</label>
                                <input type="number" step="0.01" class="form-control" name="cluster_1" id="edit_cluster_1" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cluster 2</label>
                                <input type="number" step="0.01" class="form-control" name="cluster_2" id="edit_cluster_2" min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cluster 3</label>
                                <input type="number" step="0.01" class="form-control" name="cluster_3" id="edit_cluster_3" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cluster 4</label>
                                <input type="number" step="0.01" class="form-control" name="cluster_4" id="edit_cluster_4" min="0">
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

<!-- Modal Loading Sinkronisasi -->
<div class="modal fade" id="syncModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="ti ti-refresh text-primary me-2"></i>
                    Proses Sinkronisasi Data
                </h5>
            </div>
            <div class="modal-body text-center py-4">
                <!-- Loading Spinner -->
                <div class="mb-4">
                    <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                
                <!-- Progress Info -->
                <h6 class="mb-3">Menyinkronkan data pegawai...</h6>
                <p class="text-muted mb-4">Mohon tunggu, proses ini mungkin memerlukan beberapa saat tergantung jumlah data yang akan disinkronkan.</p>
                
                <!-- Progress Bar -->
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                         role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                
                <!-- Status Text -->
                <small class="text-muted">Mengambil data dari database eprofile dan memperbarui indeks pegawai...</small>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Sinkronisasi -->
<div class="modal fade" id="confirmSyncModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ti ti-alert-triangle text-warning me-2"></i>
                    Konfirmasi Sinkronisasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="ti ti-database-import text-primary" style="font-size: 4rem;"></i>
                </div>
                <h6 class="text-center mb-3">Apakah Anda yakin ingin melakukan sinkronisasi data?</h6>
                <div class="alert alert-info border-0 bg-light-info">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-info-circle text-info me-2"></i>
                        <div>
                            <strong>Proses ini akan:</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Mengambil data pegawai dari database eprofile</li>
                                <li>Memperbarui data indeks pegawai yang sudah ada</li>
                                <li>Menambahkan pegawai baru yang belum terdaftar</li>
                                <li>Menyinkronkan: Nama, NIP, NIK, Unit, Jenis Pegawai, dan Profesi</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <p class="text-muted text-center mb-0">
                    <small>Proses ini mungkin memerlukan beberapa saat tergantung jumlah data.</small>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ti ti-x me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-success" id="confirmSyncBtn">
                    <i class="ti ti-refresh me-1"></i> Ya, Lakukan Sinkronisasi
                </button>
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
        scrollX: true,
        ajax: {
            url: '{{ route('indeks-pegawai.index') }}',
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                width: '50px'
            },
            {data: 'nama', name: 'nama'},
            {data: 'nip', name: 'nip'},
            {data: 'nik', name: 'nik'},
            {data: 'unit_kerja_nama', name: 'unit_kerja_nama'},
            {data: 'jenis_pegawai_label', name: 'jenis_pegawai'},
            {data: 'profesi_nama', name: 'profesi.nama'},
            {data: 'cluster_1', name: 'cluster_1'},
            {data: 'cluster_2', name: 'cluster_2'},
            {data: 'cluster_3', name: 'cluster_3'},
            {data: 'cluster_4', name: 'cluster_4'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
                width: '100px'
            }
        ]
    });

    $('#input-search').on('keyup', function () {
        datatable.search(this.value).draw();
    });

    // Filter by unit
    $('#filter-unit').on('change', function () {
        datatable.column(4).search(this.value).draw(); // Column 4 adalah kolom unit
    });

    // Filter by jenis pegawai
    $('#filter-jenis-pegawai').on('change', function () {
        datatable.column(5).search(this.value).draw(); // Column 5 adalah kolom jenis_pegawai
    });

    // Filter by profesi
    $('#filter-profesi').on('change', function () {
        datatable.column(6).search(this.value).draw(); // Column 6 adalah kolom profesi
    });

    // Populate unit filter options
    datatable.on('draw', function () {
        var units = [];
        datatable.column(4, {search: 'applied'}).data().each(function (value) {
            if (value && units.indexOf(value) === -1) {
                units.push(value);
            }
        });
        
        var select = $('#filter-unit');
        var currentValue = select.val();
        select.find('option:not(:first)').remove();
        
        units.sort().forEach(function (unit) {
            select.append('<option value="' + unit + '">' + unit + '</option>');
        });
        
        select.val(currentValue);
        
        // Populate profesi filter options
        var profesiOptions = [];
        datatable.column(6, {search: 'applied'}).data().each(function (value) {
            if (value && value !== '-' && profesiOptions.indexOf(value) === -1) {
                profesiOptions.push(value);
            }
        });
        
        var profesiSelect = $('#filter-profesi');
        var currentProfesiValue = profesiSelect.val();
        profesiSelect.find('option:not(:first)').remove();
        
        profesiOptions.sort().forEach(function (profesi) {
            profesiSelect.append('<option value="' + profesi + '">' + profesi + '</option>');
        });
        
        profesiSelect.val(currentProfesiValue);
    });

    // Handle tambah data
    $('#createForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.meta.code === 200) {
                    $('#createModal').modal('hide');
                    datatable.ajax.reload();
                    toastr.success(response.meta.message);
                    $('#createForm')[0].reset();
                } else {
                    toastr.error(response.meta.message);
                }
            },
            error: function(xhr) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (xhr.status === 422) {
                        var errors = response.data;
                        var errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                        toastr.error(errorMessage);
                    } else {
                        toastr.error(response.meta.message || 'Terjadi kesalahan pada server');
                    }
                } catch (e) {
                    toastr.error('Terjadi kesalahan pada server');
                }
            }
        });
    });

    // Handle edit data
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                if (response.meta.code === 200) {
                    var data = response.data;
                    console.log('Data received:', data); // Debug
                    console.log('TMT CPNS:', data.tmt_cpns); // Debug
                    console.log('TMT di RS:', data.tmt_di_rs); // Debug
                    
                    $('#edit_nama').val(data.nama);
                    $('#edit_nip').val(data.nip);
                    $('#edit_nik').val(data.nik);
                    $('#edit_unit').val(data.unit);
                    $('#edit_jenis_pegawai').val(data.jenis_pegawai);
                    $('#edit_profesi_id').val(data.profesi_id);
                    $('#edit_cluster_1').val(data.cluster_1);
                    $('#edit_cluster_2').val(data.cluster_2);
                    $('#edit_cluster_3').val(data.cluster_3);
                    $('#edit_cluster_4').val(data.cluster_4);
                    var dataId = data.id;
                    $('#editForm').attr('action', '{{ route('indeks-pegawai.update',':id') }}'.replace(':id', dataId));
                    $('#editModal').modal('show');
                } else {
                    toastr.error(response.meta.message);
                }
            },
            error: function(xhr) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (xhr.status === 422) {
                        var errors = response.data;
                        var errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                        toastr.error(errorMessage);
                    } else {
                        toastr.error(response.meta.message || 'Terjadi kesalahan pada server');
                    }
                } catch (e) {
                    toastr.error('Terjadi kesalahan pada server');
                }
            }
        });
    });

    // Handle update data
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.meta.code === 200) {
                    $('#editModal').modal('hide');
                    datatable.ajax.reload();
                    toastr.success(response.meta.message);
                } else {
                    toastr.error(response.meta.message);
                }
            },
            error: function(xhr) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (xhr.status === 422) {
                        var errors = response.data;
                        var errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                        toastr.error(errorMessage);
                    } else {
                        toastr.error(response.meta.message || 'Terjadi kesalahan pada server');
                    }
                } catch (e) {
                    toastr.error('Terjadi kesalahan pada server');
                }
            }
        });
    });

    // Handle sinkronisasi data - trigger modal konfirmasi
    $('#btnSync').on('click', function(e) {
        e.preventDefault();
        $('#confirmSyncModal').modal('show');
    });

    // Handle konfirmasi sinkronisasi
    $('#confirmSyncBtn').on('click', function(e) {
        e.preventDefault();
        
        // Tutup modal konfirmasi
        $('#confirmSyncModal').modal('hide');
        
        var $btnSync = $('#btnSync');
        var originalText = $btnSync.html();
        
        // Disable button dan ubah text
        $btnSync.prop('disabled', true).html('<i class="ti ti-loader-2 text-white me-1 fs-5 fa-spin"></i> Menyinkronkan...');
        
        // Tampilkan modal loading setelah konfirmasi modal tertutup
        setTimeout(function() {
            $('#syncModal').modal('show');
        }, 300);
        
        $.ajax({
            url: '{{ route('indeks-pegawai.sync') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Sembunyikan modal loading
                $('#syncModal').modal('hide');
                
                if (response.meta.code === 200) {
                    datatable.ajax.reload(); // Reload tabel
                    
                    // Tampilkan notifikasi sukses dengan detail
                    var successMessage = response.meta.message;
                    if (response.data && (response.data.synced_count > 0 || response.data.updated_count > 0)) {
                        successMessage += '<br><br><strong>Detail:</strong><br>';
                        successMessage += '• Data baru ditambahkan: ' + response.data.synced_count + '<br>';
                        successMessage += '• Data yang diperbarui: ' + response.data.updated_count;
                    }
                    
                    toastr.success(successMessage, 'Sinkronisasi Berhasil!', {
                        timeOut: 8000,
                        extendedTimeOut: 4000
                    });
                } else {
                    toastr.error(response.meta.message, 'Sinkronisasi Gagal!');
                }
            },
            error: function(xhr) {
                // Sembunyikan modal loading
                $('#syncModal').modal('hide');
                
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (xhr.status === 422 && response.data) {
                        // Tampilkan error dalam bentuk list
                        var errorMessage = response.meta.message + '<br><br><strong>Detail Error:</strong><br>';
                        if (Array.isArray(response.data)) {
                            response.data.forEach(function(error) {
                                errorMessage += '• ' + error + '<br>';
                            });
                        }
                        toastr.error(errorMessage, 'Sinkronisasi Gagal!', {
                            timeOut: 10000,
                            extendedTimeOut: 5000
                        });
                    } else {
                        toastr.error(response.meta.message || 'Terjadi kesalahan pada server', 'Sinkronisasi Gagal!');
                    }
                } catch (e) {
                    toastr.error('Terjadi kesalahan pada server', 'Sinkronisasi Gagal!');
                }
            },
            complete: function() {
                // Kembalikan button ke state semula
                $btnSync.prop('disabled', false).html(originalText);
            }
        });
    });
});
</script>
@endpush 