@extends('root')
@section('title', 'Detail Pegawai')
@section('content')
<div class="container-fluid">
    @include('components.breadcrumb', [
        'title' => 'Detail Pegawai',
        'links' => [
            ['url' => route('dashboard'), 'label' => 'Dashboard'],
            ['url' => route('pegawai-master.index'), 'label' => 'Data Pegawai'],
        ],
        'current' => 'Detail Pegawai'
    ])
    
    <div class="card card-body">
        <div class="row">
            <div class="col-md-12">
                <h4 class="mb-3">Informasi Pegawai</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <!-- Foto -->
                                <td rowspan="6" class="text-center align-middle" style="width: 40%;">
                                    
                                    <img src="{{ asset('storage/' . ($pegawaiMaster->user->photo->path ?? 'default.png')) }}" 
                                         alt="Foto Pegawai" class="img-thumbnail" style="width: 100%;">
                                </td>
                                <!-- NIK -->
                                <th>NIK</th>
                                <td>{{ $pegawaiMaster->nik }}</td>
                            </tr>
                            <tr>
                                <th>Nama Pegawai</th>
                                <td>{{ $pegawaiMaster->nama }}</td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>{{ $pegawaiMaster->jabatan->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Divisi</th>
                                <td>{{ $pegawaiMaster->divisi->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nomor HP</th>
                                <td>{{ $pegawaiMaster->user->username ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ ucfirst($pegawaiMaster->status) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="d-flex gap-2">
                    <a data-url="{{ route('pegawai-master.edit', $pegawaiMaster->uuid) }}" class="btn btn-warning d-flex align-items-center btn-create">
                        <i class="ti ti-edit me-1 fs-5"></i> Edit
                    </a>
                 
                </div>
            </div>
        </div>
    </div>

    <!-- Tab untuk Informasi Tambahan -->
    <div class="card card-body mt-4">
        <ul class="nav nav-tabs" id="infoTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="absensi-tab" data-bs-toggle="tab" data-bs-target="#absensi" type="button" role="tab" aria-controls="absensi" aria-selected="true">Absensi</button>
            </li>
            <!-- Tambahkan tab lain jika diperlukan -->
        </ul>
        <div class="tab-content" id="infoTabsContent">
            <div class="tab-pane fade show active" id="absensi" role="tabpanel" aria-labelledby="absensi-tab">
                <div class="table-responsive mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pegawaiMaster->absensi === null || $pegawaiMaster->absensi->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data absensi</td>
                            </tr>
                        @else
                            @foreach ($pegawaiMaster->absensi as $absen)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ ucfirst($absen->status) }}</td>
                                    <td>{{ $absen->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection