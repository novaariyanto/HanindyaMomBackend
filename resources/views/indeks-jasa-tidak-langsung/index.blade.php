@extends('root')

@section('title', 'Indeks Jasa Tidak Langsung')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Indeks Jasa Tidak Langsung',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Indeks Jasa Tidak Langsung'
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
                        <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Indeks Jasa Tidak Langsung
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
                            <th>Nama Indeks</th>
                            <th>Nilai</th>
                            <th>Kategori</th>
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
                <h5 class="modal-title">Tambah Indeks Jasa Tidak Langsung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('indeks-jasa-tidak-langsung.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Indeks</label>
                        <input type="text" class="form-control" name="nama_indeks" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai</label>
                        <input type="number" step="0.01" class="form-control" name="nilai" required min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-control" name="kategori_id" id="kategori_id" required>
                            <option value="">Pilih Kategori</option>
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
                <h5 class="modal-title">Edit Indeks Jasa Tidak Langsung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="PUT">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Indeks</label>
                        <input type="text" class="form-control" name="nama_indeks" id="edit_nama_indeks" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nilai</label>
                        <input type="number" step="0.01" class="form-control" name="nilai" id="edit_nilai" required min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-control" name="kategori_id" id="edit_kategori_id" required>
                            <option value="">Pilih Kategori</option>
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
    // Load kategori data
    function loadKategori() {
        $.ajax({
            url: '{{ route('kategori-tidak-langsung.index') }}',
            type: 'GET',
            data: {
                'get_all': true
            },
            success: function(response) {
                var options = '<option value="">Pilih Kategori</option>';
                if (response.data && response.data.length > 0) {
                    response.data.forEach(function(kategori) {
                        if (kategori.status == 1) { // Hanya kategori yang aktif
                            options += '<option value="' + kategori.id + '">' + kategori.nama_kategori + '</option>';
                        }
                    });
                }
                $('#kategori_id, #edit_kategori_id').html(options);
            },
            error: function(xhr) {
                console.error('Error loading kategori:', xhr);
                // Fallback jika gagal load kategori
                $('#kategori_id, #edit_kategori_id').html('<option value="">Gagal memuat kategori</option>');
            }
        });
    }

    // Load kategori saat halaman dimuat
    loadKategori();

    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('indeks-jasa-tidak-langsung.index') }}',
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {data: 'nama_indeks', name: 'nama_indeks'},
            {data: 'nilai', name: 'nilai'},
            {data: 'kategori', name: 'kategori'},
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
                $('#edit_nama_indeks').val(data.nama_indeks);
                $('#edit_nilai').val(data.nilai);
                $('#edit_kategori_id').val(data.kategori_indeks_jasa_tidak_langsung_id);
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

    // Handle Delete Button Click


    // Reset form when modal is closed
    $('#createModal').on('hidden.bs.modal', function () {
        $('#createForm')[0].reset();
        $('#kategori_id').val('');
    });

    $('#editModal').on('hidden.bs.modal', function () {
        $('#editForm')[0].reset();
        $('#edit_kategori_id').val('');
    });

    // Reload kategori when create modal is shown
    $('#createModal').on('show.bs.modal', function () {
        loadKategori();
    });

    // Reload kategori when edit modal is shown
    $('#editModal').on('show.bs.modal', function () {
        loadKategori();
    });
});
</script>
@endpush 