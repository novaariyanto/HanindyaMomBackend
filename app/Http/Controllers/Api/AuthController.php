<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OTPVerification;
use App\Models\Pegawai;
use App\Models\PegawaiMaster;
use App\Models\User;
use Illuminate\Http\Request;
use Str;
use Validator;
use Illuminate\Support\Facades\RateLimiter as FacadesRateLimiter;



class AuthController extends Controller
{
    //
    
    /**
     * Step 1: Kirim OTP ke nomor HP.
     */

     public function sendOTP(Request $request)
     {
         // Validasi input
         $validator = Validator::make($request->all(), [
             'nomor_hp' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,12}$/'],
             'key' => 'nullable'
         ]);
     
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }
     
         // Normalisasi nomor HP
         $nomorHp = preg_replace('/^(\+62|62|0)/', '0', $request->nomor_hp);
     
         // Cek apakah nomor HP ada di tabel users
         $user = User::where('username', $nomorHp)->first();
         if (!$user) {
             return response()->json(['message' => 'Nomor HP tidak terdaftar.'], 404);
         }
     
         // Validasi key: jika key sudah ada, cek apakah key yang dikirim sama dengan key di database
         if (!empty($user->key)) {

            // return $user->key;
            return response()->json(['message' => 'Mohon Maaf,Pengguna sudah masuk di perangkat lain.'], 403);
            

         }
     
         // **Cek Rate Limiting**
         $keyRateLimit = 'send-otp:' . $nomorHp;
         if (FacadesRateLimiter::tooManyAttempts($keyRateLimit, 3)) { // Maks 3x dalam 1 menit
             return response()->json([
                 'message' => "Terlalu banyak permintaan. Coba lagi dalam " . FacadesRateLimiter::availableIn($keyRateLimit) . " detik."
             ], 429);
         }
     
         // Tambah attempt ke Rate Limiter
         FacadesRateLimiter::hit($keyRateLimit, 60); // Reset dalam 60 detik
     
         // Cek apakah OTP sudah dikirim dalam 5 menit terakhir
         $lastOtp = OTPVerification::where('nomor_hp', $nomorHp)->first();
     
         if ($lastOtp && $lastOtp->expires_at > now()) {
             $remainingSeconds = now()->diffInSeconds($lastOtp->expires_at);
             $message = $remainingSeconds >= 60
                 ? "Anda harus menunggu " . ceil($remainingSeconds / 60) . " menit lagi sebelum meminta OTP baru."
                 : "Anda harus menunggu {$remainingSeconds} detik lagi sebelum meminta OTP baru.";
     
             return response()->json(['message' => $message], 429);
         }
     
         $menit = 2;
         // Generate OTP
         $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
         $expiresAt = now()->addMinutes($menit);
     
         // Simpan OTP ke database
         OTPVerification::updateOrCreate(
             ['nomor_hp' => $nomorHp],
             ['otp_code' => $otpCode, 'expires_at' => $expiresAt]
         );
     
         // Kirim OTP
         $message = "Kode OTP Anda: {$otpCode}. Jangan Berikan ke Siapapun. Batas Waktu " . $menit . " menit.";
         apiWa($nomorHp, $message);
         \Log::info("OTP dikirim ke nomor HP {$nomorHp}: {$otpCode}");
     
         return response()->json([
             'message' => 'OTP berhasil dikirim.',
             'nomor_hp' => $nomorHp,
             'nama' => $user->name,
             'waktu' => $menit,
         ]);
     }

    /**
     * Step 2: Verifikasi OTP dan hasilkan token.
     */
   public function verifyOTP(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'nomor_hp' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,12}$/'],
        'otp_code' => 'required|string|min:6|max:6',
        'key' => 'nullable'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Normalisasi nomor HP
    $nomorHp = preg_replace('/^(\+62|62|0)/', '0', $request->nomor_hp);

    // Cari OTP berdasarkan nomor HP
    $otp = OTPVerification::where('nomor_hp', $nomorHp)->first();
    if (!$otp || $otp->otp_code !== $request->otp_code) {
        return response()->json(['message' => 'Kode OTP tidak valid.'], 400);
    }
    if ($otp->isExpired()) {
        return response()->json(['message' => 'Kode OTP telah kedaluwarsa.'], 400);
    }

    // Cek apakah nomor HP ada di tabel users
    $user = User::where('username', $nomorHp)->first();
    if (!$user) {
        return response()->json(['message' => 'Nomor HP tidak terdaftar.'], 404);
    }

    // Validasi key: jika key sudah ada, cek apakah key yang dikirim sama dengan key di database
   

    // Jika key kosong dan request memiliki key, update key di tabel users
    if (empty($user->key) && !empty($request->key)) {
        $user->update(['key' => $request->key]);
    }

    // Hasilkan Access Token
    $token = $user->createToken('authToken')->plainTextToken;

    // Hapus OTP setelah digunakan
    $otp->delete();

    // Muat data pegawai_master yang terkait dengan pengguna
    $dataPegawaiMaster = $user->pegawai;

    // Pastikan divisi dan jabatan tersedia melalui relasi
    $divisi = $dataPegawaiMaster->divisi ? $dataPegawaiMaster->divisi->nama : null;
    $jabatan = $dataPegawaiMaster->jabatan ? $dataPegawaiMaster->jabatan->nama : null;

    return response()->json([
        'message' => 'Login berhasil.',
        'pegawai' => [
            'id' => $dataPegawaiMaster->id,
            'profile' => [
                'id' => $dataPegawaiMaster->pegawai->id,
                'nama' => $dataPegawaiMaster->pegawai->nama,
                'nip' => $dataPegawaiMaster->pegawai->nip,
                'nik' => $dataPegawaiMaster->pegawai->nik,
                'tempat_lahir' => $dataPegawaiMaster->pegawai->tempat_lahir,
                'tanggal_lahir' => $dataPegawaiMaster->pegawai->tanggal_lahir,
                'jenis_kelamin' => $dataPegawaiMaster->pegawai->jenis_kelamin,
                'agama_id' => $dataPegawaiMaster->pegawai->agama_id,
                'alamat' => $dataPegawaiMaster->pegawai->alamat,
                'province_id' => $dataPegawaiMaster->pegawai->province_id,
                'regency_id' => $dataPegawaiMaster->pegawai->regency_id,
                'district_id' => $dataPegawaiMaster->pegawai->district_id,
                'village_id' => $dataPegawaiMaster->pegawai->village_id,
                'jenis_pegawai' => $dataPegawaiMaster->pegawai->jenis_pegawai,
                'profesi_id' => $dataPegawaiMaster->pegawai->profesi_id,
                'email' => $dataPegawaiMaster->pegawai->email,
                'nohp' => $dataPegawaiMaster->pegawai->nohp,
                'is_deleted' => $dataPegawaiMaster->pegawai->is_deleted,
                'created_at' => $dataPegawaiMaster->pegawai->created_at,
                'updated_at' => $dataPegawaiMaster->pegawai->updated_at,
                'divisi' => $divisi,
                'jabatan' => $jabatan,
                'foto' => !empty($user->photo->path) ? url($user->photo->path) : url('imgs/users.png')
            ],
        ],
        'access_token' => $token,
    ], 200);
}


}
