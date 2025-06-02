@extends('root')
@section('title', 'Data Detail Source')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Data Detail Source',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
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
            <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
              <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Detail Source
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
                        <th>No SEP</th>
                        <th>Tanggal Verifikasi</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Source</th>
                        <th>Biaya Riil RS</th>
                        <th>Biaya Diajukan</th>
                        <th>Biaya Disetujui</th>
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
                        <label class="form-label">Remunerasi Source</label>
                        <select class="form-select" name="id_remunerasi_source" required>
                            <option value="">Pilih Source</option>
                            @foreach($remunerasiSources as $source)
                                <option value="{{ $source->id }}">{{ $source->nama_source }}</option>
                            @endforeach
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
                        <label class="form-label">Remunerasi Source</label>
                        <select class="form-select" name="id_remunerasi_source" id="edit_id_remunerasi_source" required>
                            <option value="">Pilih Source</option>
                            @foreach($remunerasiSources as $source)
                                <option value="{{ $source->id }}">{{ $source->nama_source }}</option>
                            @endforeach
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Progress -->
<div class="modal fade" id="progressModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Progress Sinkronisasi</h5>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="progress mb-3">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" id="progressBar">0%</div>
                </div>
                <div class="row text-center">
                    <div class="col-md-4">
                        <h5 class="mb-0" id="totalProcessed">0</h5>
                        <small class="text-muted">Total Diproses</small>
                    </div>
                    <div class="col-md-4">
                        <h5 class="mb-0 text-success" id="totalSuccess">0</h5>
                        <small class="text-muted">Berhasil</small>
                    </div>
                    <div class="col-md-4">
                        <h5 class="mb-0 text-danger" id="totalFailed">0</h5>
                        <small class="text-muted">Gagal</small>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="alert alert-info mb-0">
                        <div id="syncStatus">Memulai sinkronisasi...</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCancelSync" onclick="cancelSync()">Batalkan</button>
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
            url: '{{ route('detail-source.index') }}',
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {data: 'no_sep', name: 'no_sep'},
            {data: 'tgl_verifikasi', name: 'tgl_verifikasi'},
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
                data: 'remunerasi_source.nama_source',
                name: 'remunerasi_source.nama_source'
            },
            {
                data: 'biaya_riil_rs',
                name: 'biaya_riil_rs',
                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')
            },
            {
                data: 'biaya_diajukan',
                name: 'biaya_diajukan',
                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')
            },
            {
                data: 'biaya_disetujui',
                name: 'biaya_disetujui',
                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ')
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
    $('#createForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.meta.status === 'success') {
                    $('#createModal').modal('hide');
                    form[0].reset();
                    datatable.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.meta.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                var response = xhr.responseJSON;
                var errorMessage = '';
                
                if (response.meta.status === 'error') {
                    if (typeof response.data === 'object') {
                        $.each(response.data, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                    } else {
                        errorMessage = response.meta.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: errorMessage
                    });
                }
            }
        });
    });

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
                $('#edit_id_remunerasi_source').val(data.id_remunerasi_source);
                $('#edit_biaya_riil_rs').val(data.biaya_riil_rs);
                $('#edit_biaya_diajukan').val(data.biaya_diajukan);
                $('#edit_biaya_disetujui').val(data.biaya_disetujui);
                $('#editModal').modal('show');
            }
        });
    });

    // Handle Edit Form Submit
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        
        $.ajax({
            url: url,
            type: 'PUT',
            data: form.serialize(),
            success: function(response) {
                if (response.meta.status === 'success') {
                    $('#editModal').modal('hide');
                    datatable.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.meta.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                var response = xhr.responseJSON;
                var errorMessage = '';
                
                if (response.meta.status === 'error') {
                    if (typeof response.data === 'object') {
                        $.each(response.data, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                    } else {
                        errorMessage = response.meta.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: errorMessage
                    });
                }
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

// Tambahkan fungsi untuk update progress
function updateProgress(processed, success, failed, total) {
    const percentage = Math.round((processed / total) * 100);
    
    $('#progressBar').css('width', percentage + '%').text(percentage + '%');
    $('#totalProcessed').text(processed);
    $('#totalSuccess').text(success);
    $('#totalFailed').text(failed);
    
    // Update status message
    let statusMessage = `Memproses ${processed} dari ${total} data`;
    if (success > 0) {
        statusMessage += ` (${success} berhasil`;
        if (failed > 0) {
            statusMessage += `, ${failed} gagal`;
        }
        statusMessage += ')';
    }
    $('#syncStatus').text(statusMessage);
}

// Tambahkan variabel untuk kontrol sinkronisasi
let isSyncing = false;
let shouldCancelSync = false;

function startSync(sourceId, total) {
    isSyncing = true;
    shouldCancelSync = false;
    
    // Reset progress
    updateProgress(0, 0, 0, total);
    $('#progressModal').modal('show');
    
    // Mulai proses sync
    processNextBatch(sourceId, 0, 0, 0, total);
}

function cancelSync() {
    shouldCancelSync = true;
    $('#btnCancelSync').prop('disabled', true).text('Membatalkan...');
    $('#syncStatus').text('Membatalkan proses sinkronisasi...');
}

function processNextBatch(sourceId, offset, totalSuccess, totalFailed, total) {
    if (shouldCancelSync) {
        isSyncing = false;
        $('#progressModal').modal('hide');
        Swal.fire({
            icon: 'info',
            title: 'Sinkronisasi Dibatalkan',
            text: `Proses dihentikan. ${totalSuccess} data berhasil diproses, ${totalFailed} data gagal.`
        });
        return;
    }

    $.ajax({
        url: `/detail-source/sync-batch/${sourceId}`,
        type: 'POST',
        data: {
            offset: offset,
            limit: 10,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.success) {
                const newProcessed = offset + response.processed;
                const newSuccess = totalSuccess + response.success;
                const newFailed = totalFailed + response.failed;
                
                updateProgress(newProcessed, newSuccess, newFailed, total);
                
                if (response.hasMore && !shouldCancelSync) {
                    // Proses batch berikutnya
                    processNextBatch(sourceId, newProcessed, newSuccess, newFailed, total);
                } else {
                    // Selesai
                    isSyncing = false;
                    $('#progressModal').modal('hide');
                    
                    let message = `Sinkronisasi selesai. ${newSuccess} data berhasil diproses`;
                    if (newFailed > 0) {
                        message += `, ${newFailed} data gagal`;
                    }
                    
                    Swal.fire({
                        icon: newFailed > 0 ? 'warning' : 'success',
                        title: 'Sinkronisasi Selesai',
                        text: message
                    });
                }
            } else {
                handleSyncError('Gagal memproses data: ' + response.message);
            }
        },
        error: function(xhr) {
            handleSyncError('Terjadi kesalahan saat sinkronisasi');
        }
    });
}

function handleSyncError(message) {
    isSyncing = false;
    $('#progressModal').modal('hide');
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message
    });
}

// Tambahkan event handler untuk tombol sync
$(document).on('click', '.btn-sync', function() {
    if (isSyncing) {
        Swal.fire({
            icon: 'warning',
            title: 'Proses Sedang Berjalan',
            text: 'Mohon tunggu hingga proses sinkronisasi selesai'
        });
        return;
    }

    const sourceId = $(this).data('id');
    
    // Get total unsynchronized data
    $.get(`/detail-source/unsynced-count/${sourceId}`, function(response) {
        if (response.success && response.total > 0) {
            Swal.fire({
                title: 'Konfirmasi Sinkronisasi',
                text: `Akan memproses ${response.total} data. Lanjutkan?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    startSync(sourceId, response.total);
                }
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Tidak Ada Data',
                text: 'Tidak ada data yang perlu disinkronkan'
            });
        }
    }).fail(function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Gagal mendapatkan jumlah data'
        });
    });
});
</script>
@endpush 