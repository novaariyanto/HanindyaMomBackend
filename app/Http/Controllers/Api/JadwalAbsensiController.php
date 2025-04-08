<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PegawaiMaster;
use App\Models\PegawaiShift;
use App\Models\Presensi;
use App\Models\Radius;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class JadwalAbsensiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = $request->user();
        $pegawai = $user->pegawai;
        if (!$pegawai) {
            return response()->json(['message' => 'Data pegawai tidak ditemukan.'], 404);
        }
    
        // Ambil tanggal hari ini
        $tgl = $request->tgl;
        $today = now()->toDateString();
    
        if ($tgl) {
            $today = $tgl;
        }

        $user = User::find($user->id);
        // return $user;
        if ($user->key!==$request->key) {
            # code...
            return response()->json(['message' => 'Mohon Maaf, Pengguna sudah masuk di perangkat lain.'], 403);

        }
    
        // Ambil radius terbaru
        $radius = Radius::latest()->first();
    
        // Cek apakah ada presensi terakhir yang belum memiliki jam_keluar
        $presensiTerakhir = Presensi::where('pegawai_id', $pegawai->id)
            ->whereNull('jam_keluar') // Filter hanya jika jam_keluar masih kosong
            ->orderBy('tanggal', 'desc') // Urutkan berdasarkan tanggal terbaru
            ->first();
    
        // Jika ada presensi terakhir tanpa jam_keluar, gunakan tanggal dari presensi tersebut
        if ($presensiTerakhir) {
            $today = $presensiTerakhir->tanggal; // Gunakan tanggal dari presensi terakhir
        }
    
        // Ambil jadwal absensi berdasarkan pegawai_id dan tanggal yang sudah ditentukan
        $jadwalAbsensi = PegawaiShift::with('shift.jamKerja')
            ->where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $today) // Cari shift pada tanggal yang sudah ditentukan
            ->first();
    
        // Mapping hari ke bahasa Indonesia
        $hariMapping = [
            'monday' => 'senin',
            'tuesday' => 'selasa',
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu',
        ];
    
        // Dapatkan hari dalam bahasa Indonesia
        $currentDay = strtolower(Carbon::parse($today)->format('l')); // Hari dari tanggal shift
        $currentDayIndonesia = $hariMapping[$currentDay] ?? null;
    
        // Data shift (default jika jadwal absensi kosong)
        $shiftData = [
            'id' => '',
            'nama_shift' => '',
            'kode_shift' => '',
            'jam_masuk' => '',
            'jam_pulang' => '',
            'mulai_jam_masuk' => '',
            'selesai_jam_masuk' => '',
            'mulai_jam_pulang' => '',
            'selesai_jam_pulang' => '',
        ];
    
        // Jika jadwal absensi ditemukan, isi data shift
        if ($jadwalAbsensi) {
            // Ambil jam kerja untuk hari ini
            $jamKerja = $jadwalAbsensi->shift->jamKerja->first();


if ($jamKerja) {
    // Ambil jam masuk dan jam pulang dari $jamKerja berdasarkan hari saat ini
    $jamMasuk = Carbon::createFromFormat('H:i:s', $jamKerja->{$currentDayIndonesia . '_masuk'});
    $jamPulang = Carbon::createFromFormat('H:i:s', $jamKerja->{$currentDayIndonesia . '_pulang'});
    $shift = $jadwalAbsensi->shift;

    // Jika shift malam (jam pulang lebih kecil dari jam masuk), tambahkan 1 hari ke jam_pulang
    if ($jamPulang->lt($jamMasuk)) {
        $jamPulang->addDay();
    }

    // Ambil toleransi terlambat dan waktu absen dari shift
    $toleransiTerlambat = $shift->toleransi_terlambat;
    $waktu_mulai_masuk  = $shift->waktu_mulai_masuk;
    $waktu_akhir_masuk  = $shift->waktu_akhir_masuk;
    $waktu_mulai_keluar = $shift->waktu_mulai_keluar;
    $waktu_akhir_keluar = $shift->waktu_akhir_keluar;

    // Hitung rentang waktu absen
    $mulaiJamMasuk = $jamMasuk->copy()->addMinutes($waktu_mulai_masuk); // Jam masuk + offset mulai
    $selesaiJamMasuk = $jamMasuk->copy()->addMinutes($waktu_akhir_masuk); // Jam masuk + offset akhir
    $mulaiJamPulang = $jamPulang->copy()->addMinutes($waktu_mulai_keluar); // Jam pulang + offset mulai
    $selesaiJamPulang = $jamPulang->copy()->addMinutes($waktu_akhir_keluar); // Jam pulang + offset akhir

    // Update data shift
    $shiftData = [
        'id' => $jadwalAbsensi->shift->id,
        'nama_shift' => $jadwalAbsensi->shift->nama_shift,
        'kode_shift' => $jadwalAbsensi->shift->kode_shift,
        'jam_masuk' => $jamMasuk->format('H:i'),
        'jam_pulang' => $jamPulang->format('H:i'),
        'mulai_jam_masuk' => $mulaiJamMasuk->format('H:i'),
        'selesai_jam_masuk' => $selesaiJamMasuk->format('H:i'),
        'mulai_jam_pulang' => $mulaiJamPulang->format('H:i'),
        'selesai_jam_pulang' => $selesaiJamPulang->format('H:i'),
    ];
}
        }
    
        // Cek apakah sudah ada presensi masuk untuk hari ini
        $presensiMasuk = Presensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $today)
            ->whereNotNull('jam_masuk') // Filter hanya jika jam_masuk terisi
            ->first();
    
        // Cek apakah sudah ada presensi keluar untuk hari ini
        $presensiKeluar = Presensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $today)
            ->whereNotNull('jam_keluar') // Filter hanya jika jam_keluar terisi
            ->first();
    
        // Hitung ringkasan absensi untuk bulan ini
        $bulanIni = now()->startOfMonth();
        $presensiBulanIni = Presensi::where('pegawai_id', $pegawai->id)
            ->whereMonth('tanggal', $bulanIni->month)
            ->whereYear('tanggal', $bulanIni->year)
            ->get();
    
        $summary = [
            'hadir' => $presensiBulanIni->whereNotNull('jam_masuk')->count(), // Jika ada jam_masuk, dihitung sebagai hadir
            'terlambat' => $presensiBulanIni->where('status', 'terlambat')->count(),
            'izin' => $presensiBulanIni->where('status', 'izin')->count(),
            'sakit' => $presensiBulanIni->where('status', 'sakit')->count(),
            'alpha' => $presensiBulanIni->where('status', 'alpha')->count(),
        ];
    
        // Format data untuk response
        $data = [
            'id' => $pegawai->id,
            'nama' => $pegawai->nama,
            'nik' => $pegawai->nik,
            'nomor_hp' => $user->username,
            'tanggal' => $today,
            'hari' => ucfirst($currentDayIndonesia), // Nama hari dalam bahasa Indonesia
            'shift' => $shiftData, // Data shift (default jika kosong)
            'presensi' => [
                'id_presensi' => $presensiMasuk?->id ?? null, // ID presensi masuk jika ada
                'status_masuk' => $presensiMasuk ? 'Sudah Masuk' : 'Belum Masuk',
                'status_keluar' => $presensiKeluar ? 'Sudah Keluar' : 'Belum Keluar',
                'jam_presensi_masuk' => $presensiMasuk?->jam_masuk ?? null,
                'jam_presensi_keluar' => $presensiKeluar?->jam_keluar ?? null,
                'longitude_masuk' => $presensiMasuk?->longitude_masuk ?? null,
                'latitude_masuk' => $presensiMasuk?->latitude_masuk ?? null,
                'longitude_keluar' => $presensiKeluar?->longitude_keluar ?? null,
                'latitude_keluar' => $presensiKeluar?->latitude_keluar ?? null,
            ],
            'radius' => $radius,
            'summary_absensi' => $summary, // Ringkasan absensi bulan ini
        ];
    
        return response()->json([
            'message' => 'Data jadwal absensi berhasil dimuat.',
            'data' => $data,
        ], 200);
    }
    /**
     * Tampilkan jadwal absensi pengguna yang sedang login.
     */
    public function jadwal(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = $request->user();

        // Cari data pegawai terkait dengan pengguna
        $pegawai = $user->pegawai;

        if (!$pegawai) {
            return response()->json(['message' => 'Data pegawai tidak ditemukan.'], 404);
        }

        // Validasi input filter tanggal
        $validator = Validator::make($request->all(), [
            'tanggal_mulai' => 'nullable|date', // Opsional, format: YYYY-MM-DD
            'tanggal_akhir' => 'nullable|date', // Opsional, format: YYYY-MM-DD
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Set default tanggal pertama dan terakhir bulan ini jika parameter kosong
        $tanggalMulai = $request->input('tanggal_mulai') ?? Carbon::now()->startOfMonth()->toDateString();
        $tanggalAkhir = $request->input('tanggal_akhir') ?? Carbon::now()->endOfMonth()->toDateString();

        // Query jadwal absensi berdasarkan pegawai_id dan filter tanggal
        $query = PegawaiShift::with('shift.jamKerja')
            ->where('pegawai_id', $pegawai->id);

        // Filter berdasarkan range tanggal
        $query->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        $query->orderBy('tanggal','ASC');

        // Ambil hasil query
        $jadwalAbsensiList = $query->get();

        // Mapping hari ke bahasa Indonesia
        $hariMapping = [
            'monday' => 'senin',
            'tuesday' => 'selasa',
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu',
        ];

        // Format data untuk response
        $data = $jadwalAbsensiList->map(function ($jadwalAbsensi) use ($hariMapping) {
            // Dapatkan nama hari dalam bahasa Indonesia
            $currentDay = strtolower(now()->parse($jadwalAbsensi->tanggal)->format('l')); // Format hari menjadi lowercase
            $currentDayIndonesia = $hariMapping[$currentDay] ?? null;

            // Ambil jam kerja untuk hari ini
            $jamKerja = $jadwalAbsensi->shift->jamKerja->first();

            return [
                'id' => $jadwalAbsensi->id,
                'tanggal' => $jadwalAbsensi->tanggal,
                'hari' => ucfirst($currentDayIndonesia), // Nama hari dalam bahasa Indonesia
                'shift' => [
                    'nama_shift' => $jadwalAbsensi->shift->nama_shift,
                    'kode_shift' => $jadwalAbsensi->shift->kode_shift,
                    'jam_masuk' => $jamKerja->{$currentDayIndonesia . '_masuk'} ?? null,
                    'jam_pulang' => $jamKerja->{$currentDayIndonesia . '_pulang'} ?? null,
                ],
            ];
        });

        return response()->json([
            'message' => 'Data jadwal absensi bulan ini berhasil dimuat.',
            'data' => $data,
        ], 200);
    }


    public function historyAbsen(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = $request->user();
        $pegawai = $user->pegawai;
    
        // Ambil parameter dari request
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
    
        // Default tanggal_awal ke tanggal 1 bulan ini jika kosong
        if (!$tanggalAwal) {
            $tanggalAwal = Carbon::now()->startOfMonth()->toDateString();
        }
    
        // Default tanggal_akhir ke tanggal hari ini jika kosong
        if (!$tanggalAkhir) {
            $tanggalAkhir = Carbon::now()->toDateString();
        }
    
        // Validasi format tanggal
        try {
            $tanggalAwal = Carbon::parse($tanggalAwal)->toDateString();
            $tanggalAkhir = Carbon::parse($tanggalAkhir)->toDateString();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid date format. Use YYYY-MM-DD.'], 400);
        }
    
        // Pastikan tanggal_awal tidak lebih besar dari tanggal_akhir
        if ($tanggalAwal > $tanggalAkhir) {
            return response()->json(['error' => 'tanggal_awal cannot be later than tanggal_akhir.'], 400);
        }
    
        // Query data absensi berdasarkan rentang tanggal
        $absensi = Presensi::whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->where('pegawai_id', $pegawai->id)
            ->orderBy('tanggal', 'asc')
            ->get();
    
        // Format data untuk respons
        $data = $absensi->map(function ($item) {
            return [
                'id' => $item->id,
                'pegawai_id' => $item->pegawai_id,
                'nama_pegawai' => $item->pegawai->nama, // Asumsi relasi Pegawai ada
                'divisi' => $item->pegawai->divisi->nama, // Asumsi relasi Pegawai ada
                'shift' => $item->pegawaiShift->shift->nama_shift,
                'tanggal' => $item->tanggal,
                'jam_masuk' => $item->jam_masuk,
                'jam_keluar' => $item->jam_keluar,
                'jam_masuk_jadwal' => $item->jam_masuk_jadwal,
                'jam_keluar_jadwal' => $item->jam_keluar_jadwal,
                'status' => $item->status,
                'keterangan' => $item->keterangan,
                'catatan'=>$item->catatan,
                'durasi_kerja' => formatDetikToMenit($item->durasi_kerja_detik), // Format durasi kerja
                'terlambat' => formatDetikToMenit($item->terlambat_detik),       // Format terlambat
                'pulang_cepat' => formatDetikToMenit($item->pulang_cepat_detik), // Format pulang cepat
            ];
        });
    
        // Kembalikan respons JSON
        return response()->json([
            'message' => 'History absensi berhasil dimuat.',
            'tanggal_awal' => $tanggalAwal,
            'tanggal_akhir' => $tanggalAkhir,
            'data' => $data,
        ], 200);
    }

    



    public function jadwalBelumAbsen(Request $request)
    {
        // Ambil parameter dari request
        $bulan = $request->input('bulan') ?? now()->month;
        $tahun = $request->input('tahun') ?? now()->year;
        $divisiId = $request->input('divisi_id');
    
        // Query data pegawai
        $query = PegawaiMaster::with(['pegawaiShifts' => function ($q) use ($bulan, $tahun) {
            if ($bulan && $tahun) {
                $q->whereMonth('tanggal', $bulan)
                  ->whereYear('tanggal', $tahun);
            } elseif ($bulan) {
                $q->whereMonth('tanggal', $bulan);
            } elseif ($tahun) {
                $q->whereYear('tanggal', $tahun);
            }
    
            // Tambahkan filter: tanggal < hari ini
            $q->whereDate('tanggal', '<', now()->toDateString());
        }]);
    
        if ($divisiId) {
            // $query->where('divisi_id', $divisiId);
        }
    
        $pegawaiList = $query->get();
    
        // Hitung jumlah hari dalam bulan yang dipilih
        $jumlahHari = Carbon::createFromDate($tahun, $bulan)->daysInMonth;
    
        $belumAbsen = [];
    
        foreach ($pegawaiList as $pegawai) {
            for ($i = 1; $i <= $jumlahHari; $i++) {
                $tanggal = Carbon::createFromDate($tahun, $bulan, $i)->toDateString();
    
                // Cek apakah ada jadwal shift untuk tanggal ini
                $jadwal = $pegawai->pegawaiShifts->firstWhere('tanggal', $tanggal);
    
                if ($jadwal) {
                    // Cek apakah ada absensi untuk tanggal ini
                    $absensi = Presensi::where('pegawai_id', $pegawai->id)
                        ->whereDate('tanggal', $tanggal)
                        ->exists();
    
                    if (!$absensi) {
                        // Jika ada jadwal tetapi tidak ada absensi, tambahkan ke daftar
                        $belumAbsen[] = [
                            'pegawai_id' => $pegawai->id,
                            'nama_pegawai' => $pegawai->nama,
                            'nik' => $pegawai->nik,
                            'tanggal' => $tanggal,
                            'kode_shift' => $jadwal->shift->kode_shift ?? '-',
                        ];
                    }
                }
            }
        }
    
        // Kembalikan respons JSON
        return response()->json([
            'message' => 'Data jadwal yang belum absen berhasil dimuat.',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data' => $belumAbsen,
        ], 200);
    }

}