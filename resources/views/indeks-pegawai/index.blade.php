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
                    <select class="form-select" id="filter-unit-kerja">
                        <option value="">Semua Unit</option>
                        @foreach($unitKerja as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-xl-2">
                    <select class="form-select" id="filter-jenis-pegawai">
                        <option value="">Semua Jenis</option>
                        @foreach($jenisPegawai as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-xl-2">
                    <select class="form-select" id="filter-profesi">
                        <option value="">Semua Profesi</option>
                        @foreach($dprofesi as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
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
                                    @foreach($jenisPegawai as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Profesi</label>
                                <select class="form-select" name="profesi_id">
                                    <option value="">Pilih Profesi</option>
                                    @foreach($dprofesi as $item)
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
                                <select class="form-select" name="unit" id="edit_unit">
                                    <option value="">Pilih Unit</option>
                                    @foreach($unitKerja as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Pegawai</label>
                                <select class="form-select" name="jenis_pegawai" id="edit_jenis_pegawai">
                                    <option value="">Pilih Jenis Pegawai</option>
                                    @foreach($jenisPegawai as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Profesi</label>
                                <select class="form-select" name="profesi_id" id="edit_profesi_id">
                                    <option value="">Pilih Profesi</option>
                                    @foreach($dprofesi as $item)
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
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        scrollX: true,
        ajax: {
            url: '{{ route("indeks-pegawai.index") }}',
            data: function(d) {
                d.profesi_id = $('#filter-profesi').val();
                d.unit_kerja_id = $('#filter-unit-kerja').val();
                d.jenis_pegawai = $('#filter-jenis-pegawai').val();
                d.search = $('#input-search').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nama', name: 'nama' },
            { data: 'unit_kerja_nama', name: 'unit_kerja_nama' },
            { data: 'jenis_pegawai', name: 'jenis_pegawai' },
            { data: 'profesi_nama', name: 'profesi_nama' },
            { data: 'cluster_1', name: 'cluster_1' },
            { data: 'cluster_2', name: 'cluster_2' },
            { data: 'cluster_3', name: 'cluster_3' },
            { data: 'cluster_4', name: 'cluster_4' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
    });

    // Event listener untuk filter
    $('#filter-profesi, #filter-unit-kerja, #filter-jenis-pegawai').change(function() {
        table.draw();
    });

    // Event listener untuk pencarian
    $('#input-search').keyup(function() {
        table.draw();
    });

    // Event handler untuk tombol sync
    $('#btnSync').click(function() {
        $.ajax({
            url: '{{ route("indeks-pegawai.sync") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Mohon Tunggu',
                    text: 'Sedang melakukan sinkronisasi data...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message
                });
                table.ajax.reload();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan saat sinkronisasi data'
                });
            }
        });
    });

    // Event handler untuk tombol edit
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        
        $.get(url, function(response) {
            if(response.meta.status === 'success') {
                var data = response.data;
                $('#editForm').attr('action', url);
                $('#edit_nama').val(data.nama);
                $('#edit_nip').val(data.nip);
                $('#edit_nik').val(data.nik);
                $('#edit_unit').val(data.unit_kerja_id);
                $('#edit_jenis_pegawai').val(data.jenis_pegawai);
                $('#edit_profesi_id').val(data.profesi_id);
                $('#edit_cluster_1').val(data.cluster_1);
                $('#edit_cluster_2').val(data.cluster_2);
                $('#edit_cluster_3').val(data.cluster_3);
                $('#edit_cluster_4').val(data.cluster_4);
                $('#editModal').modal('show');
            }
        });
    });


});
</script>
@endpush 