@extends('root')
@section('title', 'Monitoring Absensi')
@section('content')

<style>
    .presensi{
        cursor: pointer;
    }
</style>
<div class="">
    @include('components.breadcrumb', [
        'title' => 'Monitoring Absensi',
        'links' => [['url' => route('dashboard'), 'label' => 'Dashboard']],
        'current' => 'Monitoring Absensi',
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
                    <button id="btn-filter" class="btn btn-primary">Terapkan Filter</button>
                </div>
            </div>
        </div>

        <div class="card card-body">
            <div class="wrap-table">
                <div class="table-responsive">
                    <table id="absensi-table" class="table table-bordered">
                        <thead>
                            <tr id="tanggal-header">
                                <th rowspan="2" data-nama-pegawai="Nama Pegawai">Nama Pegawai</th>
                                <!-- Kolom tanggal akan ditambahkan secara dinamis -->
                            </tr>
                            <tr id="hari-header">
                                <!-- Nama hari akan ditambahkan di sini -->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimuat melalui AJAX -->
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

        let sortDirection = true; // true = ascending, false = descending

$(document).on('click','#total-durasi-header',function(){
    const table = $('#absensi-table tbody');
    const rows = table.find('tr').toArray(); // Ambil semua baris tabel sebagai array

    // Sorting baris berdasarkan nilai `data-total-detik`
    rows.sort((a, b) => {
        const aTotalDetik = parseInt($(a).find('[data-total-detik]').attr('data-total-detik') || 0, 10);
        const bTotalDetik = parseInt($(b).find('[data-total-detik]').attr('data-total-detik') || 0, 10);

        return sortDirection ? aTotalDetik - bTotalDetik : bTotalDetik - aTotalDetik;
    });

    // Balikkan arah sorting setiap kali diklik
    sortDirection = !sortDirection;

    // Hapus semua baris lama dan tambahkan baris yang sudah diurutkan
    table.empty().append(rows);

})
// Fungsi untuk memuat data absensi
function loadAbsensi() {
    const divisiId = $('#filter-divisi').val();
    const bulan = $('#filter-bulan').val();
    const tahun = $('#filter-tahun').val();

    $.ajax({
        url: '{{ route('monitoring-absensi.index') }}', // Endpoint API
        method: 'GET',
        data: {
            divisi_id: divisiId,
            month: bulan,
            year: tahun,
        },
        success: function (response) {
            if (response.success) {
                const data = response.data;
                const table = $('#absensi-table');
                const theadTanggal = table.find('#tanggal-header');
                const theadHari = table.find('#hari-header');
                const tbody = table.find('tbody');

                // Bersihkan tabel sebelum mengisi ulang
                theadTanggal.empty();
                theadHari.empty();
                tbody.empty();

                // Ambil semua tanggal dari data pertama
                const allDates = data[0]?.absensi.map(absen => absen.tanggal) || [];

                // Baris pertama header: Nama Pegawai, tanggal, dan Total Durasi Kerja
                theadTanggal.append('<th rowspan="2" data-nama-pegawai="Nama Pegawai">Nama Pegawai</th>');
                allDates.forEach(date => {
                    const day = new Date(date);
                    const isSunday = day.getDay() === 0; // Cek apakah hari Minggu
                    const thClass = isSunday ? 'class="sunday"' : '';
                    theadTanggal.append(`<th ${thClass} data-date="${date}">${day.getDate()}</th>`);
                });
                theadTanggal.append('<th id="total-durasi-header" style="cursor: pointer;" rowspan="2">Total Durasi Kerja</th>'); // Header Total Durasi Kerja

                // Baris kedua header: Nama hari dalam singkatan
                allDates.forEach(date => {
                    const dayName = getDayAbbreviation(new Date(date).getDay()); // Singkatan hari
                    const isSunday = new Date(date).getDay() === 0; // Cek apakah hari Minggu
                    const thClass = isSunday ? 'class="sunday"' : '';
                    theadHari.append(`<th ${thClass}>${dayName}</th>`);
                });

                // Isi data pegawai dan absensi
                data.forEach(pegawai => {
                    const row = $('<tr></tr>');
                    row.append(`<td>${pegawai.nama}</td>`); // Nama pegawai

                    let totalDurasiKerjaDetik = 0; // Inisialisasi total durasi kerja dalam detik

                    pegawai.absensi.forEach(absen => {
                        const durasiKerjaDetik = absen.durasi_kerja_detik || 0;
                        totalDurasiKerjaDetik += durasiKerjaDetik;

                        const status = absen.status || '-'; // Jika tidak ada data, tampilkan '-'
                        const statusClass = getStatusClass(status); // Dapatkan kelas CSS berdasarkan status
                        const statusLetter = getStatusLetter(status); // Dapatkan huruf berdasarkan status

                        // Buat kolom absensi yang bisa diklik jika ada data
                        if (status !== '-') {
                            row.append(`
                                <td class="${statusClass} presensi btn-create" 
                                    data-url="{{route('monitoring-absensi.detail')}}?uuid=${absen.uuid}"
                                    data-status="${status}" 
                                    data-tanggal="${absen.tanggal}" 
                                    data-keterangan="${absen.keterangan || ''}">
                                    ${statusLetter}
                                </td>
                            `);
                        } else {
                            row.append(`<td>-</td>`);
                        }
                    });

                    // Hitung total durasi kerja dalam jam dan menit
                    const totalJam = Math.floor(totalDurasiKerjaDetik / 3600); // Detik ke jam
                    const totalMenit = Math.floor((totalDurasiKerjaDetik % 3600) / 60); // Sisa detik ke menit

                    // Format total durasi kerja sesuai kondisi
                    let totalDurasiFormatted = '';
                    if (totalJam > 0 && totalMenit > 0) {
                        totalDurasiFormatted = `${totalJam} jam ${totalMenit} menit`;
                    } else if (totalJam > 0) {
                        totalDurasiFormatted = `${totalJam} jam`;
                    } else {
                        totalDurasiFormatted = `${totalMenit} menit`;
                    }

                    // Tambahkan kolom Total Durasi Kerja
                    row.append(`<td data-total-detik="${totalDurasiKerjaDetik}">${totalDurasiFormatted}</td>`);

                    tbody.append(row);
                });
            } else {
                alert('Gagal memuat data absensi.');
            }
        },
        error: function () {
            alert('Terjadi kesalahan saat memuat data absensi.');
        }
    });
}



        // Fungsi untuk mendapatkan singkatan hari berdasarkan indeks hari
        function getDayAbbreviation(dayIndex) {
            const days = ['MG', 'SN', 'SL', 'RB', 'KM', 'JM', 'SB']; // Minggu hingga Sabtu
            return days[dayIndex];
        }

        // Fungsi untuk mendapatkan kelas CSS berdasarkan status
        function getStatusClass(status) {
            switch (status) {
                case 'sakit':
                    return 'bg-dark text-white';
                case 'terlambat':
                    return 'bg-warning text-dark';
                case 'izin':
                    return 'bg-info text-dark';
                case 'alpha':
                    return 'bg-danger text-white';
                case 'hadir':
                    return 'bg-success text-white';
                default:
                    return ''; // Default jika status kosong atau tidak dikenali
            }
        }

        // Fungsi untuk mendapatkan huruf berdasarkan status
        function getStatusLetter(status) {
            switch (status) {
                case 'sakit':
                    return 'S';
                case 'terlambat':
                    return 'T';
                case 'izin':
                    return 'I';
                case 'alpha':
                    return 'A';
                case 'hadir':
                    return 'H';
                default:
                    return '-'; // Default jika status kosong atau tidak dikenali
            }
        }

        // Panggil fungsi untuk memuat data absensi saat halaman dimuat
        loadAbsensi();

        // Event listener untuk tombol filter
        $('#btn-filter').on('click', function () {
            loadAbsensi();
        });
    });
</script>
@endpush