@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Pembagian Klaim</h4>
                </div>
                <div class="card-body">
                    <!-- Data Pembagian Klaim -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary">Informasi Pembagian Klaim</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="200">Tanggal</th>
                                        <td>{{ $data->tanggal_formatted }}</td>
                                    </tr>
                                    <tr>
                                        <th>Groups</th>
                                        <td>{{ $data->groups }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis</th>
                                        <td>{{ $data->jenis }}</td>
                                    </tr>
                                    <tr>
                                        <th>Grade</th>
                                        <td>{{ $data->grade }}</td>
                                    </tr>
                                    <tr>
                                        <th>PPA</th>
                                        <td>{{ $data->ppa }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama PPA</th>
                                        <td>{{ $data->nama_ppa }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kode Dokter</th>
                                        <td>{{ $data->kode_dokter }}</td>
                                    </tr>
                                    <tr>
                                        <th>Value</th>
                                        <td>{{ $data->value_formatted }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sumber</th>
                                        <td>{{ $data->sumber }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nilai Sumber</th>
                                        <td>Rp {{ $data->sumber_value_formatted }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nilai Remunerasi</th>
                                        <td>Rp {{ $data->nilai_remunerasi_formatted }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="200">No. SEP</th>
                                        <td>{{ $data->sep }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cluster</th>
                                        <td>{{ $data->cluster_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Index Daftar</th>
                                        <td>{{ $data->idxdaftar }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. RM</th>
                                        <td>{{ $data->nomr }}</td>
                                    </tr>
                                    @if($data->detailSource)
                                    <tr>
                                        <th>Biaya Disetujui</th>
                                        <td>Rp {{ $data->detailSource->biaya_disetujui_formatted }}</td>
                                    </tr>
                                    <tr>
                                        <th>Biaya Riil RS</th>
                                        <td>Rp {{ $data->detailSource->biaya_riil_rs_formatted }}</td>
                                    </tr>
                                    <tr>
                                        <th>Selisih</th>
                                        <td>Rp {{ $data->detailSource->selisih_formatted }}</td>
                                    </tr>
                                    <tr>
                                        <th>Persentase Selisih</th>
                                        <td>{{ $data->detailSource->persentase_selisih }}%</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Data Remunerasi Source -->
                    @if($data->detailSource && $data->detailSource->remunerasiSource)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="text-primary">Informasi Remunerasi Source</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="200">No. Admission</th>
                                        <td>{{ $data->detailSource->remunerasiSource->admission_id }}</td>
                                        <th width="200">No. RM</th>
                                        <td>{{ $data->detailSource->remunerasiSource->no_rm }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Pasien</th>
                                        <td>{{ $data->detailSource->remunerasiSource->nama_pasien }}</td>
                                        <th>Kelas</th>
                                        <td>{{ $data->detailSource->remunerasiSource->kelas }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Masuk</th>
                                        <td>{{ $data->detailSource->remunerasiSource->tgl_masuk ? $data->detailSource->remunerasiSource->tgl_masuk->format('d/m/Y H:i') : '-' }}</td>
                                        <th>Tanggal Keluar</th>
                                        <td>{{ $data->detailSource->remunerasiSource->tgl_keluar ? $data->detailSource->remunerasiSource->tgl_keluar->format('d/m/Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Biaya</th>
                                        <td>Rp {{ number_format($data->detailSource->remunerasiSource->total_biaya, 2, ',', '.') }}</td>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge bg-{{ $data->detailSource->remunerasiSource->status == 1 ? 'success' : 'warning' }}">
                                                {{ $data->detailSource->remunerasiSource->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <a href="{{ route('pembagian-klaim.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Kembali
                            </a>
                            <a href="#" class="btn btn-info btn-edit" data-url="{{ route('pembagian-klaim.show', $data->id) }}">
                                <i class="ti ti-pencil"></i> Edit
                            </a>
                            <a href="#" class="btn btn-danger btn-delete" data-url="{{ route('pembagian-klaim.destroy', $data->id) }}">
                                <i class="ti ti-trash"></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle delete button
  
});
</script>
@endpush

@push('styles')
<style>
.text-primary {
    color: #435ebe !important;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #dee2e6;
}

.badge {
    padding: 0.5em 1em;
    font-size: 0.875em;
}

.table th {
    background-color: #f8f9fa;
}
</style>
@endpush

@endsection 