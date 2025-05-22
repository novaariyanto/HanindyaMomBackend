@extends('root')
@section('title', 'Detail Source Remunerasi')

@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Detail Source Remunerasi',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('remunerasi-source.index'), 'label' => 'Remunerasi Source'],
        ],
        'current' => 'Detail Source'
    ])
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Detail Source: {{ $source->nama_source }}</h5>
                   
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Nama Source</th>
                                <td>{{ $source->nama_source }}</td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>{{ $source->keterangan }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($source->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Batch</th>
                                <td>{{ $source->batch->nama_batch }} ({{ $source->batch->tahun }})</td>
                            </tr>
                            <tr>
                                <th>No SEP</th>
                                <td>{{ $source->no_sep }}</td>
                            </tr>
                            <tr>
                                <th>IDX Daftar</th>
                                <td>{{ $source->idxdaftar }}</td>
                            </tr>
                            <tr>
                                <th>NOMR</th>
                                <td>{{ $source->nomr }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 