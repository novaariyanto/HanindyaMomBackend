@extends('root')
@section('title', 'Detail Admission')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Detail Admission',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('admission.list'), 'label' => 'Data Admission'],
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
                                    <td width="150">ID Admission</td>
                                    <td width="20">:</td>
                                    <td>{{ $admission->id_admission }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Pasien</td>
                                    <td>:</td>
                                    <td>{{ $admission->nama_pasien }}</td>
                                </tr>
                                <tr>
                                    <td>No. RM</td>
                                    <td>:</td>
                                    <td>{{ $admission->nomr }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150">Tanggal Masuk</td>
                                    <td width="20">:</td>
                                    <td>{{ date('d/m/Y', strtotime($admission->masukrs)) }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Keluar</td>
                                    <td>:</td>
                                    <td>{{ date('d/m/Y', strtotime($admission->keluarrs)) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!empty($ranapData))
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Billing Rawat Inap</h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordionRanap">
                        @foreach($ranapData as $key => $unit)
                            @if($key !== 'total_keseluruhan')
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#collapse{{ $key }}Ranap">
                                        <div class="d-flex justify-content-between w-100">
                                            <span>{{ $unit['nama'] }}</span>
                                            <span class="ms-auto">Rp {{ number_format($unit['total'], 0, ',', '.') }}</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse{{ $key }}Ranap" class="accordion-collapse collapse show">
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
                                                        <td>{{ date('d/m/Y', strtotime($item['TANGGAL'])) }}</td>
                                                        <td>{{ $item['nama_tindakan'] }}</td>
                                                        <td>{{ $item['NAMADOKTER'] }}</td>
                                                        <td>{{ $item['CARABAYAR'] }}</td>
                                                        <td class="text-end">{{ $item['QTY'] }}</td>
                                                        <td class="text-end">{{ number_format($item['TARIFRS'], 0, ',', '.') }}</td>
                                                        <td class="text-end">{{ number_format($item['TOTAL'], 0, ',', '.') }}</td>
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
                        <h5>Total Rawat Inap: <span class="text-primary">Rp {{ number_format($ranapData['total_keseluruhan'], 0, ',', '.') }}</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(!empty($rajalData))
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Billing Rawat Jalan</h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordionRajal">
                        @foreach($rajalData as $key => $unit)
                            @if($key !== 'total_keseluruhan')
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#collapse{{ $key }}Rajal">
                                        <div class="d-flex justify-content-between w-100">
                                            <span>{{ $unit['nama'] }}</span>
                                            <span class="ms-auto">Rp {{ number_format($unit['total'], 0, ',', '.') }}</span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse{{ $key }}Rajal" class="accordion-collapse collapse show">
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
                                                        <td>{{ date('d/m/Y', strtotime($item['TANGGAL'])) }}</td>
                                                        <td>{{ $item['nama_tindakan'] }}</td>
                                                        <td>{{ $item['NAMADOKTER'] }}</td>
                                                        <td>{{ $item['CARABAYAR'] }}</td>
                                                        <td class="text-end">{{ $item['QTY'] }}</td>
                                                        <td class="text-end">{{ number_format($item['TARIFRS'], 0, ',', '.') }}</td>
                                                        <td class="text-end">{{ number_format($item['TOTAL'], 0, ',', '.') }}</td>
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
                        <h5>Total Rawat Jalan: <span class="text-primary">Rp {{ number_format($rajalData['total_keseluruhan'], 0, ',', '.') }}</span></h5>
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
                        <a href="{{ route('admission.list') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                        <div class="text-end">
                            <h4>Total Keseluruhan: 
                                <span class="text-primary">
                                    Rp {{ number_format(
                                        ($ranapData['total_keseluruhan'] ?? 0) + 
                                        ($rajalData['total_keseluruhan'] ?? 0), 
                                        0, ',', '.'
                                    ) }}
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