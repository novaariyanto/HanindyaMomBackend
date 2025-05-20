@extends('root')
@section('title', 'Data Proporsi Fairness')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Data Proporsi Fairness',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Proporsi Fairness'
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
            <div class="action-btn show-btn">
              <a href="javascript:void(0)" class="delete-multiple bg-danger-subtle btn me-2 text-danger d-flex align-items-center">
                <i class="ti ti-trash me-1 fs-5"></i> Delete All Row
              </a>
            </div>
            <button type="button" class="btn btn-success d-flex align-items-center me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="ti ti-file-import text-white me-1 fs-5"></i> Import Excel
            </button>
            <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
              <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Data
            </a>
          </div>
        </div>
      </div>

      <!-- Tambahkan Card Filter -->
      <div class="card card-body mb-3">
        <div class="row">
          <div class="col-md-6 col-xl-3 mb-3">
            <label class="form-label">Filter Groups</label>
            <select class="form-select" id="filter-groups">
              <option value="">Semua Groups</option>
              <option value="RJTL">RJTL</option>
              <option value="RITL">RITL</option>
            </select>
          </div>
          <div class="col-md-6 col-xl-3 mb-3">
            <label class="form-label">Filter Grade</label>
            <select class="form-select" id="filter-grade">
              <option value="">Semua Grade</option>
              @foreach($grades as $grade)
                <option value="{{ $grade->grade }}">{{ $grade->grade }} <=({{ $grade->persentase }}%)</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6 col-xl-3 mb-3">
            <label class="form-label">Filter Sumber</label>
            <select class="form-select" id="filter-sumber">
              <option value="">Semua Sumber</option>
              @foreach($sumbers as $sumber)
                <option value="{{ $sumber->name }}">{{ $sumber->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-12 col-xl-3 mb-3 d-flex align-items-end">
            <button type="button" class="btn btn-secondary me-2" id="btn-reset-filter">
              <i class="ti ti-refresh me-1"></i> Reset Filter
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
                        <th>Groups</th>
                        <th>Jenis</th>
                        <th>Grade</th>
                        <th>PPA</th>
                        <th>Value</th>
                        <th>Sumber</th>
                        <th>Flag</th>
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
                <h5 class="modal-title">Tambah Proporsi Fairness</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('proporsi-fairness.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Groups</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="groups" id="groups_rjtl" value="RJTL" required>
                                <label class="form-check-label" for="groups_rjtl">
                                    RJTL
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="groups" id="groups_ritl" value="RITL" required>
                                <label class="form-check-label" for="groups_ritl">
                                    RITL
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis" id="jenis_pisau" value="PISAU" required>
                                <label class="form-check-label" for="jenis_pisau">
                                    Pisau
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis" id="jenis_nonpisau" value="NONPISAU" required>
                                <label class="form-check-label" for="jenis_nonpisau">
                                    NONPISAU
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Grade</label>
                        <select class="form-select" name="grade" required>
                            <option value="">Pilih Grade</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->grade }}">{{ $grade->grade }} ({{ $grade->persentase_top }}%)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">PPA</label>
                        <input type="text" class="form-control" name="ppa" required maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Value</label>
                        <input type="number" class="form-control" name="value" required step="0.01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sumber</label>
                        <select class="form-select" name="sumber" required>
                            <option value="">Pilih Sumber</option>
                            @foreach($sumbers as $sumber)
                                <option value="{{ $sumber->name }}">{{ $sumber->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Flag</label>
                        <input type="text" class="form-control" name="flag" required maxlength="50">
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
                <h5 class="modal-title">Edit Proporsi Fairness</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Groups</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="groups" id="edit_groups_rjtl" value="RJTL" required>
                                <label class="form-check-label" for="edit_groups_rjtl">RJTL</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="groups" id="edit_groups_ritl" value="RITL" required>
                                <label class="form-check-label" for="edit_groups_ritl">RITL</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis" id="edit_jenis_pisau" value="PISAU" required>
                                <label class="form-check-label" for="edit_jenis_pisau">Pisau</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis" id="edit_jenis_nonpisau" value="NONPISAU" required>
                                <label class="form-check-label" for="edit_jenis_nonpisau">NONPISAU</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Grade</label>
                        <select class="form-select" name="grade" id="edit_grade" required>
                            <option value="">Pilih Grade</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->grade }}">{{ $grade->grade }} ({{ $grade->persentase_top }}%)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">PPA</label>
                        <input type="text" class="form-control" name="ppa" id="edit_ppa" required maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Value</label>
                        <input type="number" class="form-control" name="value" id="edit_value" required step="0.01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sumber</label>
                        <select class="form-select" name="sumber" id="edit_sumber" required>
                            <option value="">Pilih Sumber</option>
                            @foreach($sumbers as $sumber)
                                <option value="{{ $sumber->name }}">{{ $sumber->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Flag</label>
                        <input type="text" class="form-control" name="flag" id="edit_flag" required maxlength="50">
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

<!-- Tambahkan Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Proporsi Fairness</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="importForm" method="POST" action="{{ route('proporsi-fairness.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File Excel</label>
                        <input type="file" class="form-control" name="file" accept=".xlsx,.xls" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan:</label>
                        <ul class="mb-0">
                            <li>Format file yang diizinkan: .xlsx atau .xls</li>
                            <li>Ukuran maksimal file: 2MB</li>
                            <li>Pastikan format data sesuai dengan template</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('proporsi-fairness.template') }}" class="btn btn-info btn-sm">
                            <i class="ti ti-download me-1"></i> Download Template
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Import</button>
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
            url: '{{ route('proporsi-fairness.index') }}',
            data: function(d) {
                d.grade = $('#filter-grade').val();
                d.sumber = $('#filter-sumber').val();
                d.groups = $('#filter-groups').val();
            }
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'groups',
                name: 'groups'
            },
            {
                data: 'jenis',
                name: 'jenis'
            },
            {
                data: 'grade',
                name: 'grade'
            },
            {
                data: 'ppa',
                name: 'ppa'
            },
            {
                data: 'value',
                name: 'value',
                render: function(data) {
                    return parseFloat(data).toFixed(2);
                }
            },
            {
                data: 'sumber',
                name: 'sumber'
            },
            {
                data: 'flag',
                name: 'flag'
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

    // Handle filter change
    $('#filter-grade, #filter-sumber, #filter-groups').change(function() {
        datatable.ajax.reload();
    });

    // Handle reset filter
    $('#btn-reset-filter').click(function() {
        $('#filter-grade').val('');
        $('#filter-sumber').val('');
        $('#filter-groups').val('');
        datatable.ajax.reload();
    });

    // Search functionality
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
    $(document).on('click', '.btn-edit', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        
        // Reset form sebelum mengisi data baru
        $('#editForm')[0].reset();
        
        // Ambil data untuk edit
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.meta.status === 'success') {
                    var data = response.data;
                    
                    // Set action URL
                    $('#editForm').attr('action', url);
                    
                    // Set radio buttons
                    $(`input[name="groups"][value="${data.groups}"]`).prop('checked', true);
                    $(`input[name="jenis"][value="${data.jenis}"]`).prop('checked', true);
                    
                    // Set select options
                    $('#edit_grade').val(data.grade);
                    $('#edit_sumber').val(data.sumber);
                    
                    // Set input fields
                    $('#edit_ppa').val(data.ppa);
                    $('#edit_value').val(data.value);
                    $('#edit_flag').val(data.flag);
                    
                    // Tampilkan modal
                    $('#editModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.meta.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengambil data'
                });
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
            type: 'POST',
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
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.meta.message
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

    // Handle Import Form Submit
    $('#importForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(this);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                Swal.fire({
                    title: 'Mohon Tunggu',
                    text: 'Sedang memproses data...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                if (response.meta.status === 'success') {
                    $('#importModal').modal('hide');
                    form[0].reset();
                    datatable.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.meta.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.meta.message
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
});
</script>
@endpush 