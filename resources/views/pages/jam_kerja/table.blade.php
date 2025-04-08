
<style>
    /* Atur agar tabel menggunakan layout tetap */
.table {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
}

/* Atur lebar kolom pertama (Nama Divisi) */
.table th:first-child,
.table td:first-child {
    width: 200px;
    min-width: 200px;
    max-width: 200px;
    text-align: left;
    padding: 8px;
}

/* Atur lebar kolom shift dan keterangan */
.table th:nth-child(2),
.table td:nth-child(2),
.table th:nth-child(3),
.table td:nth-child(3) {
    width: 150px;
    min-width: 150px;
    max-width: 150px;
    text-align: center;
}

/* Atur lebar kolom hari secara proporsional */
.table th,
.table td {
    text-align: center;
    padding: 8px;
    border: 1px solid #ddd;
    word-wrap: break-word;
}

/* Gaya untuk hari Minggu */
    
/* Tambahkan efek hover untuk baris */
.table tbody tr:hover {
    background-color: #f1f1f1;
}

/* Header tabel */
.table thead th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

/* Warna latar belakang merah jika tidak ada jadwal */
.bg-danger {
    background-color: #f8d7da !important;   
    color: #721c24 !important;
}

/* Responsif untuk layar kecil */
@media (max-width: 768px) {
    .table {
        font-size: 12px;
    }
    .table th:first-child,
    .table td:first-child {
        width: 150px;
        min-width: 150px;
        max-width: 150px;
    }
}

</style>
<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2">NAMA DIVISI</th>
            <th rowspan="2">SHIFT</th>
            <th rowspan="2">KETERANGAN</th>
            <th colspan="7"><center>JAM KERJA</center></th>
            @if (!Request::get('action'))

            <th rowspan="2" colspan="2">
                <center>OPSI</center>
            </th>
            @endif
        </tr>
        <tr>
            <th>Senin</th>
            <th>Selasa</th>
            <th>Rabu</th>
            <th>Kamis</th>
            <th>Jumat</th>
            <th>Sabtu</th>
            <th>Minggu</th>
        </tr>
    </thead>
    <tbody >
      

@foreach ($divisis as $divisi)
    @if ($divisi->shifts->isEmpty())
        <!-- Jika tidak ada shift -->
        <tr>
            <td>{{ $divisi->nama }}</td>
            <td>-</td>
            <td>{{ $divisi->keterangan ?? '-' }}</td>
            <td colspan="7" class="text-center">-</td>
            <td>
                
            </td>
            <td>
                <button data-url="{{ route('jam-kerja.create', ['divisi_id' => $divisi->id]) }}" class="btn btn-primary btn-create">+</button>
            </td>
        </tr>
    @else
        <!-- Jika ada shift -->
        @foreach ($divisi->shifts as $index => $shift)
            <tr>
                @if ($index === 0)
                    <td rowspan="{{ $divisi->shifts->count() }}">{{ $divisi->nama }}</td>
                @endif
                <td>{{ $shift->nama_shift }} ({{ $shift->kode_shift }})</td>
                <td>{{ $shift->keterangan ?? '-' }}</td>
                <!-- Jam Kerja -->
                @php
                    $jamKerja = $shift->jamKerja->first();
                    $hariMapping = [
                        'senin' => ['masuk' => 'senin_masuk', 'pulang' => 'senin_pulang'],
                        'selasa' => ['masuk' => 'selasa_masuk', 'pulang' => 'selasa_pulang'],
                        'rabu' => ['masuk' => 'rabu_masuk', 'pulang' => 'rabu_pulang'],
                        'kamis' => ['masuk' => 'kamis_masuk', 'pulang' => 'kamis_pulang'],
                        'jumat' => ['masuk' => 'jumat_masuk', 'pulang' => 'jumat_pulang'],
                        'sabtu' => ['masuk' => 'sabtu_masuk', 'pulang' => 'sabtu_pulang'],
                        'minggu' => ['masuk' => 'minggu_masuk', 'pulang' => 'minggu_pulang'],
                    ];
                @endphp
                @foreach ($hariMapping as $hari => $kolom)
                    <td class="{{ empty($jamKerja->{$kolom['masuk']}) && empty($jamKerja->{$kolom['pulang']}) ? 'bg-danger' : '' }}">
                        @if (!empty($jamKerja->{$kolom['masuk']}))
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $jamKerja->{$kolom['masuk']})->format('H:i') }}
                        @else
                            
                        @endif
                        
                        @if (!empty($jamKerja->{$kolom['pulang']}))
                        -
                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $jamKerja->{$kolom['pulang']})->format('H:i') }}
                        @else
                            
                        @endif
                    </td>
                @endforeach
                @if (!Request::get('action'))

                <td>
                    <a data-modal="large" data-url="{{ route('shift.show', $shift->uuid) }}" class="btn btn-warning btn-sm btn-create">
                        <i class="ti ti-clock"></i>
                    </a>
                    <button data-url="{{ route('jam-kerja.destroy', $shift->pivot->uuid) }}" class="btn-delete btn btn-sm btn-danger">
                        <i class="ti ti-trash"></i>
                    </button>
                </td>
                @endif
                @if ($index === 0)
                @if (!Request::get('action'))
                    
                    <td rowspan="{{ $divisi->shifts->count() }}" style="vertical-align: middle">
                        <button data-url="{{ route('jam-kerja.create', ['divisi_id' => $divisi->id]) }}" class="btn btn-primary btn-create">+</button>
                    </td>
                @endif
                @endif

            </tr>
        @endforeach
    @endif
@endforeach

    </tbody>
</table>
