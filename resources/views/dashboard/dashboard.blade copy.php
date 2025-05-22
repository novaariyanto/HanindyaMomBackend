@extends('root')
@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mt-4">Dashboard Absensi Pegawai</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Kartu Ringkasan -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-users fs-3 me-2"></i>
                        <div>
                            <h5>Total Pegawai</h5>
                            <h2>{{ $totalPegawai ?? '0' }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('pegawai.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="ti ti-chevron-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-check fs-3 me-2"></i>
                        <div>
                            <h5>Hadir Hari Ini</h5>
                            <h2>{{ $kehadiranHariIni ?? '0' }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Lihat Detail</a>
                    <div class="small text-white"><i class="ti ti-chevron-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-clock fs-3 me-2"></i>
                        <div>
                            <h5>Terlambat</h5>
                            <h2>{{ $terlambatHariIni ?? '0' }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Lihat Detail</a>
                    <div class="small text-white"><i class="ti ti-chevron-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-x fs-3 me-2"></i>
                        <div>
                            <h5>Tidak Hadir</h5>
                            <h2>{{ $tidakHadirHariIni ?? '0' }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Lihat Detail</a>
                    <div class="small text-white"><i class="ti ti-chevron-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik dan Tabel -->
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
    </div>
</div>
@endsection



@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

    <script>
        // Chart untuk Statistik Kehadiran (7 Hari Terakhir)
        const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceChart = new Chart(attendanceCtx, {
            type: 'line',
            data: {
                labels: ['Hari 1', 'Hari 2', 'Hari 3', 'Hari 4', 'Hari 5', 'Hari 6', 'Hari 7'],
                datasets: [{
                    label: 'Jumlah Kehadiran',
                    data: [10, 15, 12, 18, 20, 22, 25], // Data statis
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
    </script>
@endpush
