@extends('root')
@section('title', 'Data JTL')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Data JTL',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Data JTL'
    ])

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="widget-content searchable-container list">
        <!-- Search & Add Button Section -->
        <div class="card card-body mb-3">
            <div class="row">
                <div class="col-md-4 col-xl-3">
                    <form class="position-relative">
                        <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Cari Data JTL...">
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                </div>
                <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                    <div class="d-flex gap-2">
                        <a href="{{ route('jtldata.export', $id_remunerasi_source) }}" class="btn btn-success d-flex align-items-center" id="btnExport">
                            <i class="ti ti-download text-white me-1 fs-5"></i> Export Excel
                        </a>
                        <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="ti ti-plus text-white me-1 fs-5"></i> Tambah Data JTL
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Section -->
        <div class="card card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="datatable">
                    <thead class="table">
                        <tr>
                            <th width="50">No</th>
                            <th>Remunerasi Source</th>
                            <th>Nama Pembagian</th>
                            <th width="130" class="text-center">Jumlah JTL</th>
                            <th width="130" class="text-center">Jumlah Indeks</th>
                            <th width="130" class="text-center">Nilai Indeks</th>
                            <th width="130" class="text-center">di bagi All Pegawai</th>
                            <th width="100" class="text-center">Aksi</th>
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

<!-- Modal Tambah Data -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createModalLabel">
                    <i class="ti ti-plus me-2"></i>Tambah Data JTL
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createForm" method="POST" action="{{ route('jtldata.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Remunerasi Source <span class="text-danger">*</span></label>
                                <select class="form-select" name="id_remunerasi_source" id="create_id_remunerasi_source" required>
                                    <option value="">-- Pilih Remunerasi Source --</option>
                                    @if(isset($remunerasiSources))
                                        @foreach($remunerasiSources as $source)
                                            <option value="{{ $source->id }}">{{ $source->nama_source }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Pembagian <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_pembagian" id="create_nama_pembagian" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">di bagi All Pegawai <span class="text-danger">*</span></label>
                                <select class="form-select" name="allpegawai" id="create_allpegawai" required>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nilai <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="jumlah_jtl" id="jumlah_jtl" required step="0.01" min="0" placeholder="0.00" >
                                    <span class="input-group-text">dibagi</span>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                   
                        <div class="col-md-4" id="create_jumlah_indeks_wrapper">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jumlah Indeks <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="jumlah_indeks" id="create_jumlah_indeks" required step="0.01" min="0" placeholder="0.00" readonly>
                                    <span class="input-group-text">Indeks</span>
                                </div>
                                <small class="text-info">Otomatis dihitung dari total jumlah Pegawai Indeks Source</small>
                                   
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4" id="create_nilai_indeks_wrapper">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nilai Indeks <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="nilai_indeks" id="create_nilai_indeks" required step="0.01" min="0" placeholder="0.00" readonly>
                                </div>
                                <small class="text-info">Otomatis dihitung dari Jumlah JTL ÷ Jumlah Indeks</small>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                     
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="ti ti-edit me-2"></i>Edit Data JTL
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Remunerasi Source <span class="text-danger">*</span></label>
                                <select class="form-select" name="id_remunerasi_source" id="edit_id_remunerasi_source" required>
                                    <option value="">-- Pilih Remunerasi Source --</option>
                                    @if(isset($remunerasiSources))
                                        @foreach($remunerasiSources as $source)
                                            <option value="{{ $source->id }}">{{ $source->nama_source }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">  
                                <label class="form-label fw-bold">Nama Pembagian <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_pembagian" id="edit_nama_pembagian" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">di bagi All Pegawai <span class="text-danger">*</span></label>
                                <select class="form-select" name="allpegawai" id="edit_allpegawai" required>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jumlah JTL <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="jumlah_jtl" id="edit_jumlah_jtl" required step="0.01" min="0" placeholder="0.00">
                                    <span class="input-group-text">JTL</span>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4" id="edit_jumlah_indeks_wrapper">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jumlah Indeks <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="jumlah_indeks" id="edit_jumlah_indeks" required step="0.01" min="0" placeholder="0.00">
                                    <span class="input-group-text">Indeks</span>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4" id="edit_nilai_indeks_wrapper">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nilai Indeks <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" name="nilai_indeks" id="edit_nilai_indeks" required step="0.01" min="0" placeholder="0.00">
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ti ti-check me-1"></i>Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    var datatable = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        responsive: true,
        language: {
            processing: "Memproses...",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            search: "Cari:",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        },
        ajax: {
            url: '{{ route('jtldata.index', $id_remunerasi_source) }}',
            error: function(xhr, error, thrown) {
                console.error('DataTables Error:', error);
                console.error('Response:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Gagal memuat data. Silakan refresh halaman.'
                });
            }
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
                {
                    data: 'remunerasi_source',
                    name: 'remunerasi_source',
                    render: function(data, type, row) {
                        return data ? data : '<span class="text-muted">-</span>';
                    }
                },
            {
                data: 'nama_pembagian',
                name: 'nama_pembagian',
                render: function(data, type, row) {
                    return data ? data : '<span class="text-muted">-</span>';
                }
            },
            {
                data: 'jumlah_jtl_formatted',
                name: 'jumlah_jtl',
                className: 'text-end',
                render: function(data, type, row) {
                    return '<span class="badge bg-light-info text-info">' + data + '</span>';
                }
            },
            {
                data: 'jumlah_indeks_formatted',
                name: 'jumlah_indeks',
                className: 'text-end',
                render: function(data, type, row) {
                    return '<span class="badge bg-light-success text-success">' + data + '</span>';
                }
            },
            {
                data: 'nilai_indeks_formatted',
                name: 'nilai_indeks',
                className: 'text-end',
                render: function(data, type, row) {
                    return '<span class="badge bg-light-primary text-primary">Rp ' + data + '</span>';
                }
            },
            {
                data: 'allpegawai_formatted',
                name: 'allpegawai',
                className: 'text-end',
                render: function(data, type, row) {
                    return '<span class="badge bg-light-primary text-primary">' + data + '</span>';
                }
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ],
        order: [[0, 'desc']],
        pageLength: 25,
        dom: 'rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
    });

    // Custom search
    $('#input-search').on('keyup', function() {
        datatable.search(this.value).draw();
    });

    // Handle Remunerasi Source Change - Auto Fill Jumlah JTL
    $('#create_id_remunerasi_source').on('change', function() {
        var remunerasiSourceId = $(this).val();
    
        
        if (remunerasiSourceId) {
            // Show loading indicator
            $('#create_jumlah_indeks').val('Loading...');
            
            $.get('{{ route('jtldata.getJumlahJtl', $id_remunerasi_source) }}', {
                remunerasi_source_id: remunerasiSourceId
            })
            .done(function(response) {
                if (response.meta.code === 200) {
                    var jumlahJtl = parseFloat(response.data.jumlah_jtl) || 0;
                    $('#create_jumlah_indeks').val(jumlahJtl.toFixed(2));
                    
                    // Trigger calculation of nilai indeks
                    calculateNilaiIndeks();
                } else {
                    $('#create_jumlah_indeks').val('0.00');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: response.meta.message || 'Gagal mengambil jumlah JTL'
                    });
                }
            })
            .fail(function() {
                $('#create_jumlah_indeks').val('0.00');
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Gagal mengambil data jumlah JTL'
                });
            });
        } else {
            $('#create_jumlah_indeks').val('0.00');
            $('#create_nilai_indeks').val('0.00');
        }
    });

    // Handle Jumlah Indeks Change - Auto Calculate Nilai Indeks
    $('#jumlah_jtl').on('input', function() {
        calculateNilaiIndeks();
    });

    // Handle Edit Jumlah JTL Change - Auto Calculate Nilai Indeks
    $('#edit_jumlah_jtl').on('input', function() {
        calculateEditNilaiIndeks();
    });

    $('#edit_jumlah_indeks').on('input', function() {
        calculateEditNilaiIndeks();
    });

    // Handle All Pegawai Change - Show/Hide Jumlah Indeks and Nilai Indeks
    $('#create_allpegawai').on('change', function() {
        var allPegawai = $(this).val();
        toggleIndeksFields('create', allPegawai);
    });

    $('#edit_allpegawai').on('change', function() {
        var allPegawai = $(this).val();
        toggleIndeksFields('edit', allPegawai);
    });

    // Function to calculate nilai indeks
    function calculateNilaiIndeks() {
        var allPegawai = $('#create_allpegawai').val();
        
        // Only calculate if allpegawai = 1
        if (allPegawai == '1') {
            var jumlahJtl = parseFloat($('#jumlah_jtl').val()) || 0;
            var jumlahIndeks = parseFloat($('#create_jumlah_indeks').val()) || 0;
            
            if (jumlahIndeks > 0 && jumlahJtl > 0) {
                var nilaiIndeks = jumlahJtl / jumlahIndeks;
                $('#create_nilai_indeks').val(nilaiIndeks.toFixed(2));
            } else {
                $('#create_nilai_indeks').val('0.00');
            }
        } else {
            $('#create_nilai_indeks').val('0.00');
        }
    }

    // Function to calculate nilai indeks for edit form
    function calculateEditNilaiIndeks() {
        var allPegawai = $('#edit_allpegawai').val();
        
        // Only calculate if allpegawai = 1
        if (allPegawai == '1') {
            var jumlahJtl = parseFloat($('#edit_jumlah_jtl').val()) || 0;
            var jumlahIndeks = parseFloat($('#edit_jumlah_indeks').val()) || 0;
            
            if (jumlahIndeks > 0 && jumlahJtl > 0) {
                var nilaiIndeks = jumlahJtl / jumlahIndeks;
                $('#edit_nilai_indeks').val(nilaiIndeks.toFixed(2));
            } else {
                $('#edit_nilai_indeks').val('0.00');
            }
        } else {
            $('#edit_nilai_indeks').val('0.00');
        }
    }

    // Function to toggle indeks fields visibility
    function toggleIndeksFields(prefix, allPegawai) {
        var jumlahIndeksWrapper = $('#' + prefix + '_jumlah_indeks_wrapper');
        var nilaiIndeksWrapper = $('#' + prefix + '_nilai_indeks_wrapper');
        var jumlahIndeksInput = $('#' + prefix + '_jumlah_indeks');
        var nilaiIndeksInput = $('#' + prefix + '_nilai_indeks');
        
        if (allPegawai == '0') {
            // Hide fields and set values to 0
            jumlahIndeksWrapper.hide();
            nilaiIndeksWrapper.hide();
            jumlahIndeksInput.val('0.00');
            nilaiIndeksInput.val('0.00');
            
            // Remove required attribute
            jumlahIndeksInput.removeAttr('required');
            nilaiIndeksInput.removeAttr('required');
        } else {
            // Show fields
            jumlahIndeksWrapper.show();
            nilaiIndeksWrapper.show();
            
            // Add required attribute back
            jumlahIndeksInput.attr('required', 'required');
            nilaiIndeksInput.attr('required', 'required');
            
            // If this is create form and remunerasi source is selected, recalculate
            if (prefix === 'create') {
                var remunerasiSourceId = $('#create_id_remunerasi_source').val();
                if (remunerasiSourceId) {
                    $('#create_id_remunerasi_source').trigger('change');
                }
            } else if (prefix === 'edit') {
                // For edit form, recalculate with existing values
                calculateEditNilaiIndeks();
            }
        }
    }

    // Handle Edit Button Click
    $(document).on('click', '.btn-edit', function() {
        var url = $(this).data('url');
        
        // Show loading
        Swal.fire({
            title: 'Memuat data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.get(url, function(response) {
            Swal.close();
            
            if (response.meta.code === 200) {
                var data = response.data;
                $('#editForm').attr('action', url);
                $('#edit_id_remunerasi_source').val(data.id_remunerasi_source);
                $('#edit_nama_pembagian').val(data.nama_pembagian);
                $('#edit_jumlah_jtl').val(data.jumlah_jtl);
                $('#edit_jumlah_indeks').val(data.jumlah_indeks);
                $('#edit_nilai_indeks').val(data.nilai_indeks);
                $('#edit_allpegawai').val(data.allpegawai);
                
                // Toggle fields based on allpegawai value
                toggleIndeksFields('edit', data.allpegawai);
                
                $('#editModal').modal('show');
            }
        }).fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Gagal memuat data'
            });
        });
    });

   

 

    // Initialize create modal when shown
    $('#createModal').on('shown.bs.modal', function() {
        // Set initial state based on default allpegawai value
        var allPegawai = $('#create_allpegawai').val();
        toggleIndeksFields('create', allPegawai);
    });

    // Reset forms when modals are closed
    $('#createModal').on('hidden.bs.modal', function() {
        $('#createForm')[0].reset();
        $('#create_jumlah_indeks').val('0.00');
        $('#create_nilai_indeks').val('0.00');
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Reset visibility to default state
        $('#create_jumlah_indeks_wrapper').show();
        $('#create_nilai_indeks_wrapper').show();
        $('#create_jumlah_indeks').attr('required', 'required');
        $('#create_nilai_indeks').attr('required', 'required');
    });

    $('#editModal').on('hidden.bs.modal', function() {
        $('#editForm')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Reset visibility to default state
        $('#edit_jumlah_indeks_wrapper').show();
        $('#edit_nilai_indeks_wrapper').show();
        $('#edit_jumlah_indeks').attr('required', 'required');
        $('#edit_nilai_indeks').attr('required', 'required');
    });

    // Handle Export Button Click
    $('#btnExport').on('click', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Export Data?',
            text: 'Apakah Anda yakin ingin mengexport data JTL ke Excel?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Export!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Mengexport data...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Create invisible link and trigger download
                const link = document.createElement('a');
                link.href = $(this).attr('href');
                link.download = '';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                // Close loading after a short delay
                setTimeout(() => {
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil diexport',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }, 2000);
            }
        });
    });
  
});

// Add CSS for loading animation
$('<style>')
    .prop('type', 'text/css')
    .html(`
        .rotate {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .badge {
            font-size: 0.875em;
        }
    `)
    .appendTo('head');
</script>
@endpush
