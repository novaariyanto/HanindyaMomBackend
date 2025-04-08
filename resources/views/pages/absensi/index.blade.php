@extends('root')
@section('title', 'Absensi')
@section('content')
<style>
    .container-fluid {
        max-width: 100% !important;
    }
    .table {
        width: 100% !important;
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }
    .header-title {
        font-weight: 600;
        color: #344767;
    }
    .filter-container {
        background-color: #f8fafc;
        border-radius: 8px;
        padding: 15px;
    }
    .btn-custom-primary {
        background-color: #4361ee;
        color: white;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-custom-primary:hover {
        background-color: #3a56d4;
        transform: translateY(-1px);
    }
    .btn-custom-danger {
        background-color: #ef4444;
        color: white;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-custom-danger:hover {
        background-color: #dc2626;
        transform: translateY(-1px);
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
    }
    .status-hadir {
        background-color: #10b981;
        color: white;
    }
    .status-terlambat {
        background-color: #f59e0b;
        color: white;
    }
    .status-absen {
        background-color: #ef4444;
        color: white;
    }
    .status-izin {
        background-color: #6366f1;
        color: white;
    }
    .action-btn-container {
        display: flex;
        gap: 6px;
    }
    .stat-card {
        border-left: 4px solid;
        padding: 15px;
        margin-bottom: 20px;
    }
    .stat-card.hadir {
        border-left-color: #10b981;
    }
    .stat-card.terlambat {
        border-left-color: #f59e0b;
    }
    .stat-card.absen {
        border-left-color: #ef4444;
    }
    .stat-card.izin {
        border-left-color: #6366f1;
    }
    .stat-value {
        font-size: 24px;
        font-weight: 700;
    }
    .stat-label {
        font-size: 14px;
        color: #64748b;
    }
    .date-range-container {
        display: flex;
        align-items: center;
        background-color: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 5px 15px;
    }
    .date-range-container i {
        color: #64748b;
    }
    .date-input {
        border: none;
        padding: 8px;
    }
    .date-input:focus {
        outline: none;
    }
    .table thead th {
        background-color: #f1f5f9;
        color: #475569;
        font-weight: 600;
        padding: 12px 15px;
    }
    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8fafc;
    }
    .pagination .page-item.active .page-link {
        background-color: #4361ee;
        border-color: #4361ee;
    }
    .select2-container .select2-selection--single {
        height: 38px !important;
        border-radius: 8px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
    .time-container {
        display: flex;
        flex-direction: column;
    }
    .time-label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 3px;
    }
    .time-value {
        font-weight: 500;
    }
    .time-value.actual {
        font-weight: 600;
    }
    .time-value.late {
        color: #ef4444;
    }
    .time-comparison {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 8px;
        border-radius: 8px;
        background-color: #f8fafc;
    }
    .time-comparison-arrow {
        margin: 0 10px;
        color: #64748b;
    }
</style>

<div class="p-3">
    @include('components.breadcrumb', [
        'title' => 'Data Absensi',
        'links' => [['url' => route('dashboard'), 'label' => 'Dashboard']],
        'current' => 'Absensi',
    ])
    
    <!-- Notifikasi Sukses -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="ti ti-check-circle fs-5 me-2"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card hadir">
                <div class="stat-value" id="stat-hadir">0</div>
                <div class="stat-label">Hadir</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card terlambat">
                <div class="stat-value" id="stat-terlambat">0</div>
                <div class="stat-label">Terlambat</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card absen">
                <div class="stat-value" id="stat-absen">0</div>
                <div class="stat-label">Tidak Hadir</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card izin">
                <div class="stat-value" id="stat-izin">0</div>
                <div class="stat-label">Izin/Cuti</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body filter-container">
            <div class="row g-3">
                <!-- Filter Divisi -->
                <div class="col-md-3">
                    <label for="filter-divisi" class="form-label text-muted">Divisi</label>
                    <select class="form-select select2-divisi" id="filter-divisi" style="width: 100%;">
                        <option value="">Semua Divisi</option>
                    </select>
                </div>
    
                <!-- Filter Pegawai -->
                <div class="col-md-3">
                    <label for="filter-pegawai" class="form-label text-muted">Pegawai</label>
                    <select class="form-select select2-pegawai" id="filter-pegawai" style="width: 100%;">
                        <option value="">Semua Pegawai</option>
                    </select>
                </div>
    
                <!-- Filter Tanggal Range -->
                <div class="col-md-4">
                    <label class="form-label text-muted">Periode</label>
                    <div class="date-range-container">
                        <i class="ti ti-calendar me-2"></i>
                        <input type="date" class="date-input" id="start_date" placeholder="Tanggal Mulai">
                        <span class="mx-2">-</span>
                        <input type="date" class="date-input" id="end_date" placeholder="Tanggal Akhir">
                    </div>
                </div>
    
                <!-- Tombol Filter -->
                <div class="col-md-2 d-flex align-items-end">
                    <button id="btn-filter" class="btn btn-custom-primary w-100">
                        <i class="ti ti-filter me-1"></i> Terapkan Filter
                    </button>
                </div>
            </div>
        </div>
    </div>



    <!-- Tabel Absensi -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped">
                    <thead>
                        <tr>
                            
                            <th width="10%">NIK</th>
                            <th width="15%">Nama Pegawai</th>
                            <th width="10%">Tanggal</th>
                            <th width="15%">Jam Masuk</th>
                            <th width="15%">Jam Keluar</th>
                            <th width="10%">Status</th>
                            <th width="10%">Durasi Kerja</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih File Excel</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="file" name="file" accept=".xlsx, .xls, .csv" required>
                                <a href="#" class="btn btn-light">
                                    <i class="ti ti-download"></i> Template
                                </a>
                            </div>
                            <div class="form-text">Format file: .xlsx, .xls, atau .csv</div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-custom-primary">
                                <i class="ti ti-upload me-1"></i> Import Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Absensi -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detail-content">
                    <!-- Detail content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Hapus</button>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Initialize Select2
        $('#filter-divisi').select2({
            placeholder: 'Pilih Divisi',
            allowClear: true,
            ajax: {
                url: '{{ route('select2.divisi') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    let results = data.data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.nama
                        };
                    });
                    results.unshift({ id: '', text: 'Tampilkan Semua' });
                    return {
                        results: results,
                        pagination: {
                            more: data.current_page < data.last_page
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 0,
        });


        $('.select2-pegawai').select2({
        dropdownParent: $(".filter-container"),
        ajax: {
            url: '{{ route("select2.pegawaiMaster") }}', // Endpoint API untuk pegawai
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    divisi_id: $("#filter-divisi").val(),
                    q: params.term, // Query pencarian
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            id: item.nik,
                            text: `${item.nama} (${item.nik})` // Format: "Nama Pegawai (NIP)"
                        };
                    }),
                    pagination: {
                        more: data.current_page < data.last_page
                    }
                };
            },
            cache: true
        },
        placeholder: 'Pilih Pegawai...',
        width: '100%'
    });


        // Set default dates if empty
        if (!$('#start_date').val()) {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            
            $('#start_date').val(formatDate(firstDay));
            $('#end_date').val(formatDate(today));
        }

        // Function to format date
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function formatDuration(seconds) {
    if (!seconds || seconds <= 0) return '-'; // Jika tidak ada durasi, tampilkan '-'

    const hours = Math.floor(seconds / 3600); // Hitung jumlah jam
    const minutes = Math.floor((seconds % 3600) / 60); // Hitung jumlah menit

    let result = '';
    if (hours > 0) result += `${hours} jam `;
    if (minutes > 0) result += `${minutes} menit`;

    return result.trim() || '-'; // Jika hasil kosong, tampilkan '-'
}


        // Initialize DataTable
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: 'Export Excel',
                    className: 'd-none',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6]
                    }
                }
            ],
            ajax: {
                url: '{{ route("absensi.index") }}',
                data: function (d) {
                    d.divisi_id = $('#filter-divisi').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [
            
                { data: 'nik', name: 'pegawai.nik' },
                { data: 'nama', name: 'pegawai.nama' },
                { 
                    data: 'tanggal', 
                    name: 'tanggal',
                    render: function(data) {
                        if (!data) return '-';
                        const date = new Date(data);
                        return date.toLocaleDateString('id-ID', { 
                            day: '2-digit', 
                            month: 'short', 
                            year: 'numeric' 
                        });
                    }
                },
                { 
                    data: null, 
                    name: 'jam_masuk',
                    render: function(data, type, row) {
                        const jamMasukJadwal = row.jam_masuk_jadwal ? formatTimeIndonesia(row.jam_masuk_jadwal) : '-';
                        const jamMasukAktual = row.jam_masuk ? formatTimeIndonesia(row.jam_masuk) : '-';
                        
                        const isLateClass = isLate(row.jam_masuk_jadwal, row.jam_masuk) ? 'late' : '';
                        
                        return `
                        <div class="time-container">
                            <div class="time-comparison">
                                <div>
                                    <div class="time-label">Jadwal</div>
                                    <div class="time-value">${jamMasukJadwal}</div>
                                </div>
                                <div class="time-comparison-arrow">→</div>
                                <div>
                                    <div class="time-label">Aktual</div>
                                    <div class="time-value actual ${isLateClass}">${jamMasukAktual}</div>
                                </div>
                            </div>
                        </div>`;
                    }
                },
                { 
                    data: null, 
                    name: 'jam_keluar',
                    render: function(data, type, row) {
                        const jamKeluarJadwal = row.jam_keluar_jadwal ? formatTimeIndonesia(row.jam_keluar_jadwal) : '-';
                        const jamKeluarAktual = row.jam_keluar ? formatTimeIndonesia(row.jam_keluar) : '-';
                        
                        return `
                        <div class="time-container">
                            <div class="time-comparison">
                                <div>
                                    <div class="time-label">Jadwal</div>
                                    <div class="time-value">${jamKeluarJadwal}</div>
                                </div>
                                <div class="time-comparison-arrow">→</div>
                                <div>
                                    <div class="time-label">Aktual</div>
                                    <div class="time-value actual">${jamKeluarAktual}</div>
                                </div>
                            </div>
                        </div>`;
                    }
                },
                { 
                    data: 'status', 
                    name: 'status',
                    render: function(data) {
                        let badgeClass = '';
                        
                        switch(data ? data.toLowerCase() : '') {
                            case 'hadir':
                                badgeClass = 'status-hadir';
                                break;
                            case 'terlambat':
                                badgeClass = 'status-terlambat';
                                break;
                            case 'tidak hadir':
                            case 'absen':
                                badgeClass = 'status-absen';
                                data = 'Tidak Hadir';
                                break;
                            case 'izin':
                            case 'cuti':
                                badgeClass = 'status-izin';
                                break;
                            default:
                                badgeClass = 'bg-secondary';
                                data = data || 'Belum Ada';
                        }
                        
                        return `<span class="status-badge ${badgeClass}">${data}</span>`;
                    }
                },
                {
    data: 'durasi_kerja_detik',
    name: 'durasi_kerja_detik',
    render: function(data) {
        return formatDuration(data); // Gunakan fungsi formatDuration
    }
},

                
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                        <div class="action-btn-container">
                            <button type="button" class="btn btn-sm btn-info text-white" 
                                onclick="viewDetail('${row.uuid}')" title="Detail">
                                <i class="ti ti-eye"></i>
                            </button>
                           
                            <button type="button" class="btn btn-sm btn-danger" 
                                onclick="deleteAbsensi('${row.uuid}')" title="Hapus">
                                <i class="ti ti-trash"></i>
                            </button>
                        </div>`;
                    }
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data yang ditampilkan",
                infoFiltered: "(difilter dari _MAX_ total data)",
                zeroRecords: "Tidak ada data yang cocok",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            drawCallback: function() {
                console.log("xxx");
                updateStatistics();
            }
        });

        // Filter data when button clicked
        $('#btn-filter').click(function() {
            table.ajax.reload();
        });
        
        // Export button
        $('#btn-export').click(function() {
            $('.buttons-excel').click();
        });
        
        // Select all checkboxes
        $('#select-all').change(function() {
            $('.row-checkbox').prop('checked', $(this).prop('checked'));
            toggleDeleteButton();
        });
        
        // Toggle delete button visibility
        $(document).on('change', '.row-checkbox', function() {
            toggleDeleteButton();
        });
        
        // Delete selected items
        $('.delete-multiple').click(function() {
            const selectedIds = $('.row-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            
            if (selectedIds.length === 0) {
                alert('Pilih minimal satu data untuk dihapus');
                return;
            }
            
            if (confirm(`Apakah Anda yakin ingin menghapus ${selectedIds.length} data terpilih?`)) {
                deleteMultiple(selectedIds);
            }
        });

        // Function to check if time is late
        function isLate(scheduled, actual) {
            if (!scheduled || !actual) return false;
            
            const scheduledTime = new Date(`2000-01-01T${scheduled}`);
            const actualTime = new Date(`2000-01-01T${actual}`);
            
            return actualTime > scheduledTime;
        }
        
        // Function to toggle delete button visibility
        function toggleDeleteButton() {
            if ($('.row-checkbox:checked').length > 0) {
                $('.delete-multiple').show();
            } else {
                $('.delete-multiple').hide();
            }
        }
        
        // Hide delete button initially
        $('.delete-multiple').hide();
        
        // Update statistics
        function updateStatistics() {
            $.ajax({
                url: '{{route('absensi.count')}}',
                type: 'GET',
                data: {
                    divisi_id: $('#filter-divisi').val(),
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val()
                },
                success: function(response) {
                    $('#stat-hadir').text(response.hadir || 0);
                    $('#stat-terlambat').text(response.terlambat || 0);
                    $('#stat-absen').text(response.absen || 0);
                    $('#stat-izin').text(response.izin || 0);
                }
            });
        }
    });

    // View detail function
    function viewDetail(id) {
    $.ajax({
        url: "{{route('absensi.detail')}}?uuid="+id,
        type: 'GET',
        success: function(response) {
            let html = `
            <div class="p-3">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <div>
                        <h5 class="fw-bold mb-1">${response.pegawai.nama}</h5>
                        <span class="text-secondary">NIK: ${response.pegawai.nik}</span>
                    </div>
                    <span class="badge ${getStatusClass(response.status)} px-3 py-2">${response.status || 'Belum Ada'}</span>
                </div>
                
                <div class="row g-3">
                    <div class="col-6">
                        <small class="text-muted d-block">Tanggal</small>
                        <span class="fw-semibold">${formatDate(response.tanggal)}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Divisi</small>
                        <span class="fw-semibold">${response.pegawai.divisi.nama}</span>
                    </div>
                </div>

                <div class="mt-3 border-bottom pb-2">
                    <small class="text-muted d-block mb-1">Jam Masuk</small>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted d-block">Jadwal</small>
                            <span class="fw-semibold">${response.jam_masuk_jadwal ? formatTimeIndonesia(response.jam_masuk_jadwal) : '-'}</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Aktual</small>
                            <span class="${isLate(response.jam_masuk_jadwal, response.jam_masuk) ? 'text-danger fw-bold' : 'fw-semibold'}">${response.jam_masuk ? formatTimeIndonesia(response.jam_masuk) : '-'}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-3 border-bottom pb-2">
                    <small class="text-muted d-block mb-1">Jam Keluar</small>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted d-block">Jadwal</small>
                            <span class="fw-semibold">${response.jam_keluar_jadwal ? formatTimeIndonesia(response.jam_keluar_jadwal) : '-'}</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Aktual</small>
                            <span class="fw-semibold">${response.jam_keluar ? formatTimeIndonesia(response.jam_keluar) : '-'}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <small class="text-muted d-block">Keterangan</small>
                    <span class="fw-semibold">${response.keterangan || '-'}</span>
                </div>

                ${response.bukti_kehadiran ? `
                <div class="mt-3">
                    <small class="text-muted d-block">Bukti Kehadiran</small>
                    <img src="${response.bukti_kehadiran}" class="img-fluid mt-2 rounded shadow-sm" style="max-height: 200px;">
                </div>` : ''}
            </div>`;

            $('#detail-content').html(html);
            $('#detailModal').modal('show');
        },
        error: function() {
            alert('Gagal memuat detail absensi');
        }
    });
}


    // Function to format time in Indonesian format
    function formatTimeIndonesia(timeString) {
    if (!timeString) return '-';

    // Pastikan formatnya sesuai "Y-m-d H:i:s"
    const dateTimeParts = timeString.split(' ');
    if (dateTimeParts.length !== 2) return timeString;

    const timePart = dateTimeParts[1]; // Ambil bagian waktu (H:i:s)
    const timeComponents = timePart.split(':');

    if (timeComponents.length < 2) return timeString;

    let hours = parseInt(timeComponents[0], 10);
    let minutes = timeComponents[1];

    // Pastikan jam memiliki dua digit
    const formattedHours = hours.toString().padStart(2, '0');

    return `${formattedHours}:${minutes} WIB`;
}


function deleteAbsensi(id) {
    // Tampilkan modal konfirmasi
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
    deleteModal.show();

    // Tambahkan event listener untuk tombol "Hapus" di modal
    document.getElementById('confirmDeleteButton').onclick = function () {
        $.ajax({
            url: '/absensi/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (response) {
                // Tutup modal setelah berhasil
                deleteModal.hide();

                // Tampilkan pesan sukses
                $('#successToast .msg-box').text(response.meta.message);
    
    $('#successToast').toast('show');  // Menampilkan toast


                // Reload tabel
                $('#datatable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                // Tutup modal jika terjadi kesalahan
                deleteModal.hide();

                // Tampilkan pesan kesalahan
                alert('Terjadi kesalahan saat menghapus data.');
            }
        });
    };
}

    // Delete multiple function
    function deleteMultiple(ids) {
        $.ajax({
            url: '',
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                ids: ids
            },
            success: function (response) {
                
                $('#datatable').DataTable().ajax.reload();
                $('#select-all').prop('checked', false);
                $('.delete-multiple').hide();
            },
            error: function (xhr) {
                alert('Terjadi kesalahan saat menghapus data.');
            }
        });
    }
    
    // Edit function
    function editAbsensi(id) {
        window.location.href = `/absensi/${id}/edit`;
    }
    

    // Helper functions
    function getStatusClass(status) {
        if (!status) return 'bg-secondary';
        
        switch(status.toLowerCase()) {
            case 'hadir': return 'status-hadir';
            case 'terlambat': return 'status-terlambat';
            case 'tidak hadir':
            case 'absen': return 'status-absen';
            case 'izin':
            case 'cuti': return 'status-izin';
            default: return 'bg-secondary';
        }
    }
    
    function isLate(scheduled, actual) {
        if (!scheduled || !actual) return false;
        
        const scheduledTime = new Date(`2000-01-01T${scheduled}`);
        const actualTime = new Date(`2000-01-01T${actual}`);
        
        return actualTime > scheduledTime;
    }
    
    function formatDate(dateString) {
        if (!dateString) return '-';
        
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', { 
            day: '2-digit', 
            month: 'long', 
            year: 'numeric' 
        });
    }
</script>
@endpush