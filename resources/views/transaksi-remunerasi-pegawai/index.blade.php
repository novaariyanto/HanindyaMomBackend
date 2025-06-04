@extends('root')

@section('title', 'Transaksi Remunerasi Pegawai')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Transaksi Remunerasi Pegawai',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Transaksi Remunerasi Pegawai'
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
                    <div class="me-2">
                        <select class="form-select" id="filter-batch">
                            <option value="">Semua Batch</option>
                            @foreach($remunerasi_batch as $batch)
                                <option value="{{ $batch->id }}">{{ $batch->nama_batch }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-info d-flex align-items-center me-2" onclick="syncBatchData()">
                        <i class="ti ti-refresh text-white me-1 fs-5"></i> Sync Data
                    </button>
                    <button type="button" class="btn btn-secondary d-flex align-items-center me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="ti ti-file-import text-white me-1 fs-5"></i> Import Excel
                    </button>
                    <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Transaksi
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
                            <th>NIP</th>
                            <th>Nama Pegawai</th>
                            <th>Jabatan</th>
                            <th>Unit Kerja</th>
                            <th>Batch</th>
                            <th>Indeks Cluster 1</th>
                            <th>Indeks Cluster 2</th>
                            <th>Indeks Cluster 3</th>
                            <th>Indeks Cluster 4</th>
                            <th>Nilai Indeks 1</th>
                            <th>Nilai Indeks 2</th>
                            <th>Nilai Indeks 3</th>
                            <th>Nilai Indeks 4</th>
                            <th>Nilai Remunerasi</th>
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
                <h5 class="modal-title">Tambah Transaksi Remunerasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('transaksi-remunerasi-pegawai.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pegawai</label>
                                <select class="form-select" name="id_pegawai" required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach($pegawai as $p)
                                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Batch Remunerasi</label>
                                <select class="form-select" name="id_remunerasi_batch" required>
                                    <option value="">Pilih Batch</option>
                                    @foreach($remunerasi_batch as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->nama_batch }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Source Remunerasi</label>
                                <select class="form-select" name="id_remunerasi_source" required>
                                    <option value="">Pilih Source</option>
                                    @foreach($remunerasi_source as $source)
                                        <option value="{{ $source->id }}">{{ $source->nama_source }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Cluster 1</label>
                                <input type="number" step="0.01" class="form-control" name="indeks_cluster_1" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Indeks Cluster 2</label>
                                <input type="number" step="0.01" class="form-control" name="indeks_cluster_2" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Indeks Cluster 3</label>
                                <input type="number" step="0.01" class="form-control" name="indeks_cluster_3" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Indeks Cluster 4</label>
                                <input type="number" step="0.01" class="form-control" name="indeks_cluster_4" required min="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nilai Indeks 1</label>
                                <input type="number" step="0.01" class="form-control" name="nilai_indeks_1" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nilai Indeks 2</label>
                                <input type="number" step="0.01" class="form-control" name="nilai_indeks_2" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nilai Indeks 3</label>
                                <input type="number" step="0.01" class="form-control" name="nilai_indeks_3" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nilai Indeks 4</label>
                                <input type="number" step="0.01" class="form-control" name="nilai_indeks_4" required min="0">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai Remunerasi</label>
                        <input type="number" step="0.01" class="form-control" name="nilai_remunerasi" required min="0">
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
                <h5 class="modal-title">Edit Transaksi Remunerasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pegawai</label>
                                <select class="form-select" name="id_pegawai" id="edit_id_pegawai" required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach($pegawai as $p)
                                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Batch Remunerasi</label>
                                <select class="form-select" name="id_remunerasi_batch" id="edit_id_remunerasi_batch" required>
                                    <option value="">Pilih Batch</option>
                                    @foreach($remunerasi_batch as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->nama_batch }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Source Remunerasi</label>
                                <select class="form-select" name="id_remunerasi_source" id="edit_id_remunerasi_source" required>
                                    <option value="">Pilih Source</option>
                                    @foreach($remunerasi_source as $source)
                                        <option value="{{ $source->id }}">{{ $source->nama_source }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Cluster 1</label>
                                <input type="number" step="0.01" class="form-control" name="indeks_cluster_1" id="edit_indeks_cluster_1" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Indeks Cluster 2</label>
                                <input type="number" step="0.01" class="form-control" name="indeks_cluster_2" id="edit_indeks_cluster_2" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Indeks Cluster 3</label>
                                <input type="number" step="0.01" class="form-control" name="indeks_cluster_3" id="edit_indeks_cluster_3" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Indeks Cluster 4</label>
                                <input type="number" step="0.01" class="form-control" name="indeks_cluster_4" id="edit_indeks_cluster_4" required min="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nilai Indeks 1</label>
                                <input type="number" step="0.01" class="form-control" name="nilai_indeks_1" id="edit_nilai_indeks_1" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nilai Indeks 2</label>
                                <input type="number" step="0.01" class="form-control" name="nilai_indeks_2" id="edit_nilai_indeks_2" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nilai Indeks 3</label>
                                <input type="number" step="0.01" class="form-control" name="nilai_indeks_3" id="edit_nilai_indeks_3" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nilai Indeks 4</label>
                                <input type="number" step="0.01" class="form-control" name="nilai_indeks_4" id="edit_nilai_indeks_4" required min="0">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai Remunerasi</label>
                        <input type="number" step="0.01" class="form-control" name="nilai_remunerasi" id="edit_nilai_remunerasi" required min="0">
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

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Transaksi Remunerasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="importForm" action="{{ route('transaksi-remunerasi-pegawai.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File Excel</label>
                        <input type="file" class="form-control" name="file" accept=".xlsx,.xls" required>
                        <div class="form-text">Format file: .xlsx atau .xls</div>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('transaksi-remunerasi-pegawai.template') }}" class="btn btn-sm btn-info">
                            <i class="ti ti-download"></i> Download Template
                        </a>
                    </div>
                    <!-- Progress Bar -->
                    <div id="import-progress" class="d-none">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                        <div class="alert alert-info mb-0">
                            <div>Total Data: <span id="total-rows">0</span></div>
                            <div>Berhasil: <span id="success-count" class="text-success">0</span></div>
                            <div>Gagal: <span id="failed-count" class="text-danger">0</span></div>
                            <div id="current-status">Mempersiapkan import...</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-import">Import</button>
                </div>
            </form>
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
            url: '{{ route('transaksi-remunerasi-pegawai.index') }}',
            data: function(d) {
                d.batch = $('#filter-batch').val();
            }
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {data: 'pegawai.nip', name: 'pegawai.nip'},
            {data: 'pegawai.nama', name: 'pegawai.nama'},
            {data: 'pegawai.jabatan', name: 'pegawai.jabatan'},
            {data: 'pegawai.unit_kerja', name: 'pegawai.unit_kerja'},
            {data: 'remunerasi_batch.nama_batch', name: 'remunerasi_batch.nama_batch'},
            {data: 'indeks_cluster_1', name: 'indeks_cluster_1'},
            {data: 'indeks_cluster_2', name: 'indeks_cluster_2'},
            {data: 'indeks_cluster_3', name: 'indeks_cluster_3'},
            {data: 'indeks_cluster_4', name: 'indeks_cluster_4'},
            {
                data: 'nilai_indeks_1',
                name: 'nilai_indeks_1',
                render: function(data) {
                    return parseFloat(data).toLocaleString('id-ID', {minimumFractionDigits: 2});
                }
            },
            {
                data: 'nilai_indeks_2',
                name: 'nilai_indeks_2',
                render: function(data) {
                    return parseFloat(data).toLocaleString('id-ID', {minimumFractionDigits: 2});
                }
            },
            {
                data: 'nilai_indeks_3',
                name: 'nilai_indeks_3',
                render: function(data) {
                    return parseFloat(data).toLocaleString('id-ID', {minimumFractionDigits: 2});
                }
            },
            {
                data: 'nilai_indeks_4',
                name: 'nilai_indeks_4',
                render: function(data) {
                    return parseFloat(data).toLocaleString('id-ID', {minimumFractionDigits: 2});
                }
            },
            {
                data: 'nilai_remunerasi',
                name: 'nilai_remunerasi',
                render: function(data) {
                    return 'Rp ' + parseFloat(data).toLocaleString('id-ID', {minimumFractionDigits: 2});
                }
            },
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

    $('#filter-batch').on('change', function() {
        datatable.ajax.reload();
    });

    // Handle Create Form Submit


    // Handle Edit Button Click
    $(document).on('click', '.btn-edit', function() {
        var url = $(this).data('url');
        
        $.get(url, function(response) {
            if (response.meta.status === 'success') {
                var data = response.data;
                $('#editForm').attr('action', url);
                $('#edit_id_pegawai').val(data.id_pegawai);
                $('#edit_id_remunerasi_batch').val(data.id_remunerasi_batch);
                $('#edit_id_remunerasi_source').val(data.id_remunerasi_source);
                $('#edit_indeks_cluster_1').val(data.indeks_cluster_1);
                $('#edit_indeks_cluster_2').val(data.indeks_cluster_2);
                $('#edit_indeks_cluster_3').val(data.indeks_cluster_3);
                $('#edit_indeks_cluster_4').val(data.indeks_cluster_4);
                $('#edit_nilai_indeks_1').val(data.nilai_indeks_1);
                $('#edit_nilai_indeks_2').val(data.nilai_indeks_2);
                $('#edit_nilai_indeks_3').val(data.nilai_indeks_3);
                $('#edit_nilai_indeks_4').val(data.nilai_indeks_4);
                $('#edit_nilai_remunerasi').val(data.nilai_remunerasi);
                $('#editModal').modal('show');
            }
        });
    });

    // Handle Edit Form Submit


    // Handle Delete Button Click
 

    // Reset form when modal is closed
    $('#createModal').on('hidden.bs.modal', function () {
        $('#createForm')[0].reset();
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $('#editForm')[0].reset();
    });

    // Handle form import submit with progress
    $('#importForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(this);
        var importBtn = $('#btn-import');
        var progressBar = $('#import-progress');
        var progressBarInner = progressBar.find('.progress-bar');
        var totalRows = $('#total-rows');
        var successCount = $('#success-count');
        var failedCount = $('#failed-count');
        var currentStatus = $('#current-status');

        // Reset progress
        progressBar.removeClass('d-none');
        progressBarInner.css('width', '0%').attr('aria-valuenow', 0).text('0%');
        totalRows.text('0');
        successCount.text('0');
        failedCount.text('0');
        currentStatus.text('Mempersiapkan import...');
        importBtn.prop('disabled', true);

        // First request to prepare import
        $.ajax({
            url: form.attr('action') + '?action=prepare',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status === 'success') {
                    totalRows.text(response.data.total_rows);
                    processChunk(1, response.data.total_chunks, form.attr('action'), formData);
                } else {
                    showError(response.message);
                }
            },
            error: function(xhr) {
                showError('Terjadi kesalahan saat mempersiapkan import');
            }
        });

        function processChunk(currentChunk, totalChunks, url, formData) {
            formData.append('chunk', currentChunk);
            formData.append('total_chunks', totalChunks);

            $.ajax({
                url: url + '?action=process',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status === 'success') {
                        // Update progress
                        var progress = Math.round((currentChunk / totalChunks) * 100);
                        progressBarInner.css('width', progress + '%')
                            .attr('aria-valuenow', progress)
                            .text(progress + '%');
                        
                        successCount.text(parseInt(successCount.text()) + response.data.success);
                        failedCount.text(parseInt(failedCount.text()) + response.data.failed);
                        currentStatus.text('Memproses chunk ' + currentChunk + ' dari ' + totalChunks);

                        // Process next chunk if available
                        if(currentChunk < totalChunks) {
                            processChunk(currentChunk + 1, totalChunks, url, formData);
                        } else {
                            // Import completed
                            currentStatus.text('Import selesai');
                            importBtn.prop('disabled', false);
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Import Selesai',
                                html: 'Berhasil: ' + successCount.text() + '<br>Gagal: ' + failedCount.text(),
                            }).then((result) => {
                                $('#importModal').modal('hide');
                                datatable.ajax.reload();
                            });
                        }
                    } else {
                        showError(response.message);
                    }
                },
                error: function(xhr) {
                    showError('Terjadi kesalahan saat memproses chunk ' + currentChunk);
                }
            });
        }

        function showError(message) {
            importBtn.prop('disabled', false);
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: message
            });
        }
    });
});

function syncBatchData() {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Proses ini akan menyinkronkan semua data remunerasi. Proses ini mungkin memakan waktu beberapa menit. Lanjutkan?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Lanjutkan',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return startBatchSync();
        },
        allowOutsideClick: () => !Swal.isLoading()
    });
}

function startBatchSync() {
    let processedCount = 0;
    let successCount = 0;
    let failedCount = 0;
    let totalRecords = 0;

    // Tampilkan progress dialog
    Swal.fire({
        title: 'Memproses Sinkronisasi',
        html: `
            <div class="progress mb-3" style="height: 20px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>
            <div class="mt-3">
                <p>Total Data: <span id="totalRecords">0</span></p>
                <p>Berhasil: <span id="successCount" class="text-success">0</span></p>
                <p>Gagal: <span id="failedCount" class="text-danger">0</span></p>
                <p>Sedang Memproses: <span id="currentRecord">-</span></p>
            </div>
        `,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false
    });

    // Ambil total records
    $.ajax({
        url: '/transaksi-remunerasi-pegawai/get-unsynced-count',
        type: 'GET',
        success: function(response) {
            totalRecords = response.total;
            $('#totalRecords').text(totalRecords);
            processBatch(0);
        },
        error: function(xhr) {
            Swal.fire('Error', 'Gagal mengambil data', 'error');
        }
    });

    function updateProgress() {
        const percentage = Math.round((processedCount / totalRecords) * 100);
        $('.progress-bar').css('width', percentage + '%').text(percentage + '%');
        $('#successCount').text(successCount);
        $('#failedCount').text(failedCount);
    }

    function processBatch(offset) {
        $.ajax({
            url: '/transaksi-remunerasi-pegawai/sync-batch',
            type: 'POST',
            data: {
                offset: offset,
                limit: 5
            },
            success: function(response) {
                processedCount += response.processed;
                successCount += response.success;
                failedCount += response.failed;
                
                updateProgress();
                
                if (response.hasMore) {
                    processBatch(offset + 1);
                } else {
                    // Selesai
                    Swal.fire({
                        title: 'Sinkronisasi Selesai',
                        html: `
                            Total Data: ${totalRecords}<br>
                            Berhasil: ${successCount}<br>
                            Gagal: ${failedCount}
                        `,
                        icon: 'success'
                    }).then(() => {
                        datatable.ajax.reload();
                    });
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Gagal memproses batch', 'error');
            }
        });
    }
}
</script>
@endpush 