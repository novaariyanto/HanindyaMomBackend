@extends('root')
@section('title', 'List Pembagian Klaim')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'List Pembagian Klaim',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('detail-source.index'), 'label' => 'Detail Source'],
            ['url' => route('detail-source.show', $detailSource->id), 'label' => 'Detail Source #' . $detailSource->id],
        ],
        'current' => 'Pembagian Klaim'
    ])
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Detail Source</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="150">No. SEP</td>
                                    <td width="20">:</td>
                                    <td>{{ $detailSource->no_sep }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Verifikasi</td>
                                    <td>:</td>
                                    <td>{{ $detailSource->tgl_verifikasi->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis</td>
                                    <td>:</td>
                                    <td>{{ $detailSource->jenis }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="150">Biaya Riil RS</td>
                                    <td width="20">:</td>
                                    <td>Rp {{ number_format($detailSource->biaya_riil_rs, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Biaya Diajukan</td>
                                    <td>:</td>
                                    <td>Rp {{ number_format($detailSource->biaya_diajukan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Biaya Disetujui</td>
                                    <td>:</td>
                                    <td>Rp {{ number_format($detailSource->biaya_disetujui, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Data Pembagian Klaim</h4>
                    <div>
                        <a href="javascript:void(0)" class="btn btn-info btn-sm me-2" id="btn-import">
                            <i class="ti ti-file-import text-white"></i> Import Excel
                        </a>
                        <a href="{{ route('pembagian-klaim.template') }}" class="btn btn-success btn-sm me-2">
                            <i class="ti ti-file-download text-white"></i> Download Template
                        </a>
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="ti ti-plus text-white"></i> Tambah Data
                        </a>
                    </div>
                </div>
                <div class="card-body">
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
            url: '{{ route('pembagian-klaim.data-by-detail-source', $detailSource->id) }}',
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
            { 
                data: 'value', 
                name: 'value',
                render: function(data) {
                    return parseFloat(data).toFixed(4);
                }
            },
            { data: 'sumber', name: 'sumber' },
            { data: 'flag', name: 'flag' },
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
    $('#importModal').on('hidden.bs.modal', function () {
        $('#importForm')[0].reset();
        $('#import-progress').addClass('d-none');
    });
});
</script>
@endpush 