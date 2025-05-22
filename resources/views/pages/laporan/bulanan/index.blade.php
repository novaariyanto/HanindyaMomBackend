@extends('root')
@section('title', 'Rekap Absensi Bulanan')
@section('content')

<style>
    .presensi {
        cursor: pointer;
    }
</style>
<div class="">
    @include('components.breadcrumb', [
        'title' => 'Rekap Absensi Bulanan',
        'links' => [['url' => route('dashboard'), 'label' => 'Laporan']],
        'current' => 'Rekap Absensi Bulanan',
    ])
    <div class="widget-content searchable-container list">
        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-body">
            <div class="row mb-3">
                <div class="col-md-4 col-xl-3">
                    <div class="me-3">
                        <label for="filter-divisi" class="form-label visually-hidden">Filter Divisi</label>
                        <select class="form-select" id="filter-divisi">
                            <option value="">Semua Divisi</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3">
                    <div class="me-3">
                        <label for="filter-bulan" class="form-label visually-hidden">Filter Bulan</label>
                        <select class="form-select" id="filter-bulan">
                            <option value="">Pilih Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == date('m') ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3">
                    <div class="me-3">
                        <label for="filter-tahun" class="form-label visually-hidden">Filter Tahun</label>
                        <select class="form-select" id="filter-tahun">
                            <option value="">Pilih Tahun</option>
                            @for ($i = date('Y') - 5; $i <= date('Y'); $i++)
                                <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-xl-3 text-end">
                    <button id="btn-filter" class="btn btn-primary me-2">Terapkan Filter</button>
                    <button id="btn-export-pdf" class="btn btn-success">Export PDF</button>
                </div>
            </div>
        </div>

        <div class="card card-body">
            <div class="wrap-table">
                <div class="table-responsive">
                    <h4 class="text-center mb-4">Laporan Absensi Bulanan Pegawai</h4>
                    <p class="text-center mb-4">
                        📅 Periode: <span id="periode">Maret 2025</span> | 
                        🏢 Divisi: <span id="departemen">IT</span>
                    </p>
                    <table class="table table-bordered table-striped" id="absensi-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="cursor: pointer;">Nama Pegawai</th>
                                <th style="cursor: pointer;">Total Hadir</th>
                                <th style="cursor: pointer;">Total Terlambat</th>
                                <th style="cursor: pointer;">Total Izin</th>
                                <th style="cursor: pointer;">Total Alpha</th>
                                <th style="cursor: pointer;">Total Jam Kerja</th>
                                <th style="cursor: pointer;">Persentase Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody id="absensi-table-body">
                            <!-- Data akan dimuat secara dinamis menggunakan JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Inisialisasi Select2 untuk filter divisi
        $('#filter-divisi').select2({
            placeholder: 'Pilih Divisi',
            allowClear: true,
            ajax: {
                url: '{{ route('select2.divisi') }}', // Endpoint untuk memuat data divisi
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // Query pencarian
                        page: params.page || 1 // Halaman saat ini
                    };
                },
                processResults: function (data, params) {
                    let results = data.data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.nama
                        };
                    });
                    // Pastikan opsi "Tampilkan Semua" selalu ada
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
            minimumInputLength: 0, // Izinkan pencarian tanpa input karakter
        });

        // Fungsi untuk memuat data absensi
        function loadAbsensi() {
    const divisiId = $('#filter-divisi').val();
    const bulan = $('#filter-bulan').val();
    const tahun = $('#filter-tahun').val();

    $.ajax({
        url: '{{ route('laporan.getLaporanAbsensi') }}', // Endpoint API
        method: 'GET',
        data: {
            divisi_id: divisiId,
            month: bulan,
            year: tahun,
        },
        success: function (response) {
            const tbody = $('#absensi-table-body');
            tbody.empty(); // Bersihkan tabel sebelum mengisi ulang

            if (response.success) {
                let data = response.data;

                // Update periode dan departemen
                const bulanNama = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                $('#periode').text(`${bulanNama[bulan - 1]} ${tahun}`);
                $('#departemen').text(response.divisi ?? 'Semua Divisi');

                if (data.length > 0) {
                    // Isi data pegawai jika ada data
                    renderTable(data);

                    // Tambahkan event listener untuk sorting
                    addSortingFunctionality(data);
                } else {
                    // Tampilkan pesan jika data kosong
                    const emptyRow = `
                        <tr>
                            <td colspan="8" class="text-center">Harap pilih divisi terlebih dahulu</td>
                        </tr>
                    `;
                    tbody.append(emptyRow);
                }
            } else {
                const emptyRow = `
                    <tr>
                        <td colspan="8" class="text-center">Harap pilih divisi terlebih dahulu</td>
                    </tr>
                `;
                tbody.append(emptyRow);
            }
        },
        error: function () {
            alert('Terjadi kesalahan saat memuat data absensi.');
        }
    });
}

// Fungsi untuk merender tabel
function renderTable(data) {
    const tbody = $('#absensi-table-body');
    tbody.empty();

    data.forEach((pegawai, index) => {
        const row = `
            <tr>
                <td>${index + 1}</td>
                <td>${pegawai.nama_pegawai}</td>
                <td>${pegawai.total_hadir || 0}</td>
                <td>${pegawai.total_terlambat || 0}</td>
                <td>${pegawai.total_izin || 0}</td>
                <td>${pegawai.total_alpha || 0}</td>
                <td>${pegawai.total_jam_kerja || '0 Jam'}</td>
                <td>${pegawai.persentase_kehadiran || '0%'}</td>
            </tr>
        `;
        tbody.append(row);
    });
}

// Fungsi untuk menambahkan fitur sorting
function addSortingFunctionality(data) {
    const headers = document.querySelectorAll('#absensi-table thead th');
    let currentSortColumn = null;
    let isAscending = true;

    headers.forEach((header, index) => {
        header.addEventListener('click', () => {
            // Tentukan kolom yang diklik
            const column = header.textContent.trim().toLowerCase();

            // Tentukan tipe data untuk kolom tertentu
            const sortKey = column === 'no' ? 'index' :
                            column === 'nama pegawai' ? 'nama_pegawai' :
                            column === 'total hadir' ? 'total_hadir' :
                            column === 'total terlambat' ? 'total_terlambat' :
                            column === 'total izin' ? 'total_izin' :
                            column === 'total alpha' ? 'total_alpha' :
                            column === 'total jam kerja' ? 'total_jam_kerja' :
                            column === 'persentase kehadiran' ? 'persentase_kehadiran' : null;

            if (!sortKey) return;

            // Toggle urutan ascending/descending
            if (currentSortColumn === sortKey) {
                isAscending = !isAscending;
            } else {
                currentSortColumn = sortKey;
                isAscending = true;
            }

            // Urutkan data berdasarkan kolom yang dipilih
            data.sort((a, b) => {
                let valA = a[sortKey];
                let valB = b[sortKey];

                // Handle kolom khusus seperti "total jam kerja" dan "persentase kehadiran"
                if (sortKey === 'total_jam_kerja') {
                    valA = parseFloat(valA) || 0;
                    valB = parseFloat(valB) || 0;
                } else if (sortKey === 'persentase_kehadiran') {
                    valA = parseFloat(valA) || 0;
                    valB = parseFloat(valB) || 0;
                }

                // Bandingkan nilai
                if (valA < valB) return isAscending ? -1 : 1;
                if (valA > valB) return isAscending ? 1 : -1;
                return 0;
            });

            // Render ulang tabel dengan data yang sudah diurutkan
            renderTable(data);
        });
    });
}

        // Event listener untuk tombol filter
        $('#btn-filter').on('click', function () {
            loadAbsensi();
        });

        // Muat data absensi saat halaman pertama kali dimuat
        loadAbsensi();
    });

    document.getElementById('btn-export-pdf').addEventListener('click', function () {
    const divisiId = document.getElementById('filter-divisi').value;
    const bulan = document.getElementById('filter-bulan').value;
    const tahun = document.getElementById('filter-tahun').value;

    // Redirect ke endpoint export PDF dengan parameter filter
    window.location.href = `{{route('laporan.bulanan.pdf')}}?divisi_id=${divisiId}&bulan=${bulan}&tahun=${tahun}`;

});


</script>
@endpush