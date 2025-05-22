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

            @foreach($data as $cluster => $clusterData)
            <div class="mb-4">
                <h5 class="text-primary mb-3">{{ $cluster_names[$cluster] }}</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th width="10%">No</th>
                                <th width="25%">Nama</th>
                                <th width="20%">PPA</th>
                                <th width="20%">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clusterData['detail']->groupBy('nama_ppa') as $nama_ppa => $details)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $nama_ppa }}</td>
                                <td>{{ str_contains($details->first()['ppa'], "DOKTERHDRANAP")||str_contains($details->first()['ppa'], "DPJP") || str_contains($details->first()['ppa'], "DOKTERRABER") ? 'DPJP' : $details->first()['ppa'] }}</td>
                                <td class="text-end">{{ number_format($details->sum('nilai_remunerasi'), 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold bg-light">
                                <td colspan="3" class="text-end">Total {{ $cluster_names[$cluster] }}</td>
                                <td class="text-end">{{ number_format($total_per_cluster[$cluster], 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endforeach

            <!-- Total Keseluruhan -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr class="fw-bold bg-primary text-white">
                                <td class="text-end" width="200">Total Keseluruhan</td>
                                <td class="text-end">Rp {{ number_format($total_keseluruhan, 0, ',', '.') }}</td>
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