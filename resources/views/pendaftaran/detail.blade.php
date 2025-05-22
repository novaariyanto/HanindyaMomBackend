@extends('root')
@section('title', 'Detail Pendaftaran')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Detail Pendaftaran',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('pendaftaran.list'), 'label' => 'Data Pendaftaran'],
        ],
        'current' => 'Detail'
    ])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Pasien</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150">ID Pendaftaran</td>
                                    <td width="20">:</td>
                                    <td>{{ $pendaftaran->IDXDAFTAR }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Pasien</td>
                                    <td>:</td>
                                    <td>{{ $pendaftaran->pasien->NAMA ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>No. RM</td>
                                    <td>:</td>
                                    <td>{{ $pendaftaran->NOMR }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150">Tanggal Registrasi</td>
                                    <td width="20">:</td>
                                    <td>{{ date('d/m/Y', strtotime($pendaftaran->TGLREG)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($billData['units']))
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Billing</h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordionBilling">
                        @foreach($billData['units'] as $key => $unit)
                            @if(!empty($unit['data']))
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#collapse{{ $key }}">
                                        <div class="d-flex justify-content-between w-100">
                                            <span>{{ $unit['nama'] }}</span>
                                            <span class="ms-auto">Rp {{ number_format($unit['total'], 0, ',', '.') }}</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse{{ $key }}" class="accordion-collapse collapse show">
                                    <div class="accordion-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Tindakan</th>
                                                        <th>Dokter</th>
                                                        <th>Cara Bayar</th>
                                                        <th class="text-end">Qty</th>
                                                        <th class="text-end">Tarif (Rp)</th>
                                                        <th class="text-end">Total (Rp)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($unit['data'] as $item)
                                                    <tr>
                                                        <td>{{ date('d/m/Y', strtotime($item->TANGGAL)) }}</td>
                                                        <td>{{ $item->nama_tindakan }}</td>
                                                        <td>{{ $item->NAMADOKTER }}</td>
                                                        <td>{{ $item->CARABAYAR }}</td>
                                                        <td class="text-end">{{ $item->QTY }}</td>
                                                        <td class="text-end">{{ number_format($item->TARIFRS, 0, ',', '.') }}</td>
                                                        <td class="text-end">{{ number_format($item->TOTAL, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="6" class="text-end fw-bold">Total {{ $unit['nama'] }}</td>
                                                        <td class="text-end fw-bold">{{ number_format($unit['total'], 0, ',', '.') }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="text-end mt-3">
                        <h5>Total Keseluruhan: <span class="text-primary">Rp {{ number_format($billData['total_keseluruhan'], 0, ',', '.') }}</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row mt-4 mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('pendaftaran.list') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                        <div class="text-end">
                            <h4>Total Tarif RS: 
                                <span class="text-primary">
                                    Rp {{ number_format($totalTarifRs, 0, ',', '.') }}
                                </span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 