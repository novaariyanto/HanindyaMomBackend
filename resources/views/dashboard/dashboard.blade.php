@extends('root')
@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Kartu Ringkasan -->
    <div class="row">
        <!-- Kartu Total Pegawai -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary-subtle shadow-none">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="round rounded text-bg-primary d-flex align-items-center justify-content-center">
                            <i class="ti ti-users fs-7" title="Total Pegawai"></i>
                        </div>
                        <h6 class="mb-0 ms-3"></h6>
                        <h3 class="mb-0 fw-semibold fs-7"><span id="total-pegawai"></span></h3>

                    </div>
                    <div class="mt-2">
                        <center>
                            <span class="mb-0">Total Pegawai</span>
                        </center>
                        {{-- <a href="{{ route('pegawai.index') }}" class="fw-bold text-primary stretched-link">
                            Lihat Detail <i class="ti ti-chevron-right"></i>
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Hadir Hari Ini -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success-subtle shadow-none">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="round rounded text-bg-success d-flex align-items-center justify-content-center">
                            <i class="ti ti-check fs-7" title="Hadir Hari Ini"></i>
                        </div>
                        <h6 class="mb-0 ms-3 fs-7"><span id="total-absen"></span></h6>

                    </div>
                    <div class="mt-3">

                        <center>
                            <span class="mb-0">Total Kehadiran Hari Ini</span>
                        </center>

                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Terlambat -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning-subtle shadow-none">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="round rounded text-bg-warning d-flex align-items-center justify-content-center">
                            <i class="ti ti-clock fs-7" title="Terlambat"></i>
                        </div>
                        <h6 class="mb-0 ms-3 fs-7"><span id="total-terlambat"></span></h6>

                    </div>
                    <div class="mt-3">

                        <center>
                            <span class="mb-0">Total Terlambat Hari Ini</span>
                        </center>


                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Tidak Hadir -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger-subtle shadow-none">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="round rounded text-bg-danger d-flex align-items-center justify-content-center">
                            <i class="ti ti-x fs-7" title="Tidak Hadir"></i>
                        </div>
                        <h6 class="mb-0 ms-3 fs-7"><span id="total-tidak-hadir"></span></h6>

                    </div>
                    <div class="mt-3">
                        <center>Total Tidak Hadir Hari Ini</center>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Grafik dan Tabel -->
    <div class="row">
        <!-- Grafik Kehadiran -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="ti ti-chart-bar me-1"></i>
                    Statistik Kehadiran (7 Hari Terakhir)
                </div>
                <div class="card-body">
                    <canvas id="attendanceChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Departemen -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="ti ti-chart-pie me-1"></i>
                    Kehadiran per Departemen
                </div>
                <div class="card-body">
                    <canvas id="departmentChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Absensi Terbaru -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="ti ti-table me-1"></i>
            Absensi Terbaru
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="tabelAbsensiTerbaru" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Pegawai</th>
                            <th>Departemen</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensiTerbaru ?? [] as $absensi)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-user me-2 text-secondary"></i>
                                    {{ $absensi->pegawai->nama ?? '-' }}
                                </div>
                            </td>
                            <td>{{ $absensi->pegawai->departemen->nama ?? '-' }}</td>
                            <td>{{ $absensi->waktu_masuk ? date('H:i', strtotime($absensi->waktu_masuk)) : '-' }}</td>
                            <td>{{ $absensi->waktu_keluar ? date('H:i', strtotime($absensi->waktu_keluar)) : '-' }}</td>
                            <td>
                                @if($absensi->status == 'hadir')
                                <span class="badge bg-success"><i class="ti ti-check me-1"></i>Hadir</span>
                                @elseif($absensi->status == 'terlambat')
                                <span class="badge bg-warning"><i class="ti ti-clock me-1"></i>Terlambat</span>
                                @elseif($absensi->status == 'izin')
                                <span class="badge bg-info"><i class="ti ti-file me-1"></i>Izin</span>
                                @elseif($absensi->status == 'sakit')
                                <span class="badge bg-secondary"><i class="ti ti-medicine me-1"></i>Sakit</span>
                                @elseif($absensi->status == 'tidak_hadir')
                                <span class="badge bg-danger"><i class="ti ti-x me-1"></i>Tidak Hadir</span>
                                @else
                                <span class="badge bg-dark">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('absensi.detail', $absensi->id) }}" class="btn btn-sm btn-info">
                                    <i class="ti ti-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data absensi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
</div>
@endsection



@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script>

        // Chart untuk Kehadiran per Departemen
        const departmentCtx = document.getElementById('departmentChart').getContext('2d');
        const departmentChart = new Chart(departmentCtx, {
            type: 'bar',
            data: {
                labels: ['HRD', 'IT', 'Keuangan', 'Marketing', 'Produksi'],
                datasets: [{
                    label: 'Jumlah Karyawan',
                    data: [8, 12, 10, 15, 20], // Data statis
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                    },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                    },
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });



        $(document).ready(function () {

            const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
const attendanceChart = new Chart(attendanceCtx, {
    type: 'line',
    data: {
        labels: [], // Initial empty labels
        datasets: [{
            label: 'Jumlah Kehadiran',
            data: [], // Initial empty data
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 2,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
            },
        },
        scales: {
            x: {
                beginAtZero: true,
            },
            y: {
                beginAtZero: true,
            },
        },
    },
});

    // Fungsi untuk memuat data dashboard
    function loadDashboardData() {
        $.ajax({
            url: "{{ route('dashboard.getData') }}", // Route ke endpoint getData
            method: "GET",
            dataType: "json",
            success: function (response) {
                // Perbarui kartu ringkasan
                $('#total-pegawai').text(response.total_pegawai); // Total Pegawai
                $('#total-absen').text(response.kehadiran_hari_ini); // Total Pegawai
                $('#total-terlambat').text(response.terlambat_hari_ini); // Total Pegawai
                $('#total-tidak-hadir').text(response.tidak_hadir_hari_ini); // Total Pegawai


                // Perbarui grafik kehadiran 7 hari terakhir
                updateAttendanceChart(response.statistik_kehadiran);

                // Perbarui grafik kehadiran per divisi
                updateDepartmentChart(response.kehadiran_per_divisi);

                // Perbarui tabel absensi terbaru
                updateAbsensiTable(response.absensi_terbaru);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching dashboard data:", error);
                alert("Gagal memuat data dashboard. Silakan coba lagi.");
            }
        });
    }

    // Panggil fungsi saat halaman dimuat
    loadDashboardData();

    // Fungsi untuk memperbarui grafik kehadiran 7 hari terakhir
    function updateAttendanceChart(data) {
        if (!attendanceChart) {
        console.error("attendanceChart is not initialized.");
        return;
    }

    // Update labels and data
    attendanceChart.data.labels = data.map(item => item.tanggal);
    attendanceChart.data.datasets[0].data = data.map(item => item.jumlah);

    // Notify Chart.js to re-render
    attendanceChart.update();
    }

    // Fungsi untuk memperbarui grafik kehadiran per divisi
    function updateDepartmentChart(data) {



        if (!departmentChart) {
        console.error("departmentChart is not initialized.");
        return;
    }

    // Update labels and data
    departmentChart.data.labels = data.map(item => item.nama_divisi);
    departmentChart.data.datasets[0].data = data.map(item => item.jumlah_kehadiran);

    // Notify Chart.js to re-render
    departmentChart.update();


    }

    // Fungsi untuk memperbarui tabel absensi terbaru
    function updateAbsensiTable(data) {
        const tableBody = $('#tabelAbsensiTerbaru tbody');
        tableBody.empty(); // Kosongkan tabel sebelumnya

        if (data.length > 0) {
            data.forEach(absensi => {
                const row = `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="ti ti-user me-2 text-secondary"></i>
                                ${absensi.nama_pegawai}
                            </div>
                        </td>
                        <td>${absensi.divisi}</td>
                        <td>${absensi.waktu_masuk}</td>
                        <td>${absensi.waktu_keluar}</td>
                        <td>
                            ${getStatusBadge(absensi.status)}
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info">
                                <i class="ti ti-eye me-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
        } else {
            tableBody.append('<tr><td colspan="6" class="text-center">Tidak ada data absensi</td></tr>');
        }
    }

    // Fungsi untuk mendapatkan badge status
    function getStatusBadge(status) {
        switch (status) {
            case 'hadir':
                return '<span class="badge bg-success"><i class="ti ti-check me-1"></i>Hadir</span>';
            case 'terlambat':
                return '<span class="badge bg-warning"><i class="ti ti-clock me-1"></i>Terlambat</span>';
            case 'izin':
                return '<span class="badge bg-info"><i class="ti ti-file me-1"></i>Izin</span>';
            case 'sakit':
                return '<span class="badge bg-secondary"><i class="ti ti-medicine me-1"></i>Sakit</span>';
            case 'tidak_hadir':
                return '<span class="badge bg-danger"><i class="ti ti-x me-1"></i>Tidak Hadir</span>';
            default:
                return '<span class="badge bg-dark">-</span>';
        }
    }
});

    </script>
@endpush
