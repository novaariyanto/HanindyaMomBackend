@extends('root')
@section('title', 'Data Pembagian Klaim')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Data Pembagian Klaim',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Pembagian Klaim'
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
            <a href="javascript:void(0)" class="btn btn-info d-flex align-items-center me-2" id="btn-import">
              <i class="ti ti-file-import text-white me-1 fs-5"></i> Import Excel
            </a>
            <a href="{{ route('pembagian-klaim.template') }}" class="btn btn-success d-flex align-items-center me-2">
              <i class="ti ti-file-download text-white me-1 fs-5"></i> Download Template
            </a>
            <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
              <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Data
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
                        <th>Groups</th>
                        <th>Jenis</th>
                        <th>Grade</th>
                        <th>PPA</th>
                        <th>Value</th>
                        <th>Sumber</th>
                        <th>Flag</th>
                        <th>SEP</th>
                        <th>Cluster</th>
                        <th>Tanggal</th>
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
                <h5 class="modal-title">Tambah Pembagian Klaim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('pembagian-klaim.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Groups</label>
                                <select class="form-select" name="groups" required>
                                    <option value="RITL">RITL</option>
                                    <option value="RJTL">RJTL</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis</label>
                                <input type="text" class="form-control" name="jenis" required maxlength="20">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Grade</label>
                                <input type="text" class="form-control" name="grade" required maxlength="20">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">PPA</label>
                                <input type="text" class="form-control" name="ppa" required maxlength="50">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Value</label>
                                <input type="number" class="form-control" name="value" required step="0.0001" min="0" max="9999999.9999">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sumber</label>
                                <input type="text" class="form-control" name="sumber" required maxlength="50">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Flag</label>
                                <input type="text" class="form-control" name="flag" required maxlength="20">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">SEP</label>
                                <input type="text" class="form-control" name="sep" required maxlength="50">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cluster</label>
                                <select class="form-select" name="cluster" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Index Daftar</label>
                                <input type="number" class="form-control" name="idxdaftar" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. RM</label>
                                <input type="number" class="form-control" name="nomr" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" required>
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
                <h5 class="modal-title">Edit Pembagian Klaim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Groups</label>
                                <select class="form-select" name="groups" id="edit_groups" required>
                                    <option value="RITL">RITL</option>
                                    <option value="RJTL">RJTL</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis</label>
                                <input type="text" class="form-control" name="jenis" id="edit_jenis" required maxlength="20">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Grade</label>
                                <input type="text" class="form-control" name="grade" id="edit_grade" required maxlength="20">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">PPA</label>
                                <input type="text" class="form-control" name="ppa" id="edit_ppa" required maxlength="50">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Value</label>
                                <input type="number" class="form-control" name="value" id="edit_value" required step="0.0001" min="0" max="9999999.9999">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sumber</label>
                                <input type="text" class="form-control" name="sumber" id="edit_sumber" required maxlength="50">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Flag</label>
                                <input type="text" class="form-control" name="flag" id="edit_flag" required maxlength="20">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">SEP</label>
                                <input type="text" class="form-control" name="sep" id="edit_sep" required maxlength="50">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cluster</label>
                                <select class="form-select" name="cluster" id="edit_cluster" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Index Daftar</label>
                                <input type="number" class="form-control" name="idxdaftar" id="edit_idxdaftar" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. RM</label>
                                <input type="number" class="form-control" name="nomr" id="edit_nomr" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="edit_tanggal" required>
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

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="importForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File Excel</label>
                        <input type="file" class="form-control" name="file" accept=".xlsx,.xls" required>
                        <small class="text-muted">Format file: XLSX, XLS (max. 2MB)</small>
                    </div>
                    <div id="import-progress" class="d-none">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="text-center text-muted" id="import-status"></div>
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
            url: '{{ route('pembagian-klaim.index') }}',
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            { data: 'groups', name: 'groups' },
            { data: 'jenis', name: 'jenis' },
            { data: 'grade', name: 'grade' },
            { data: 'ppa', name: 'ppa' },
            { data: 'value', name: 'value' },
            { data: 'sumber', name: 'sumber' },
            { data: 'flag', name: 'flag' },
            { data: 'sep', name: 'sep' },
            { data: 'cluster', name: 'cluster' },
            { data: 'tanggal', name: 'tanggal' },
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
        
        $.get(url, function(data) {
            var data = data.data;
            $('#editForm').attr('action', url);
            $('#edit_groups').val(data.groups);
            $('#edit_jenis').val(data.jenis);
            $('#edit_grade').val(data.grade);
            $('#edit_ppa').val(data.ppa);
            $('#edit_value').val(data.value);
            $('#edit_sumber').val(data.sumber);
            $('#edit_flag').val(data.flag);
            $('#edit_sep').val(data.sep);
            $('#edit_cluster').val(data.cluster);
            $('#edit_idxdaftar').val(data.idxdaftar);
            $('#edit_nomr').val(data.nomr);
            $('#edit_tanggal').val(data.tanggal);
            $('#editModal').modal('show');
        });
    });

    // Handle Edit Form Submit

    // Handle Delete Button Click


    // Handle Import Button Click
    $('#btn-import').click(function() {
        $('#importModal').modal('show');
    });

    // Handle Import Form Submit
    $('#importForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);
        
        // Show progress bar
        $('#import-progress').removeClass('d-none');
        $('.progress-bar').css('width', '0%');
        $('#import-status').text('Mempersiapkan import...');
        
        // First request to prepare the import
        $.ajax({
            url: '{{ route('pembagian-klaim.import') }}?action=prepare',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    var totalChunks = response.data.total_chunks;
                    var currentChunk = 1;
                    var progress = 0;
                    
                    // Process each chunk
                    function processChunk() {
                        if (currentChunk <= totalChunks) {
                            progress = Math.round((currentChunk / totalChunks) * 100);
                            $('.progress-bar').css('width', progress + '%');
                            $('#import-status').text('Memproses data ' + progress + '%');
                            
                            $.ajax({
                                url: '{{ route('pembagian-klaim.import') }}?action=process&chunk=' + currentChunk,
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    if (response.status === 'success') {
                                        currentChunk++;
                                        processChunk();
                                        
                                        if (currentChunk > totalChunks) {
                                            $('#importModal').modal('hide');
                                            form[0].reset();
                                            $('#import-progress').addClass('d-none');
                                            datatable.ajax.reload();
                                            
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Berhasil',
                                                text: 'Import data selesai',
                                                timer: 1500,
                                                showConfirmButton: false
                                            });
                                        }
                                    }
                                },
                                error: function(xhr) {
                                    $('#import-progress').addClass('d-none');
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: 'Gagal memproses data'
                                    });
                                }
                            });
                        }
                    }
                    
                    processChunk();
                }
            },
            error: function(xhr) {
                $('#import-progress').addClass('d-none');
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

    $('#importModal').on('hidden.bs.modal', function () {
        $('#importForm')[0].reset();
        $('#import-progress').addClass('d-none');
    });
});
</script>
@endpush 