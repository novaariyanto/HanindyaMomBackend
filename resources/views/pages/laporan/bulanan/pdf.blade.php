<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .mb-20 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Laporan Absensi Bulanan Pegawai</h1>
    <h2>{{ $divisi ? "Divisi: $divisi" : 'Semua Divisi' }}</h2>
    <p class="text-center mb-20">Periode: {{ $periode }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Total Hadir</th>
                <th>Total Terlambat</th>
                <th>Total Izin</th>
                <th>Total Alpha</th>
                <th>Total Jam Kerja</th>
                <th>Persentase Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $item)
            <tr>
                <td>{{ $item['no'] }}</td>
                <td>{{ $item['nama_pegawai'] }}</td>
                <td>{{ $item['total_hadir'] }}</td>
                <td>{{ $item['total_terlambat'] }}</td>
                <td>{{ $item['total_izin'] }}</td>
                <td>{{ $item['total_alpha'] }}</td>
                <td>{{ $item['total_jam_kerja'] }}</td>
                <td>{{ $item['persentase_kehadiran'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>