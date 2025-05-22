<?php

namespace App\Http\Controllers;

use App\Models\PegawaiMaster;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

use App\Models\Presensi;
use Carbon\Carbon;

use App\Models\OTPVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DashboardController extends Controller
{
    //


    public function sendOtp(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);
    
        // Cari pengguna berdasarkan username (NIK)
        $user = User::where('username', $request->input('username'))->first();
    
        if (!$user) {
            return response()->json(['error' => 'Pengguna tidak ditemukan.'], 404);
        }
    
        // Cek apakah ada OTP yang sudah dikirim sebelumnya
        $lastOtp = OTPVerification::where('nomor_hp', $user->username)->first();
    
        if ($lastOtp) {
            // Hitung selisih waktu antara sekarang dan waktu terakhir OTP dikirim
            $timeDifference = (int) abs(now()->diffInMinutes($lastOtp->created_at));
            // echo $timeDifference;
    
            // Jika belum 5 menit sejak OTP terakhir dikirim, tolak permintaan
            if ($timeDifference < 5) {
                return response()->json([
                    'error' => 'Anda hanya dapat meminta OTP setelah ' . (5 - $timeDifference) . ' menit lagi.',
                ], 429); // 429: Too Many Requests
            }
        }
    
        // Generate OTP 6 digit
        $otpCode = rand(100000, 999999);
    
        // Simpan OTP ke database
        OTPVerification::updateOrCreate(
            ['nomor_hp' => $user->username],
            [
                'otp_code' => $otpCode,
                'expires_at' => now()->addMinutes(5), // OTP berlaku selama 5 menit
            ]
        );
    
        // Kirim OTP ke nomor HP pengguna (misalnya via SMS gateway atau WhatsApp)
        $message = "Kode OTP Anda: {$otpCode}. Jangan Berikan ke Siapapun. Batas Waktu 5 menit.";
        apiWa($user->username, $message);
    
        return response()->json(['message' => 'OTP berhasil dikirim.']);
    }

public function getData()
{
    // return $auth;
    // Hitung total pegawai
    $totalPegawai = PegawaiMaster::count();

// Hitung kehadiran hari ini (status: hadir atau terlambat)
$kehadiranHariIni = Presensi::whereDate('tanggal', Carbon::today())
    ->whereIn('status', ['hadir', 'terlambat']) // Menyertakan status "hadir" dan "terlambat"
    ->count();

    // Hitung terlambat hari ini
    $terlambatHariIni = Presensi::whereDate('tanggal', Carbon::today())
        ->where('status', 'terlambat')
        ->count();

   // Hitung tidak hadir hari ini
$tidakHadirHariIni = PegawaiMaster::whereDoesntHave('presensi', function ($query) {
    $query->whereDate('tanggal', Carbon::today())
          ->whereIn('status', ['hadir', 'terlambat']); // Menyertakan status "hadir" dan "terlambat"
})
->count();
    // Statistik kehadiran 7 hari terakhir
   // Statistik kehadiran 7 hari terakhir
$statistikKehadiran = [];
for ($i = 6; $i >= 0; $i--) {
    $date = Carbon::today()->subDays($i)->format('Y-m-d');
    $statistikKehadiran[] = [
        'tanggal' => Carbon::today()->subDays($i)->format('d M'),
        'jumlah' => Presensi::whereDate('tanggal', $date)
            ->whereIn('status', ['hadir', 'terlambat']) // Menyertakan status "hadir" dan "terlambat"
            ->count(),
    ];
}


// Kehadiran per divisi
$kehadiranPerDivisi = Presensi::select('divisis.nama as nama_divisi')
    ->selectRaw('COUNT(presensis.id) as jumlah_kehadiran')
    ->join('divisis', 'presensis.divisi_id', '=', 'divisis.id')
    ->whereDate('presensis.tanggal', Carbon::today())
    ->whereIn('presensis.status', ['hadir', 'terlambat']) // Menyertakan status "hadir" dan "terlambat"
    ->groupBy('divisis.nama')
    ->get()
    ->map(function ($item) {
        return [
            'nama_divisi' => $item->nama_divisi,
            'jumlah_kehadiran' => $item->jumlah_kehadiran,
        ];
    });


    // Kehadiran per departemen
   

    // Data absensi terbaru
    $absensiTerbaru = Presensi::with(['pegawai', 'divisi'])
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get()
        ->map(function ($presensi) {
            return [
                'nama_pegawai' => $presensi->pegawai->nama ?? '-',
                // 'departemen' => $presensi->pegawai->divisi ?? '-',
                'divisi' => $presensi->divisi->nama ?? '-',
                'waktu_masuk' => $presensi->jam_masuk ? Carbon::parse($presensi->jam_masuk)->format('H:i') : '-',
                'waktu_keluar' => $presensi->jam_keluar ? Carbon::parse($presensi->jam_keluar)->format('H:i') : '-',
                'status' => $presensi->status,
            ];
        });

    return response()->json([
        'total_pegawai' => $totalPegawai,
        'kehadiran_hari_ini' => $kehadiranHariIni,
        'terlambat_hari_ini' => $terlambatHariIni,
        'tidak_hadir_hari_ini' => $tidakHadirHariIni,
        'statistik_kehadiran' => $statistikKehadiran,
        'kehadiran_per_divisi' => $kehadiranPerDivisi,
        'kehadiran_per_departemen' => 0,
        'absensi_terbaru' => $absensiTerbaru,
    ]);
}
}
