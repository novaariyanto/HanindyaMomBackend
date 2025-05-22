<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\PegawaiMaster;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanAbsensiController extends Controller
{
    //
    public function bulanan(){

        return view('pages.laporan.bulanan.index');
    }



    public function keterlambatan(){

        return view('pages.laporan.keterlambatan.index');
    }


    /**
     * Fungsi untuk mendapatkan data laporan absensi bulanan.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLaporanAbsensi(Request $request)
    {
        // Ambil parameter dari request
        $bulan = $request->input('month') ?? now()->month;
        $tahun = $request->input('year') ?? now()->year;
        $divisiId = $request->input('divisi_id');


        if (!$divisiId) {

            return response()->json([
                'success' => false,
                'data' => [],
                'divisi'=>''
            ]);

        }
        $divisi = Divisi::where('id',$divisiId)->first();

        // Query data pegawai dengan relasi absensi
        $query = PegawaiMaster::with(['absensi' => function ($q) use ($bulan, $tahun) {
            if ($bulan && $tahun) {
                $q->whereMonth('tanggal', $bulan)
                  ->whereYear('tanggal', $tahun);
            } elseif ($bulan) {
                $q->whereMonth('tanggal', $bulan);
            } elseif ($tahun) {
                $q->whereYear('tanggal', $tahun);
            }
        }]);

        // Filter berdasarkan divisi jika ada
        if ($divisiId) {
            $query->where('divisi_id', $divisiId);
        }

        $query->orderBy('nama','ASC');
        // Ambil data pegawai
        $pegawaiList = $query->get();

        // Proses data absensi untuk setiap pegawai
        $laporan = [];
        foreach ($pegawaiList as $index => $pegawai) {
            // Hitung statistik absensi
            $totalHadir = $pegawai->absensi
                ->whereIn('status', ['hadir', 'terlambat']) // Menghitung "hadir" dan "terlambat" sebagai satu total
                ->count();
            $totalTerlambat = $pegawai->absensi
                ->where('status', 'terlambat') // Tetap hitung terlambat secara terpisah
                ->count();
            $totalIzin = $pegawai->absensi
                ->where('status', 'izin')
                ->count();
            $totalAlpha = $pegawai->absensi
                ->where('status', 'alpha')
                ->count();
        
            // Hitung total jam kerja dari durasi_kerja_detik
            $totalDurasiDetik = $pegawai->absensi->sum('durasi_kerja_detik');
            $totalJamKerja = round($totalDurasiDetik / 3600, 2); // Konversi detik ke jam
        
            // Format total jam kerja
            $totalJamKerjaFormatted = $totalJamKerja > 0 ? $totalJamKerja . ' Jam' : '0 Jam';
        
            // Hitung total hari kerja
            $totalHariKerja = $pegawai->absensi->count();
        
            // Hitung persentase kehadiran
            $persentaseKehadiran = $totalHariKerja > 0 
                ? round(($totalHadir / $totalHariKerja) * 100, 2) 
                : 0;
        
            // Tambahkan data ke laporan
            $laporan[] = [
                'no' => $index + 1,
                'nama_pegawai' => $pegawai->nama,
                'total_hadir' => $totalHadir, // Termasuk "hadir" dan "terlambat"
                'total_terlambat' => $totalTerlambat, // Hanya terlambat
                'total_izin' => $totalIzin,
                'total_alpha' => $totalAlpha,
                'total_jam_kerja' => $totalJamKerjaFormatted, // Ganti total lembur dengan total jam kerja
                'persentase_kehadiran' => $persentaseKehadiran . '%',
            ];
        }

        // Kembalikan respons JSON
        return response()->json([
            'success' => true,
            'data' => $laporan,
            'divisi'=>$divisi? $divisi->nama :null
        ]);
    }


public function printPdf(Request $request)
{
    // Ambil parameter dari request
    $bulan = $request->input('month') ?? now()->month;
    $tahun = $request->input('year') ?? now()->year;
    $divisiId = $request->input('divisi_id');

    // Panggil metode getLaporanAbsensi untuk mendapatkan data
    $response = $this->getLaporanAbsensi($request);

    if (!$response->getData()->success) {
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    $data = $response->getData();
    $laporan = json_decode(json_encode($data->data), true);

    $divisi = $data->divisi;

    // Generate nama bulan dalam bahasa Indonesia
    $bulanNama = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    $periode = $bulanNama[$bulan - 1] . ' ' . $tahun;

    // return $laporan;
    // Kirim data ke view PDF
    $pdf = Pdf::loadView('pages.laporan.bulanan.pdf', [
        'laporan' => $laporan,
        'divisi' => $divisi,
        'periode' => $periode,
    ]);

    // Set ukuran kertas dan orientasi
    $pdf->setPaper('A4', 'landscape');

    // Unduh atau tampilkan PDF
    return $pdf->stream('laporan_absensi_' . $periode . '.pdf');
}


public function getLaporanKeterlambatan(Request $request)
{
    // Ambil parameter dari request
    $bulan = $request->input('month') ?? now()->month;
    $tahun = $request->input('year') ?? now()->year;
    $divisiId = $request->input('divisi_id');

    // Query data pegawai dengan relasi absensi
    $query = PegawaiMaster::with(['absensi' => function ($q) use ($bulan, $tahun) {
        if ($bulan && $tahun) {
            $q->whereMonth('tanggal', $bulan)
              ->whereYear('tanggal', $tahun);
        } elseif ($bulan) {
            $q->whereMonth('tanggal', $bulan);
        } elseif ($tahun) {
            $q->whereYear('tanggal', $tahun);
        }
    }]);

    // Filter berdasarkan divisi jika ada
    if ($divisiId) {
        $query->where('divisi_id', $divisiId);
    }

    // Ambil data pegawai
    $pegawaiList = $query->get();

    // Proses data absensi untuk setiap pegawai
    $laporan = [];
    foreach ($pegawaiList as $index => $pegawai) {
        // Hitung statistik absensi
        $totalHariKerja = $pegawai->absensi->count();
        $totalTerlambat = $pegawai->absensi->where('status', 'terlambat')->count();
        $totalPulangCepat = $pegawai->absensi->whereNotNull('pulang_cepat_detik')->count();

        // Hitung total durasi keterlambatan dan pulang cepat (dalam detik)
        $totalDurasiTerlambatDetik = $pegawai->absensi
            ->where('status', 'terlambat')
            ->sum('terlambat_detik');
        $totalDurasiPulangCepatDetik = $pegawai->absensi
            ->sum('pulang_cepat_detik');

        // Konversi durasi ke menit
        $rataRataKeterlambatan = $totalTerlambat > 0 ? round($totalDurasiTerlambatDetik / $totalTerlambat / 60) : 0;
        $rataRataPulangCepat = $totalPulangCepat > 0 ? round($totalDurasiPulangCepatDetik / $totalPulangCepat / 60) : 0;

        // Total jam kerja berkurang
        $totalJamKerjaBerkurangDetik = $totalDurasiTerlambatDetik + $totalDurasiPulangCepatDetik;
        $totalJamKerjaBerkurangFormatted = gmdate('H \J\a\m i \M\e\n\i\t', $totalJamKerjaBerkurangDetik);

        // Tambahkan data ke laporan
        $laporan[] = [
            'no' => $index + 1,
            'nama_pegawai' => $pegawai->nama,
            'total_hari_kerja' => $totalHariKerja,
            'total_terlambat' => $totalTerlambat,
            'rata_rata_keterlambatan' => $rataRataKeterlambatan . ' Menit',
            'total_pulang_cepat' => $totalPulangCepat,
            'rata_rata_pulang_cepat' => $rataRataPulangCepat . ' Menit',
            'total_jam_kerja_berkurang' => $totalJamKerjaBerkurangFormatted,
        ];
    }

    // Kembalikan respons JSON
    return response()->json([
        'success' => true,
        'data' => $laporan,
        'periode' => Carbon::createFromDate($tahun, $bulan)->translatedFormat('F Y'),
        'divisi' => Divisi::find($divisiId)?->nama ?? 'Semua Divisi',
    ]);
}


}

