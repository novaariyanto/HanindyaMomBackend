<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PegawaiMaster; // Model Pegawai
use App\Models\Presensi; // Model Absensi
use Carbon\Carbon;

class MonitoringAbsensiController extends Controller
{
    /**
     * Display a listing of employees and their attendance.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil parameter filter
            $divisiId = $request->input('divisi_id');
            $year = $request->input('year', Carbon::now()->year);
            $month = $request->input('month', Carbon::now()->month);

            // Generate semua tanggal di bulan ini
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
            $allDates = [];

            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $allDates[] = $date->format('Y-m-d');
            }

            // Query pegawai berdasarkan divisi (jika ada filter divisi)
            $query = PegawaiMaster::with(['presensi' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
            }]);

            if ($divisiId) {
                $query->where('divisi_id', $divisiId);
            }

            $pegawais = $query->get();

            // Format data untuk respons JSON
            $data = $pegawais->map(function ($pegawai) use ($allDates) {
                // Ambil absensi yang ada
                $existingAbsensi = $pegawai->presensi->keyBy('tanggal');

                // Buat array absensi dengan semua tanggal di bulan ini
                $absensi = collect($allDates)->map(function ($date) use ($existingAbsensi) {
                    $presensi = $existingAbsensi->get($date);

                    return [
                        'uuid' => $presensi?->uuid ?? '',
                        'tanggal' => $date,
                        'jam_masuk_jadwal' => $presensi?->jam_masuk_jadwal ?? '-',
                        'jam_masuk' => $presensi?->jam_masuk ?? '-',
                        'jam_keluar_jadwal' => $presensi?->jam_keluar_jadwal ?? '-',
                        'jam_keluar' => $presensi?->jam_keluar ?? '-',
                        'status' => $presensi?->status ?? '-',
                        'keterangan' => $presensi?->keterangan ?? '-',
                        'durasi_kerja_detik' => $presensi?->durasi_kerja_detik ?? 0,
                    ];
                });

                return [
                    'nama' => $pegawai->nama,
                    'nip' => $pegawai->nip,
                    'absensi' => $absensi,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200);
        }

        // Jika bukan AJAX, tampilkan view
        return view('pages.monitoring-absensi.index');
    }
    public function detail(Request $request)
    {
        $uuid = $request->uuid;
        // Cari data presensi berdasarkan UUID
        $presensi = Presensi::with(['pegawai', 'pegawaiShift.shift.jamKerja'])
            ->where('uuid', $uuid)
            ->firstOrFail();
    
        // Format data untuk ditampilkan di view
        $data = [
            'foto_wajah' => $presensi->pegawai->user->photo->path,
            'catatan' => $presensi->catatan,
            'nik' => $presensi->pegawai?->nik ?? '-',
            'nama' => $presensi->pegawai?->nama ?? '-',
            'tanggal' => $presensi->tanggal ? date('d-m-Y', strtotime($presensi->tanggal)) : '-',
        
'jam_masuk_jadwal' => $presensi->jam_masuk_jadwal 
? Carbon::parse($presensi->jam_masuk_jadwal)->translatedFormat('d F Y H:i') 
: '-',

'jam_masuk' => $presensi->jam_masuk 
? Carbon::parse($presensi->jam_masuk)->translatedFormat('d F Y H:i') 
: '-',

'jam_keluar_jadwal' => $presensi->jam_keluar_jadwal 
? Carbon::parse($presensi->jam_keluar_jadwal)->translatedFormat('d F Y H:i') 
: '-',

'jam_keluar' => $presensi->jam_keluar 
? Carbon::parse($presensi->jam_keluar)->translatedFormat('d F Y H:i') 
: '-',
            'status' => $presensi->status ?? '-',
            'keterangan' => $presensi->keterangan ?? '-',
            'longitude_masuk' => $presensi->longitude_masuk ?? '-',
            'latitude_masuk' => $presensi->latitude_masuk ?? '-',
            'longitude_keluar' => $presensi->longitude_keluar ?? '-',
            'latitude_keluar' => $presensi->latitude_keluar ?? '-',
            'divisi'=>$presensi->pegawai->divisi->nama
        ];
    
        return view('pages.monitoring-absensi.show', compact('data'));
    }

}