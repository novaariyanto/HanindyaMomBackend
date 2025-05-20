@extends('root')
@section('title', 'List Source Remunerasi')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'List Source Remunerasi',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('remunerasi-batch.index'), 'label' => 'Remunerasi Batch'],
        ],
        'current' => 'List Source'
    ])
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Batch: {{ $batch->nama_batch }} ({{ $batch->tahun }})</h5>
                    
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="col-md-4">
                            <form class="position-relative">
                                <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Cari Source">
                                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </form>
                        </div>
                        <div>
                            <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Source
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Source</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
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
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Source</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('remunerasi-source.store') }}">
                @csrf
                <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Source</label>
                        <input type="text" class="form-control" name="nama_source" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
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
                <h5 class="modal-title">Edit Source</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Source</label>
                        <input type="text" class="form-control" name="nama_source" id="edit_nama_source" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="edit_keterangan" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit_status" required>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
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

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('remunerasi-source.by-batch', $batch->id) }}',
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'nama_source',
                name: 'nama_source'
            },
            {
                data: 'keterangan',
                name: 'keterangan'
            },
            {
                data: 'status',
                name: 'status',
                render: function(data) {
                    return data === 'aktif' ? 
                        '<span class="badge bg-success">Aktif</span>' : 
                        '<span class="badge bg-danger">Nonaktif</span>';
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
        
        $.get(url, function(data) {
            var data = data.data;
            $('#editForm').attr('action', url);
            $('#edit_nama_source').val(data.nama_source);
            $('#edit_keterangan').val(data.keterangan);
            $('#edit_status').val(data.status);
            $('#editModal').modal('show');
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

    // Handle Delete Button Click

    // Reset form when modal is closed
    $('#createModal').on('hidden.bs.modal', function () {
        $('#createForm')[0].reset();
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $('#editForm')[0].reset();
    });
});
</script>
@endpush 