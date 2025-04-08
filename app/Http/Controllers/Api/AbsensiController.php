<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PegawaiShift;
use App\Models\Presensi;
use App\Models\Radius;
use Carbon\Carbon;
use Exception;
use Http;
use Illuminate\Http\Request;
use Log;
use Validator;

class AbsensiController extends Controller
{
    public function clockIn(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = $request->user();
        // Cari data pegawai terkait dengan pengguna
        $pegawai = $user->pegawai;
        if (!$pegawai) {
            return response()->json(['message' => 'Data pegawai tidak ditemukan.'], 404);
        }
    
        // return $user;
        // Validasi input
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date', // Tanggal presensi
            'longitude' => 'required|string', // Koordinat longitude
            'latitude' => 'required|string', // Koordinat latitude
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Foto wajah
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $divisi_id = $pegawai->divisi_id;
        // ----------------
        // Cek apakah sudah ada data presensi untuk tanggal ini
        $tanggal = $request->input('tanggal');
        $presensi = Presensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $tanggal)
            ->first();
        if ($presensi && $presensi->jam_masuk) {
            return response()->json([
                'success' => false,
                'message' => 'Absen masuk sudah dilakukan sebelumnya.',
            ], 400);
        }
    
        // Ambil jadwal absensi untuk tanggal ini
        $jadwalAbsensi = PegawaiShift::with('shift.jamKerja')
            ->where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $tanggal)
            ->first();
        if (!$jadwalAbsensi) {
            return response()->json(['message' => 'Jadwal absensi tidak ditemukan untuk tanggal ini.'], 404);
        }
    
        // Dapatkan nama hari dalam bahasa Indonesia
        $hariMapping = [
            'monday' => 'senin',
            'tuesday' => 'selasa',
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu',
        ];
        $currentDay = strtolower(now()->parse($tanggal)->format('l')); // Format hari menjadi lowercase
        $currentDayIndonesia = $hariMapping[$currentDay] ?? null;
    
        // Ambil jam kerja untuk hari ini
        $jamKerja = $jadwalAbsensi->shift->jamKerja->first();
        if (!$jamKerja) {
            return response()->json(['message' => 'Jam kerja tidak ditemukan untuk shift ini.'], 404);
        }
    
        // Jam masuk dan jam keluar jadwal
date_default_timezone_set('Asia/Jakarta');
  
// Ambil jam masuk dan jam keluar dari $jamKerja berdasarkan hari saat ini
$jamMasukJadwal = $jamKerja->{$currentDayIndonesia . '_masuk'};
$jamKeluarJadwal = $jamKerja->{$currentDayIndonesia . '_pulang'};

// Waktu saat ini (dalam format timestamp)
$currentTime = now()->setTimezone('Asia/Jakarta');

// return $currentTime;

// Ambil data shift
$shifts = $jadwalAbsensi->shift;

// Ambil offset waktu absen masuk

$waktu_mulai_masuk = (int) $shifts->waktu_mulai_masuk; // Pastikan integer
$waktu_akhir_masuk = (int) $shifts->waktu_akhir_masuk; // Pastikan integer

// Set timezone default ke Asia/Jakarta (sesuai kebutuhan)

// Ambil toleransi terlambat dari shift (default 0 jika tidak ada)
$toleransiTerlambat = $shifts->toleransi_terlambat ?? 0;

// Validasi format tanggal dan jam masuk jadwal
if (!isset($tanggal, $jamMasukJadwal) || empty($tanggal) || empty($jamMasukJadwal)) {
    throw new Exception("Tanggal atau jam masuk jadwal tidak valid.");
}

$jadwalJam = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal $jamMasukJadwal", 'Asia/Jakarta')
    ->setTimezone('Asia/Jakarta'); // Pastikan tetap di zona waktu lokal

// Hitung batas awal absensi masuk (jam masuk jadwal + offset waktu mulai masuk)
$batasAwalMasuk = Carbon::createFromFormat('Y-m-d H:i:s', "$tanggal $jamMasukJadwal", 'Asia/Jakarta')
    ->addMinutes($waktu_mulai_masuk) // -60 untuk mundur 1 jam
    ->setTimezone('Asia/Jakarta'); // Pastikan tetap di zona waktu lokal

    // return $batasAwalMasuk;
    // exit;
// return $batasAwalMasuk->toDateTimeString(); // Format: 2025-03-10 10:25:00



    // return $tanggal . ' ' . $jamMasukJadwal;
// Hitung batas akhir absensi masuk (jam masuk jadwal + offset waktu akhir masuk)
$batasAkhirMasuk = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal . ' ' . $jamMasukJadwal)
    ->addMinutes($waktu_akhir_masuk)
    ->setTimezone('Asia/Jakarta'); // Pastikan tetap di zona waktu lokal
// echo $batasAkhirMasuk;
    // exit;

// return $jam

            # code...
        // Validasi waktu absen
        if ($currentTime->lt($batasAwalMasuk)) {
            return response()->json(['message' => 'Belum waktunya absen. Absen hanya dapat dilakukan setelah jam masuk awal.'], 400);
        }
    

        // echo $batasAkhirMasuk;
        // exit;
        if ($currentTime->gt($batasAkhirMasuk)) {
            return response()->json(['message' => 'Waktu absen telah melewati batas toleransi terlambat.'], 400);
        }
    
        // Ambil data radius terbaru dari database
        $radius = Radius::latest()->first();
        if (!$radius) {
            return response()->json([
                'success' => false,
                'message' => 'Data radius tidak ditemukan.',
            ], 404);
        }
    
        // Konversi koordinat radius ke format array
        $coordinates = json_decode($radius->coordinates, true);
        if (!is_array($coordinates) || empty($coordinates)) {
            return response()->json([
                'success' => false,
                'message' => 'Koordinat radius tidak valid.',
            ], 500);
        }
    
        // Ubah urutan koordinat menjadi [longitude, latitude]
        $adjustedCoordinates = array_map(function ($coord) {
            return [$coord[1], $coord[0]]; // Balik urutan [lat, lng] -> [lng, lat]
        }, $coordinates);
    
        // Pengecekan apakah titik berada dalam poligon
        $userLng = (float)$request->input('longitude');
        $userLat = (float)$request->input('latitude');
        $isInside = $this->isPointInPolygon([$userLng, $userLat], $adjustedCoordinates);
        if (!$isInside) {
            return response()->json([
                'success' => false,
                'message' => 'Anda berada di luar radius yang ditentukan.',
            ], 400);
        }
    
        // Verifikasi wajah menggunakan API Python
        $file = $request->file('foto');
        $fileName = time() . '_' . $file->getClientOriginalName(); // Nama unik untuk file
        $pythonApiUrl = 'http://127.0.0.1:8002/verify';
        $response = Http::attach(
            'image', file_get_contents($file), $fileName
        )->post($pythonApiUrl, [
            'name' => $request->user()->uuid, // Kirim nama pengguna
        ]);
    
        // Cek respons dari API Python
        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi wajah gagal.',
                'error' => $response->body(),
            ], 500);
        }
        $verificationResult = $response->json();
        if (!isset($verificationResult['is_match']) || !$verificationResult['is_match']) {
            return response()->json([
                'success' => false,
                'message' => 'Wajah tidak sesuai dengan data yang terdaftar.',
            ], 400);
        }
    
        $landmarks= $verificationResult['landmarks'];
        // Simpan data presensi
        // return $landmarks;

        // return $currentTime;
        // return $batasAkhirMasuk;
        // return $batasAwalMasuk;
        // echo $currentTime."<br>";
        // echo $batasAwalMasuk."<br>";
        // echo $batasAkhirMasuk."<br>";

        // return $jamMasukJadwal;
        // return $jamKeluarJadwal;
        $jamMasukJadwalAwal = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal . ' ' . $jamMasukJadwal)

        ->setTimezone('Asia/Jakarta');
    
    $jamMasukJadwalAkhir = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal . ' ' . $jamKeluarJadwal)

        ->setTimezone('Asia/Jakarta');
    
    // Jika jam keluar lebih kecil dari jam masuk, berarti jatuh pada hari berikutnya
    if (strtotime($jamKeluarJadwal) < strtotime($jamMasukJadwal)) {
        $jamMasukJadwalAkhir->addDay(); 
    }

    // return $jamMasukJadwalAkhir->toDateTimeString();
    // return $jamMasukJadwalAwal->toDateTimeString();
    // return $jamMasukJadwalOK->toDateTimeString();
        $currentDayIndonesia = $currentTime->toDateTimeString();
        // return $batasAwalMasuk;
        $keterangan = $this->getKeteranganPresensi($currentTime, $batasAwalMasuk, $batasAkhirMasuk,$jadwalJam);

        // return  $this->getKeteranganPresensi($currentTime, $batasAwalMasuk, $batasAkhirMasuk);
        $presensi = Presensi::updateOrCreate(
            [
                'pegawai_id' => $pegawai->id,
                'tanggal' => $tanggal,
            ],
            [
                'divisi_id'=>$divisi_id,
                'pegawai_shift_id' => $jadwalAbsensi->id,
                'jam_masuk' => $currentTime, // Simpan sebagai timestamp
                'jam_masuk_jadwal' => $jamMasukJadwalAwal->toDateTimeString(),
                'jam_keluar_jadwal' => $jamMasukJadwalAkhir->toDateTimeString(),
                'status' => $keterangan['status'],
                'keterangan' => $keterangan['keterangan'],
                'longitude_masuk' => $request->input('longitude'),
                'latitude_masuk' => $request->input('latitude'),
                'created_by' => $user->id,
                'face_landmarks_in' => json_encode($landmarks),
                'updated_by' => $user->id,
                'terlambat_detik'=>$keterangan['terlambat_detik']
            ]
        );
    
        return response()->json([
            'message' => 'Presensi masuk berhasil dicatat.',
            'data' => $presensi,
        ], 200);
    }
    /**
     * Catat jam keluar presensi.
     */
    public function clockOut(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = $request->user();
        // Cari data pegawai terkait dengan pengguna
        $pegawai = $user->pegawai;
        if (!$pegawai) {
            return response()->json(['message' => 'Data pegawai tidak ditemukan.'], 404);
        }
    
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_presensi' => 'required|exists:presensis,id', // ID presensi yang valid
            'longitude' => 'required|string', // Koordinat longitude
            'latitude' => 'required|string', // Koordinat latitude
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Foto wajah
            'catatan' => [
                'required',
                'string',
                'min:5', // Minimal 2 karakter
                'regex:/^[a-zA-Z0-9\s\p{P}]+$/u', // Hanya mengizinkan huruf, angka, spasi, dan tanda baca
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Cari data presensi berdasarkan ID
        $presensi = Presensi::find($request->input('id_presensi'));
        if (!$presensi) {
            return response()->json(['message' => 'Data presensi tidak ditemukan.'], 404);
        }
    
        // Pastikan id_presensi sesuai dengan pegawai_id
        if ($presensi->pegawai_id !== $pegawai->id) {
            return response()->json([
                'success' => false,
                'message' => 'ID presensi tidak sesuai dengan pegawai yang sedang login.',
            ], 403);
        }
    
        // Pastikan jam masuk sudah dicatat
        if (!$presensi->jam_masuk) {
            return response()->json(['message' => 'Jam masuk belum dicatat. Silakan lakukan clock-in terlebih dahulu.'], 400);
        }
    
        // Pastikan absen keluar belum dilakukan
        if ($presensi->jam_keluar) {
            return response()->json([
                'success' => false,
                'message' => 'Absen keluar sudah dilakukan sebelumnya.',
            ], 400);
        }
    
        // Ambil jadwal absensi untuk tanggal ini
        $jadwalAbsensi = PegawaiShift::with('shift.jamKerja')
            ->where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $presensi->tanggal)
            ->first();
        if (!$jadwalAbsensi) {
            return response()->json(['message' => 'Jadwal absensi tidak ditemukan untuk tanggal ini.'], 404);
        }
    
        // Dapatkan nama hari dalam bahasa Indonesia
        $hariMapping = [
            'monday' => 'senin',
            'tuesday' => 'selasa',
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu',
        ];
        $currentDay = strtolower(now()->parse($presensi->tanggal)->format('l')); // Format hari menjadi lowercase
        $currentDayIndonesia = $hariMapping[$currentDay] ?? null;
    
        // Ambil jam kerja untuk hari ini
        $jamKerja = $jadwalAbsensi->shift->jamKerja->first();
        if (!$jamKerja) {
            return response()->json(['message' => 'Jam kerja tidak ditemukan untuk shift ini.'], 404);
        }
    
        // Jam masuk dan jam keluar jadwal
        $jamMasukJadwal = $jamKerja->{$currentDayIndonesia . '_masuk'};
        $jamKeluarJadwal = $jamKerja->{$currentDayIndonesia . '_pulang'};
    
        // Waktu saat ini (dalam format timestamp)
        $currentTime = now(); // Menggunakan Carbon instance untuk timestamp
    
        // Hitung batas awal absensi keluar (sesuai jam pulang jadwal)
        $batasAwalKeluar = Carbon::createFromFormat('Y-m-d H:i:s', $presensi->tanggal . ' ' . $jamKeluarJadwal);
    
        // Hitung batas akhir absensi keluar (+1 jam dari jam pulang jadwal)
        $batasAkhirKeluar = Carbon::createFromFormat('Y-m-d H:i:s', $presensi->tanggal . ' ' . $jamKeluarJadwal)->addHour();
    

        $pulangCepat = true;

        if (!$pulangCepat) {
        // Validasi waktu absen
        if ($currentTime->lt($batasAwalKeluar)) {
            return response()->json(['message' => 'Belum waktunya absen keluar. Absen keluar hanya dapat dilakukan setelah jam pulang jadwal.'], 400);
        }
    }
        // if ($currentTime->gt($batasAkhirKeluar)) {
        //     return response()->json(['message' => 'Waktu absen telah melewati batas toleransi absen keluar (+1 jam).'], 400);
        // }
    
        // Ambil data radius terbaru dari database
        $radius = Radius::latest()->first();
        if (!$radius) {
            return response()->json([
                'success' => false,
                'message' => 'Data radius tidak ditemukan.',
            ], 404);
        }
    
        // Konversi koordinat radius ke format array
        $coordinates = json_decode($radius->coordinates, true);
        if (!is_array($coordinates) || empty($coordinates)) {
            return response()->json([
                'success' => false,
                'message' => 'Koordinat radius tidak valid.',
            ], 500);
        }
    
        // Ubah urutan koordinat menjadi [longitude, latitude]
        $adjustedCoordinates = array_map(function ($coord) {
            return [$coord[1], $coord[0]]; // Balik urutan [lat, lng] -> [lng, lat]
        }, $coordinates);
    
        // Pengecekan apakah titik berada dalam poligon
        $userLng = (float)$request->input('longitude');
        $userLat = (float)$request->input('latitude');
        $isInside = $this->isPointInPolygon([$userLng, $userLat], $adjustedCoordinates);
        if (!$isInside) {
            return response()->json([
                'success' => false,
                'message' => 'Anda berada di luar radius yang ditentukan.',
            ], 400);
        }
    
        // Verifikasi wajah menggunakan API Python
        $file = $request->file('foto');
        $fileName = time() . '_' . $file->getClientOriginalName(); // Nama unik untuk file
        $pythonApiUrl = 'http://127.0.0.1:8002/verify';
        $response = Http::attach(
            'image', file_get_contents($file), $fileName
        )->post($pythonApiUrl, [
            'name' => $request->user()->uuid, // Kirim nama pengguna
        ]);
    
        // Cek respons dari API Python
        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi wajah gagal.',
                'error' => $response->body(),
            ], 500);
        }
        $verificationResult = $response->json();
    
        $landmarks = $verificationResult['landmarks'];
    
        if (!isset($verificationResult['is_match']) || !$verificationResult['is_match']) {
            return response()->json([
                'success' => false,
                'message' => 'Wajah tidak sesuai dengan data yang terdaftar.',
            ], 400);
        }
    
        // Hitung durasi kerja dalam detik
        $jamMasuk = Carbon::parse($presensi->jam_masuk); // Jam masuk dari database
        $jamKeluar = Carbon::now()->setTimezone('Asia/Jakarta');
    
        $durasiKerjaDetik = $jamMasuk->diffInSeconds($jamKeluar); // Hitung durasi dalam detik
    
        // Hitung pulang cepat dalam detik
        $pulangCepatDetik = 0;
        if ($jamKeluar->lt($batasAwalKeluar)) {
            $pulangCepatDetik = abs($batasAwalKeluar->diffInSeconds($jamKeluar));


        }
    
        // Update jam keluar dan tambahkan durasi_kerja_detik serta pulang_cepat_detik
        $presensi->update([
            'jam_keluar' => $jamKeluar, // Simpan sebagai timestamp
            'updated_by' => $user->id,
            'latitude_keluar' => $userLat,
            'longitude_keluar' => $userLng,
            'face_landmarks_out' => json_encode($landmarks),
            'catatan' => $request->catatan,
            'durasi_kerja_detik' => (int) $durasiKerjaDetik, // Tambahkan durasi kerja dalam detik
            'pulang_cepat_detik' => (int) $pulangCepatDetik, // Tambahkan pulang cepat dalam detik
        ]);
    
        return response()->json([
            'message' => 'Presensi keluar berhasil dicatat.',
            'data' => $presensi,
        ], 200);
    }


    /**
     * Implementasi Ray-Casting untuk mengecek apakah titik berada dalam poligon.
     */
    private function isPointInPolygon($point, $polygon)
    {
        $x = $point[0];
        $y = $point[1];
        $inside = false;

        // Loop melalui sisi-sisi poligon
        for ($i = 0, $j = count($polygon) - 1; $i < count($polygon); $j = $i++) {
            $xi = $polygon[$i][0];
            $yi = $polygon[$i][1];
            $xj = $polygon[$j][0];
            $yj = $polygon[$j][1];

            // Periksa apakah titik berada pada sisi horizontal poligon
            $intersect = (($yi > $y) != ($yj > $y)) &&
                         ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }

private function getStatusPresensi($jamMasuk, $batasAwalMasuk, $batasAkhirMasuk)
{
    // Pastikan semua input adalah instance Carbon
    $jamMasuk = Carbon::parse($jamMasuk);
    $batasAwalMasuk = Carbon::parse($batasAwalMasuk);
    $batasAkhirMasuk = Carbon::parse($batasAkhirMasuk);

    // Jika absen masuk sebelum atau tepat pada jadwal masuk
    if ($jamMasuk->lte($batasAwalMasuk)) {
        return 'hadir';
    }

    // Jika absen masuk setelah jadwal masuk tetapi masih dalam batas toleransi
    if ($jamMasuk->lte($batasAkhirMasuk)) {
        return 'terlambat';
    }

    // Jika absen masuk melebihi batas toleransi
    return 'alpha';
}

/**
 * Hitung keterangan presensi.
 */

 private function getKeteranganPresensi($jamMasuk, $batasAwalMasuk, $batasAkhirMasuk, $jadwalJam)
 {
     // Pastikan semua input adalah instance Carbon dengan timezone Asia/Jakarta
     $jamMasuk = Carbon::parse($jamMasuk)->setTimezone('Asia/Jakarta');
     $jadwalJam = Carbon::parse($jadwalJam)->setTimezone('Asia/Jakarta');
     $batasAwalMasuk = Carbon::parse($batasAwalMasuk)->setTimezone('Asia/Jakarta');
     $batasAkhirMasuk = Carbon::parse($batasAkhirMasuk)->setTimezone('Asia/Jakarta');
 
     // Inisialisasi variabel default
     $status = 'hadir';
     $keterangan = 'Absen masuk tepat waktu.';
     $terlambatDetik = 0;
 
     if ($jamMasuk->lessThanOrEqualTo($jadwalJam)) {
         // Tepat waktu
         return [
             'status' => $status,
             'keterangan' => $keterangan,
             'terlambat_detik' => $terlambatDetik,
         ];
     }
 
     if ($jamMasuk->lessThanOrEqualTo($batasAkhirMasuk)) {
         // Terlambat, tetapi masih dalam batas toleransi
         $status = 'terlambat';
         $terlambatDetik = $jadwalJam->diffInSeconds($jamMasuk); // Hitung detik keterlambatan
         $terlambatMenit = round($terlambatDetik / 60); // Konversi ke menit
         $keterangan = "Absen masuk terlambat {$terlambatMenit} menit.";
         return [
             'status' => $status,
             'keterangan' => $keterangan,
             'terlambat_detik' => $terlambatDetik,
         ];
     }
 
     // Melebihi batas toleransi (Alpha)
     $status = 'alpha';
     $terlambatDetik = $batasAkhirMasuk->diffInSeconds($jamMasuk); // Hitung detik keterlambatan
     $terlambatMenit = round($terlambatDetik / 60); // Konversi ke menit
     $keterangan = "Tidak hadir (Alpha). Terlambat {$terlambatMenit} menit melebihi batas toleransi.";
     return [
         'status' => $status,
         'keterangan' => $keterangan,
         'terlambat_detik' => $terlambatDetik,
     ];
 }



}
