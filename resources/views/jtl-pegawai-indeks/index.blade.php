@extends('root')
@section('title', 'Data Indeks Pegawai JTL')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Data Indeks Pegawai JTL',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Indeks Pegawai JTL'
    ])
    
    <div class="widget-content searchable-container list">
      <div class="card card-body">
        <div class="row">
          <div class="col-md-3 col-xl-2">
            <form class="position-relative">
              <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Cari NIK/Nama">
              <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </form>
          </div>
          <div class="col-md-3 col-xl-2">
            <select class="form-select" id="filter-unit-kerja">
              <option value="">Semua Unit Kerja</option>
              @foreach($unitKerja as $unit)
                <option value="{{ $unit }}">{{ $unit }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6 col-xl-8 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
            <a href="javascript:void(0)" class="btn btn-success d-flex align-items-center me-2" id="btn-export">
              <i class="ti ti-file-export text-white me-1 fs-5"></i> Export Excel
            </a>
            
            <a href="javascript:void(0)" class="btn btn-info d-flex align-items-center me-2" data-bs-toggle="modal" data-bs-target="#importModal">
              <i class="ti ti-file-import text-white me-1 fs-5"></i> Import Excel
            </a>
          
            <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
              <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Indeks Pegawai
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
                        <th>NIK</th>
                        <th>Nama Pegawai</th>
                        <th>Unit Kerja</th>
                        <th>Dasar</th>
                        <th>Kompetensi</th>
                        <th>Resiko</th>
                        <th>Emergensi</th>
                        <th>Posisi</th>
                        <th>Kinerja</th>
                        <th>Jumlah</th>
                        <th>Rekening</th>
                        <th>Pajak</th>
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
                <h5 class="modal-title">Tambah Indeks Pegawai JTL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('jtl-pegawai-indeks.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Pegawai</label>
                                <input type="text" class="form-control" name="nama_pegawai" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Unit Kerja</label>
                                <input type="text" class="form-control" name="unit_kerja" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dasar</label>
                                <input type="number" class="form-control" name="dasar" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kompetensi</label>
                                <input type="number" class="form-control" name="kompetensi" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Resiko</label>
                                <input type="number" class="form-control" name="resiko" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Emergensi</label>
                                <input type="number" class="form-control" name="emergensi" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Posisi</label>
                                <input type="number" class="form-control" name="posisi" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kinerja</label>
                                <input type="number" class="form-control" name="kinerja" required step="0.01" min="0" max="99999999.99" value="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rekening</label>
                                <input type="text" class="form-control" name="rekening" placeholder="Nomor rekening (opsional)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pajak</label>
                                <input type="number" class="form-control" name="pajak" step="0.01" min="0" max="99999999.99" placeholder="0.00">
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
                <h5 class="modal-title">Edit Indeks Pegawai JTL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" id="edit_nik" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Pegawai</label>
                                <input type="text" class="form-control" name="nama_pegawai" id="edit_nama_pegawai" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Unit Kerja</label>
                                <input type="text" class="form-control" name="unit_kerja" id="edit_unit_kerja" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Dasar</label>
                                <input type="number" class="form-control" name="dasar" id="edit_dasar" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kompetensi</label>
                                <input type="number" class="form-control" name="kompetensi" id="edit_kompetensi" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Resiko</label>
                                <input type="number" class="form-control" name="resiko" id="edit_resiko" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Emergensi</label>
                                <input type="number" class="form-control" name="emergensi" id="edit_emergensi" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Posisi</label>
                                <input type="number" class="form-control" name="posisi" id="edit_posisi" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kinerja</label>
                                <input type="number" class="form-control" name="kinerja" id="edit_kinerja" required step="0.01" min="0" max="99999999.99">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rekening</label>
                                <input type="text" class="form-control" name="rekening" id="edit_rekening" placeholder="Nomor rekening (opsional)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pajak</label>
                                <input type="number" class="form-control" name="pajak" id="edit_pajak" step="0.01" min="0" max="99999999.99" placeholder="0.00">
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
                <h5 class="modal-title">Import Data Indeks Pegawai JTL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="importForm" method="POST" action="{{ route('jtl-pegawai-indeks.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">File Excel</label>
                        <input type="file" class="form-control" name="file" accept=".xlsx,.xls" required>
                        <div class="form-text">Format file: .xlsx atau .xls</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan:</label>
                        <ul class="mb-0">
                            <li>Format file yang diizinkan: .xlsx atau .xls</li>
                            <li>Ukuran maksimal file: 2MB</li>
                            <li>NIK Pegawai harus sesuai dengan data di database</li>
                            <li>Jika NIK sudah ada, data akan diupdate</li>
                            <li>Total akan dihitung otomatis oleh sistem</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('jtl-pegawai-indeks.template') }}" class="btn btn-info btn-sm">
                            <i class="ti ti-download me-1"></i> Download Template
                        </a>
                    </div>
                    <!-- Progress Bar -->
                    <div id="import-progress" class="d-none">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                Memproses...
                            </div>
                        </div>
                        <div class="alert alert-info mb-0">
                            <div id="import-status">Sedang memproses file...</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            url: '{{ route('jtl-pegawai-indeks.index') }}',
            data: function (d) {
                d.unit_kerja = $('#filter-unit-kerja').val();
                d.search = $('#input-search').val();
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
                data: 'nik_pegawai',
                name: 'nik_pegawai'
            },
            {
                data: 'nama_pegawai',
                name: 'nama_pegawai'
            },
            {
                data: 'unit_kerja',
                name: 'unit_kerja',
                orderable: false,
                searchable: false
            },
            {
                data: 'dasar',
                name: 'dasar'
            },
            {
                data: 'kompetensi',
                name: 'kompetensi'
            },
            {
                data: 'resiko',
                name: 'resiko'
            },
            {
                data: 'emergensi',
                name: 'emergensi'
            },
            {
                data: 'posisi',
                name: 'posisi'
            },
            {
                data: 'kinerja',
                name: 'kinerja'
            },
            {
                data: 'jumlah',
                name: 'jumlah',
                className: 'text-center'
            },
            {
                data: 'rekening',
                name: 'rekening'
            },
            {
                data: 'pajak',
                name: 'pajak',
                className: 'text-center'
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

    // Handle search input
    $('#input-search').on('keyup', function () {
        datatable.ajax.reload();
    });

    // Handle unit kerja filter
    $('#filter-unit-kerja').on('change', function () {
        datatable.ajax.reload();
    });


    // Handle Edit Button Click
    $(document).on('click', '.btn-edit', function() {
        var url = $(this).data('url');
        
        $.get(url, function(data) {
            var data = data.data;
            var updateUrl = url.replace('/show/', '/update/').replace('jtl-pegawai-indeks.show', 'jtl-pegawai-indeks.update');
            $('#editForm').attr('action', updateUrl);
            $('#edit_dasar').val(data.dasar);
            $('#edit_kompetensi').val(data.kompetensi);
            $('#edit_resiko').val(data.resiko);
            $('#edit_emergensi').val(data.emergensi);
            $('#edit_posisi').val(data.posisi);
            $('#edit_kinerja').val(data.kinerja);
            $('#edit_rekening').val(data.rekening);
            $('#edit_pajak').val(data.pajak);
            $('#edit_unit_kerja').val(data.unit_kerja);
            $('#edit_nama_pegawai').val(data.nama_pegawai);
            $('#edit_nik').val(data.nik);
            $('#editModal').modal('show');
        });
        });

    // Handle Edit Form Submit
 

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
        
        var formData = new FormData(this);
        var $btn = $('#btn-import');
        var $progress = $('#import-progress');
        var $status = $('#import-status');
        
        // Show progress
        $progress.removeClass('d-none');
        $btn.prop('disabled', true);
        $status.text('Sedang memproses file...');
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $progress.addClass('d-none');
                $btn.prop('disabled', false);
                
                if (response.meta.status === 'success') {
                    $('#importModal').modal('hide');
                    datatable.ajax.reload();
                    
                    var message = response.meta.message;
                    if (response.data.errors && response.data.errors.length > 0) {
                        // Show detailed results with errors
                        var errorDetails = response.data.errors.slice(0, 5).join('\n');
                        if (response.data.errors.length > 5) {
                            errorDetails += '\n... dan ' + (response.data.errors.length - 5) + ' error lainnya';
                        }
                        
                        Swal.fire({
                            icon: 'warning',
                            title: 'Import Selesai dengan Peringatan',
                            html: `
                                <div class="text-start">
                                    <p><strong>Berhasil:</strong> ${response.data.success} data</p>
                                    <p><strong>Gagal:</strong> ${response.data.failed} data</p>
                                    <hr>
                                    <p><strong>Detail Error:</strong></p>
                                    <div style="max-height: 200px; overflow-y: auto; text-align: left; font-size: 12px; background: #f8f9fa; padding: 10px; border-radius: 4px;">
                                        ${errorDetails.replace(/\n/g, '<br>')}
                                    </div>
                                </div>
                            `,
                            width: 600
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Import Berhasil!',
                            text: `Berhasil mengimport ${response.data.success} data`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                }
            },
            error: function(xhr) {
                $progress.addClass('d-none');
                $btn.prop('disabled', false);
                
                var errorMessage = 'Terjadi kesalahan saat import';
                if (xhr.responseJSON && xhr.responseJSON.meta && xhr.responseJSON.meta.message) {
                    errorMessage = xhr.responseJSON.meta.message;
                }
                
                if (xhr.responseJSON && xhr.responseJSON.data) {
                    var errors = xhr.responseJSON.data;
                    var errorDetails = '';
                    
                    $.each(errors, function(key, value) {
                        if (Array.isArray(value)) {
                            errorDetails += value.join(', ') + '\n';
                        } else {
                            errorDetails += value + '\n';
                        }
                    });
                    
                    if (errorDetails) {
                        errorMessage += '\n\nDetail:\n' + errorDetails;
                    }
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Import Gagal!',
                    text: errorMessage,
                    width: 500
                });
            }
        });
    });

    // Reset import form when modal is closed
    $('#importModal').on('hidden.bs.modal', function () {
        $('#importForm')[0].reset();
        $('#import-progress').addClass('d-none');
        $('#btn-import').prop('disabled', false);
    });

    // Handle Export Button Click
    $('#btn-export').on('click', function() {
        var unitKerjaId = $('#filter-unit-kerja').val();
        var search = $('#input-search').val();
        
        // Build URL with current filters
        var exportUrl = '{{ route('jtl-pegawai-indeks.export') }}';
        var params = [];
        
        if (unitKerjaId) {
            params.push('unit_kerja=' + encodeURIComponent(unitKerjaId));
        }
        
        if (search) {
            params.push('search=' + encodeURIComponent(search));
        }
        
        if (params.length > 0) {
            exportUrl += '?' + params.join('&');
        }
        
        // Show loading indicator
        var $btn = $(this);
        var originalText = $btn.html();
        $btn.html('<i class="ti ti-loader-2 animate-spin me-1"></i> Mengunduh...');
        $btn.prop('disabled', true);
        
        // Create temporary link to trigger download
        var link = document.createElement('a');
        link.href = exportUrl;
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Reset button after a short delay
        setTimeout(function() {
            $btn.html(originalText);
            $btn.prop('disabled', false);
        }, 2000);
    });
});
</script>
@endpush 