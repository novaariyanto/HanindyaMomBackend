<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OTPVerification;
use App\Models\Pegawai;
use App\Models\PegawaiMaster;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Str;
use Validator;

class RegisterController extends Controller
{
    //


    /**
     * Step 1: Kirim OTP.
     */
  /**
     * Step 1: Kirim OTP.
     */
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'nomor_hp' =>  ['required','regex:/^(\+62|62|0)8[1-9][0-9]{6,12}$/']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Normalisasi nomor HP
        $nomorHp = preg_replace('/^(\+62|62|0)/', '0', $request->nomor_hp);


        // Cek apakah NIK ada di tabel pegawai_masters
        $pegawaiMaster = PegawaiMaster::where('nik', $request->nik)->first();

        if (!$pegawaiMaster) {
            return response()->json(['message' => 'Data NIK tidak ditemukan di database pegawai.'], 404);
        }

        // Cek apakah NIK dan Tanggal Lahir sesuai di tabel pegawai
        $pegawai = Pegawai::where('nik', $request->nik)
            ->where('tanggal_lahir', $request->tanggal_lahir)
            ->first();

        if (!$pegawai) {
            return response()->json(['message' => 'Data NIK dan Tanggal Lahir tidak sesuai.'], 404);
        }

        // Cek apakah nomor HP sudah terdaftar di tabel users
        $existingUser = User::where('username', $nomorHp)->first();
        if ($existingUser) {
            return response()->json(['message' => 'Nomor HP ini sudah terdaftar.'], 409);
        }

        $minute = 5;
        // Generate OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes($minute); // OTP berlaku selama 5 menit

        // Simpan OTP ke database
        OTPVerification::updateOrCreate(
            ['nomor_hp' => $nomorHp,'nik'=>$request->nik],
            [
                'otp_code' => $otpCode,
                'expires_at' => $expiresAt,
            ]
        );

        // Kirim OTP ke nomor HP (gunakan gateway SMS atau simulasi)
        $message = "Kode OTP Anda: {$otpCode}. Jangan Berikan ke Siapapun. Batas Waktu 5 menit.";

        // return $nomorHp;
        $send = apiWa($nomorHp, $message); // Ganti dengan fungsi pengiriman pesan WhatsApp/SMS

        \Log::info("OTP dikirim ke nomor HP {$nomorHp}: {$otpCode}");

        return response()->json([
            'message' => 'OTP berhasil dikirim.',
            'nomor_hp' => $nomorHp,
            'nama'=>$existingUser->name,
            'waktu'=>$minute
        ]);
    }

    /**
     * Normalisasi nomor HP.
     * Mengubah "628" menjadi "08".
     */
    private function normalizeNomorHp($nomorHp)
    {
        // Jika nomor HP dimulai dengan "628", ubah menjadi "08"
        if (Str::startsWith($nomorHp, '628')) {
            return '08' . substr($nomorHp, 3);
        }

        // Jika nomor HP sudah dimulai dengan "08", kembalikan langsung
        return $nomorHp;
    }
    /**
     * Step 2: Verifikasi OTP dan buat akun.
     */
    public function verifyOTP(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nomor_hp' =>  ['required','regex:/^(\+62|62|0)8[1-9][0-9]{6,12}$/'],
            'otp_code' => 'required|string|min:6|max:6',
        ]);


        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $nomorHp = preg_replace('/^(\+62|62|0)/', '0', $request->nomor_hp);



        // Cari OTP berdasarkan nomor HP
        $otp = OTPVerification::where('nomor_hp', $nomorHp)->first();

        if (!$otp || $otp->otp_code !== $request->otp_code) {
            return response()->json(['message' => 'Kode OTP tidak valid.'], 400);
        }

        if ($otp->isExpired()) {
            return response()->json(['message' => 'Kode OTP telah kedaluwarsa.'], 400);
        }

        // Cek apakah nomor HP sudah terdaftar di tabel users
        $existingUser = User::where('username', $nomorHp)->first();
        if ($existingUser) {
            return response()->json(['message' => 'Nomor HP ini sudah terdaftar.'], 409);
        }

        $nik = $otp->nik;
        
        $pegawaiMaster = PegawaiMaster::where('nik',$nik);
        if (!$pegawaiMaster) {
            return response()->json(['message' => 'Data NIK tidak ditemukan di database pegawai.'], 404);
        }

        // Buat akun baru di tabel users
        $dataPegawai = $pegawaiMaster->first();

        $password = Str::random(8); // Password otomatis (8 karakter)
        $user = User::create([
            'name' => $dataPegawai->nama,
            'username' => $nomorHp, // Nomor HP sebagai username
            'password' => Hash::make($password), // Password otomatis
        ]);

        $user->assignRole('pegawai'); // Memberikan role "admin"



        $dataPegawai->update(['id_user' => $user->id]);

        // Hasilkan Access Token
        $token = $user->createToken('authToken')->plainTextToken;

        // Hapus OTP setelah digunakan
        $otp->delete();

        return response()->json([
            'message' => 'Akun berhasil dibuat.',
            'user' => $user,
            'pegawai'=>$dataPegawai->pegawai,
            'access_token' => $token,
            'generated_password' => $password, // Opsional: Kembalikan password untuk informasi
        ], 201);
    }


}

