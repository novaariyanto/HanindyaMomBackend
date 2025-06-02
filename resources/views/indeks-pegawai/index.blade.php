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
                <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
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

    
});
</script>
@endpush 