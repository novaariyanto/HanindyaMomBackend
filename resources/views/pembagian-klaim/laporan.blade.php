@extends('root')
@section('title', 'Laporan Pembagian Klaim')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Laporan Pembagian Klaim',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
        ],
        'current' => 'Laporan Pembagian Klaim'
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
                    <button onclick="window.print()" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-printer text-white me-1 fs-5"></i> Cetak Laporan
                    </button>
                </div>
            </div>
        </div>

        <div class="card card-body">
            <!-- Informasi Remunerasi Source -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama Source</th>
                                <td>{{ $remunerasi_source['nama_source'] }}</td>
                            </tr>
                            <tr>
                                <th>Total Klaim</th>
                                <td>Rp {{ $remunerasi_source['total_biaya'] }}</td>
                            </tr>
                            <tr>
                                <th>Total Remunerasi</th>
                                <td>Rp {{ $remunerasi_source['total_remunerasi'] }}</td>
                            </tr>
                            <tr>
                                <th>Persentase</th>
                                <td>{{ $remunerasi_source['persentase'] }}%</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tabel Dokter -->
            <div class="mb-4">
                <h5 class="text-primary mb-3">Dokter</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th width="10%">No</th>
                                <th width="30%">Nama PPA</th>
                                <th width="10%">Total Pasien Rajal</th>
                                <th width="10%">Total Pasien Ranap</th>
                                <th width="40%">Total Nominal Remunerasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_dokter as $kode_dokter => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['nama_ppa'] }}</td>
                                <td>{{ $data['total_pasien_rajal'] }}</td>
                                <td>{{ $data['total_pasien_ranap'] }}</td>
                                <td class="text-end">Rp {{ number_format($data['total_nominal_remunerasi'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold bg-light">
                                <td colspan="2" class="text-end">Total Dokter</td>
                                <td class="text-end">Rp {{ number_format($total_per_kategori['dokter'], 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Tabel Perawat -->
            <div class="mb-4">
                <h5 class="text-primary mb-3">Perawat</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th width="10%">No</th>
                                <th width="40%">Nama PPA</th>
                                <th width="50%">Total Nominal Remunerasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_perawat as $kode_dokter => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['nama_ppa'] }}</td>
                                <td class="text-end">Rp {{ number_format($data['total_nominal_remunerasi'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold bg-light">
                                <td colspan="2" class="text-end">Total Perawat</td>
                                <td class="text-end">Rp {{ number_format($total_per_kategori['perawat'], 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Tabel Struktural -->
            <div class="mb-4">
                <h5 class="text-primary mb-3">Struktural</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th width="10%">No</th>
                                <th width="40%">Nama PPA</th>
                                <th width="50%">Total Nominal Remunerasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_struktural as $kode_dokter => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['nama_ppa'] }}</td>
                                <td class="text-end">Rp {{ number_format($data['total_nominal_remunerasi'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold bg-light">
                                <td colspan="2" class="text-end">Total Struktural</td>
                                <td class="text-end">Rp {{ number_format($total_per_kategori['struktural'], 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Tabel JTL/Semua Pegawai -->
            <div class="mb-4">
                <h5 class="text-primary mb-3">Jasa Tidak Langsung (JTL)</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th width="10%">No</th>
                                <th width="40%">Nama PPA</th>
                                <th width="50%">Total Nominal Remunerasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_jtl as $kode_dokter => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data['nama_ppa'] }}</td>
                                <td class="text-end">Rp {{ number_format($data['total_nominal_remunerasi'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold bg-light">
                                <td colspan="2" class="text-end">Total JTL</td>
                                <td class="text-end">Rp {{ number_format($total_per_kategori['jtl'], 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Total Keseluruhan -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr class="fw-bold bg-primary text-white">
                                <td class="text-end" width="200">Total Keseluruhan</td>
                                <td class="text-end">Rp {{ $remunerasi_source['total_remunerasi'] }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .card-tools, .product-search, .btn-primary {
        display: none !important;
    }
    .table th, .table td {
        padding: 0.5rem;
        font-size: 12px;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,0,0,.05) !important;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
    .bg-primary {
        background-color: #0d6efd !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .text-white {
        color: white !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .table-bordered {
        border: 1px solid #dee2e6 !important;
    }
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6 !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Implementasi pencarian
    $('#input-search').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $("table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
@endpush

@endsection 