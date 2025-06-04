@extends('root')

@section('title', 'Detail Source - ' . $source->nama_source)

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Detail Source - ' . $source->nama_source,
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('remunerasi-source.index'), 'label' => 'Remunerasi Source'],
        ],
        'current' => 'Detail Source'
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
          
             <button type="button" class="btn btn-info d-flex align-items-center me-2" onclick="syncBatchData()">
                <i class="ti ti-refresh text-white me-1 fs-5"></i> Sync Semua Data
            </button>
       
            <button type="button" class="btn btn-secondary d-flex align-items-center me-2" data-bs-toggle="modal" data-bs-target="#importModal">
              <i class="ti ti-file-import text-white me-1 fs-5"></i> Import Excel
            </button>
            <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
              <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Detail Source
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
                        <th>No SEP</th>
                        <th>Tanggal Verifikasi</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Biaya Riil RS</th>
                        <th>Biaya Diajukan</th>
                        <th>Biaya Disetujui</th>
                        <th>Idxdaftar</th>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Detail Source</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('detail-source.store') }}">
                @csrf
                <input type="hidden" name="id_remunerasi_source" value="{{ $source->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">No SEP</label>
                        <input type="text" class="form-control" name="no_sep" required maxlength="30">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Verifikasi</label>
                        <input type="date" class="form-control" name="tgl_verifikasi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <input type="text" class="form-control" name="jenis" required maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya Riil RS</label>
                        <input type="number" step="0.01" class="form-control" name="biaya_riil_rs" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya Diajukan</label>
                        <input type="number" step="0.01" class="form-control" name="biaya_diajukan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya Disetujui</label>
                        <input type="number" step="0.01" class="form-control" name="biaya_disetujui" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Idxdaftar</label>
                        <input type="text" class="form-control" name="idxdaftar" required>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Detail Source</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_remunerasi_source" value="{{ $source->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">No SEP</label>
                        <input type="text" class="form-control" name="no_sep" id="edit_no_sep" required maxlength="30">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Verifikasi</label>
                        <input type="date" class="form-control" name="tgl_verifikasi" id="edit_tgl_verifikasi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <input type="text" class="form-control" name="jenis" id="edit_jenis" required maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit_status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya Riil RS</label>
                        <input type="number" step="0.01" class="form-control" name="biaya_riil_rs" id="edit_biaya_riil_rs" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya Diajukan</label>
                        <input type="number" step="0.01" class="form-control" name="biaya_diajukan" id="edit_biaya_diajukan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya Disetujui</label>
                        <input type="number" step="0.01" class="form-control" name="biaya_disetujui" id="edit_biaya_disetujui" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Idxdaftar</label>
                        <input type="text" class="form-control" name="idxdaftar" id="edit_idxdaftar" required>
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
                <h5 class="modal-title">Import Data Detail Source</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="importForm" action="{{ route('detail-source.import', $source->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File Excel</label>
                        <input type="file" class="form-control" name="file" accept=".xlsx,.xls" required>
                        <div class="form-text">Format file: .xlsx atau .xls</div>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('detail-source.template') }}" class="btn btn-sm btn-info">
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
<script

<script>
$(document).ready(function() {
    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('detail-source.getBySource', $source->id) }}',
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {data: 'no_sep', name: 'no_sep', render: function(data, type, row) {
                return data.length < 16 ? `${data}` : data;
            }},
            {data: 'tgl_verifikasi', name: 'tgl_verifikasi', render: function(data) {
                return moment(data).format('DD/MM/YYYY');
            }},
            {data: 'jenis', name: 'jenis'},
            {
                data: 'status',
                name: 'status',
                render: function(data) {
                    return data == 1 ? 
                        '<span class="badge bg-success">Aktif</span>' : 
                        '<span class="badge bg-danger">Nonaktif</span>';
                }
            },
            {
                data: 'biaya_riil_rs',
                name: 'biaya_riil_rs',
            },
            {
                data: 'biaya_diajukan',
                name: 'biaya_diajukan'
            },
            {
                data: 'biaya_disetujui',
                name: 'biaya_disetujui'
            },
            {
                data: 'idxdaftar',
                name: 'idxdaftar'
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

    // Handle Create Form Submit
  
    // Handle Edit Button Click
    $(document).on('click', '.btn-edit', function() {
        var url = $(this).data('url');
        
        $.get(url, function(response) {
            if (response.meta.status === 'success') {
                var data = response.data;
                $('#editForm').attr('action', url);
                $('#edit_no_sep').val(data.no_sep);
                $('#edit_tgl_verifikasi').val(data.tgl_verifikasi);
                $('#edit_jenis').val(data.jenis);
                $('#edit_status').val(data.status);
                $('#edit_biaya_riil_rs').val(data.biaya_riil_rs);
                $('#edit_biaya_diajukan').val(data.biaya_diajukan);
                $('#edit_biaya_disetujui').val(data.biaya_disetujui);
                $('#edit_idxdaftar').val(data.idxdaftar);
                $('#editModal').modal('show');
            }
        });
    });

    // Handle Edit Form Submit

    // Handle Delete Button Click
  
    // Reset form when modal is closed
    $('#createModal').on('hidden.bs.modal', function () {
        $('#createForm')[0].reset();
        $('input[name=id_remunerasi_source]').val("{{ $source->id }}");
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
        text: 'Proses ini akan menyinkronkan semua data SEP. Proses ini mungkin memakan waktu beberapa menit. Lanjutkan?',
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
        url: '/detail-source/get-unsynced-count/{{ $source->id }}',
        type: 'GET',
        success: function(response) {
            totalRecords = response.total;
            console.log("rotalrec :"+totalRecords);
            $('#totalRecords').text(totalRecords);
            processBatch(0);
        },
        error: function(xhr) {
            Swal.fire('Error', 'Gagal mengambil data', 'error');
        }
    });

    function updateProgress() {
        const percentage = Math.round((processedCount / totalRecords) * 100);
        console.log("percentage :"+percentage);
        console.log("processedCount :"+processedCount);
        console.log("totalRecords :"+totalRecords);
        $('.progress-bar').css('width', percentage + '%').text(percentage + '%');
        $('#successCount').text(successCount);
        $('#failedCount').text(failedCount);
    }

    function processBatch(offset) {
        $.ajax({
            url: '/detail-source/sync-batch/{{ $source->id }}',
            type: 'POST',
            data: {
                offset: offset,
                limit: 5 // Proses 100 data per batch
            },
            success: function(response) {
                processedCount += response.processed;
                successCount += response.success;
                failedCount += response.failed;
                
                updateProgress();
                
                if (response.hasMore) {
                    const percentage = Math.round((processedCount / totalRecords) * 100);
                    if(percentage == 100){
                        // Masih ada data yang perlu diproses
                        // processBatch(offset + 1);
                    }else{
                          processBatch(offset + 1);
                    }
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