<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function profile(Request $request)
    {
        // Ambil pengguna yang sedang login berdasarkan token
        $user = $request->user();

        // Muat data pegawai_master yang terkait dengan pengguna
        $dataPegawaiMaster = $user;

        return response()->json([
            'message' => 'Profile berhasil dimuat.',
            'pegawai' => [
                'id'=>$dataPegawaiMaster->id,
                'profile'=>$dataPegawaiMaster->pegawai->pegawai
            ]
        ], 200);
    }
}
