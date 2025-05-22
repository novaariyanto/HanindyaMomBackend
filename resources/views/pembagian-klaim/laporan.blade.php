@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Laporan Pembagian Klaim</h4>
                    <div class="card-tools">
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="ti ti-printer"></i> Cetak
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($data as $cluster => $clusterData)
                    <div class="mb-4">
                        <h5 class="text-primary">{{ $cluster_names[$cluster] }}</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="align-middle">Nama</th>
                                        <th colspan="5" class="text-center">Detail Pembagian</th>
                                        <th rowspan="2" class="align-middle">Total</th>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>PPA</th>
                                        <th>Sumber</th>
                                        <th>Value</th>
                                        <th>Nilai Sumber</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clusterData as $nama => $dokterData)
                                    <tr>
                                        <td rowspan="{{ count($dokterData['detail']) }}" class="align-middle">
                                            {{ $nama }}
                                        </td>
                                        @foreach($dokterData['detail'] as $index => $detail)
                                            @if($index > 0)
                                                <tr>
                                            @endif
                                            <td>{{ $detail['tanggal'] }}</td>
                                            <td>{{ $detail['ppa'] }}</td>
                                            <td>{{ $detail['sumber'] }}</td>
                                            <td class="text-end">{{ number_format($detail['value'], 4, ',', '.') }}</td>
                                            <td class="text-end">Rp {{ number_format($detail['sumber_value'], 2, ',', '.') }}</td>
                                            <td class="text-end">Rp {{ number_format($detail['nilai_remunerasi'], 2, ',', '.') }}</td>
                                            @if($index == 0)
                                                <td rowspan="{{ count($dokterData['detail']) }}" class="align-middle text-end">
                                                    Rp {{ number_format($dokterData['total_nilai'], 2, ',', '.') }}
                                                </td>
                                            @endif
                                            @if($index > 0)
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="fw-bold">
                                        <td colspan="6" class="text-end">Total {{ $cluster_names[$cluster] }}</td>
                                        <td class="text-end">Rp {{ number_format($total_per_cluster[$cluster], 2, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .card-tools {
        display: none;
    }
    .table th, .table td {
        padding: 0.5rem;
        font-size: 12px;
    }
}
</style>
@endpush

@endsection 