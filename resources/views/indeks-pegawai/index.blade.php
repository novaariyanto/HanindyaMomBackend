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
                            <th>TMT CPNS</th>
                            <th>TMT di RS</th>
                            <th>Masa Kerja di RS</th>
                            <th>Indeks Masa Kerja</th>
                            <th>Jabatan</th>
                            <th>Ruang</th>
                            <th>Total</th>
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
                                <label class="form-label">TMT CPNS</label>
                                <input type="date" class="form-control" name="tmt_cpns" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">TMT di RS</label>
                                <input type="date" class="form-control" name="tmt_di_rs" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Masa Kerja di RS</label>
                                <input type="text" class="form-control" name="masa_kerja_di_rs" required maxlength="50" placeholder="Contoh: 5 Tahun 3 Bulan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Masa Kerja</label>
                                <input type="number" step="0.01" class="form-control" name="indeks_masa_kerja" required min="0" max="99.99">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kualifikasi Pendidikan</label>
                                <input type="text" class="form-control" name="kualifikasi_pendidikan" required maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Kualifikasi Pendidikan</label>
                                <input type="number" class="form-control" name="indeks_kualifikasi_pendidikan" required min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Resiko</label>
                                <input type="number" class="form-control" name="indeks_resiko" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Emergency</label>
                                <input type="number" class="form-control" name="indeks_emergency" required min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" class="form-control" name="jabatan" required maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Posisi Unit Kerja</label>
                                <input type="number" class="form-control" name="indeks_posisi_unit_kerja" required min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ruang</label>
                                <input type="text" class="form-control" name="ruang" required maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Jabatan Tambahan</label>
                                <input type="number" class="form-control" name="indeks_jabatan_tambahan" required min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Performa</label>
                                <input type="number" class="form-control" name="indeks_performa" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Total</label>
                                <input type="number" step="0.01" class="form-control" name="total" required min="0" max="999.99">
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
                                <label class="form-label">TMT CPNS</label>
                                <input type="date" class="form-control" name="tmt_cpns" id="edit_tmt_cpns" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">TMT di RS</label>
                                <input type="date" class="form-control" name="tmt_di_rs" id="edit_tmt_di_rs" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Masa Kerja di RS</label>
                                <input type="text" class="form-control" name="masa_kerja_di_rs" id="edit_masa_kerja_di_rs" required maxlength="50">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Masa Kerja</label>
                                <input type="number" step="0.01" class="form-control" name="indeks_masa_kerja" id="edit_indeks_masa_kerja" required min="0" max="99.99">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kualifikasi Pendidikan</label>
                                <input type="text" class="form-control" name="kualifikasi_pendidikan" id="edit_kualifikasi_pendidikan" required maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Kualifikasi Pendidikan</label>
                                <input type="number" class="form-control" name="indeks_kualifikasi_pendidikan" id="edit_indeks_kualifikasi_pendidikan" required min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Resiko</label>
                                <input type="number" class="form-control" name="indeks_resiko" id="edit_indeks_resiko" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Emergency</label>
                                <input type="number" class="form-control" name="indeks_emergency" id="edit_indeks_emergency" required min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" class="form-control" name="jabatan" id="edit_jabatan" required maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Posisi Unit Kerja</label>
                                <input type="number" class="form-control" name="indeks_posisi_unit_kerja" id="edit_indeks_posisi_unit_kerja" required min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Ruang</label>
                                <input type="text" class="form-control" name="ruang" id="edit_ruang" required maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Jabatan Tambahan</label>
                                <input type="number" class="form-control" name="indeks_jabatan_tambahan" id="edit_indeks_jabatan_tambahan" required min="0">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Indeks Performa</label>
                                <input type="number" class="form-control" name="indeks_performa" id="edit_indeks_performa" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Total</label>
                                <input type="number" step="0.01" class="form-control" name="total" id="edit_total" required min="0" max="999.99">
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
            {data: 'tmt_cpns', name: 'tmt_cpns'},
            {data: 'tmt_di_rs', name: 'tmt_di_rs'},
            {data: 'masa_kerja_di_rs', name: 'masa_kerja_di_rs'},
            {data: 'indeks_masa_kerja', name: 'indeks_masa_kerja'},
            {data: 'jabatan', name: 'jabatan'},
            {data: 'ruang', name: 'ruang'},
            {data: 'total', name: 'total'},
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
                var response = JSON.parse(xhr.responseText);
                if (xhr.status === 422) {
                    var errors = response.data;
                    var errorMessage = '';
                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + '<br>';
                    });
                    toastr.error(errorMessage);
                } else {
                    toastr.error(response.meta.message);
                }
            }
        });
    });

    // Handle edit data
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        
        $.get(url, function(response) {
            if (response.meta.code === 200) {
                var data = response.data;
                $('#edit_nama').val(data.nama);
                $('#edit_nip').val(data.nip);
                $('#edit_tmt_cpns').val(data.tmt_cpns);
                $('#edit_tmt_di_rs').val(data.tmt_di_rs);
                $('#edit_masa_kerja_di_rs').val(data.masa_kerja_di_rs);
                $('#edit_indeks_masa_kerja').val(data.indeks_masa_kerja);
                $('#edit_kualifikasi_pendidikan').val(data.kualifikasi_pendidikan);
                $('#edit_indeks_kualifikasi_pendidikan').val(data.indeks_kualifikasi_pendidikan);
                $('#edit_indeks_resiko').val(data.indeks_resiko);
                $('#edit_indeks_emergency').val(data.indeks_emergency);
                $('#edit_jabatan').val(data.jabatan);
                $('#edit_indeks_posisi_unit_kerja').val(data.indeks_posisi_unit_kerja);
                $('#edit_ruang').val(data.ruang);
                $('#edit_indeks_jabatan_tambahan').val(data.indeks_jabatan_tambahan);
                $('#edit_indeks_performa').val(data.indeks_performa);
                $('#edit_total').val(data.total);
                
                $('#editForm').attr('action', '{{ route('indeks-pegawai.update', '') }}/' + data.id);
                $('#editModal').modal('show');
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
                var response = JSON.parse(xhr.responseText);
                if (xhr.status === 422) {
                    var errors = response.data;
                    var errorMessage = '';
                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + '<br>';
                    });
                    toastr.error(errorMessage);
                } else {
                    toastr.error(response.meta.message);
                }
            }
        });
    });

    // Handle delete data
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.meta.code === 200) {
                            datatable.ajax.reload();
                            toastr.success(response.meta.message);
                        } else {
                            toastr.error(response.meta.message);
                        }
                    },
                    error: function(xhr) {
                        var response = JSON.parse(xhr.responseText);
                        toastr.error(response.meta.message);
                    }
                });
            }
        });
    });
});
</script>
@endpush 