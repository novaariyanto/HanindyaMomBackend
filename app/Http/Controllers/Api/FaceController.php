<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserPhoto;
use Http;
use Illuminate\Http\Request;
use Storage;
use Validator;

class FaceController extends Controller
{

    
     /**
     * Upload foto wajah.
     */
    
     
    /**
     * Upload foto wajah.
     */
    public function upload(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        try {
            $uuid = $request->user()->uuid;
    
            // Hapus data wajah dari API Python
            $pythonDeleteUrl = "http://127.0.0.1:8002/delete/{$uuid}";
            $deleteResponse = Http::delete($pythonDeleteUrl);
    
            if (!$deleteResponse->successful()) {
                $errorMsg = json_decode($deleteResponse->body())->error ?? 'Unknown error';
            }
    
            // Simpan file ke storage sementara
            $file = $request->file('foto');
            $fileName = $uuid . '_' . time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('faces', $fileName, 'public');
            $fileFullPath = storage_path('app/public/' . $filePath); // Path lengkap
    
            // Kirim data ke API Python (register)
            $pythonApiUrl = 'http://127.0.0.1:8002/register';
            $response = Http::attach('image', file_get_contents($fileFullPath), $fileName)
                ->post($pythonApiUrl, ['name' => $uuid]);
    
            // Cek respons API Python
            if (!$response->successful()) {
                // Jika gagal, hapus file yang diupload
                Storage::disk('public')->delete($filePath);
                return response()->json([
                    'message' => 'Gagal mendaftarkan foto ke sistem pengenalan wajah.',
                    'error' => json_decode($response->body())->error ?? 'Unknown error',
                ], 400);
            }
    
            $userPhoto = UserPhoto::where('user_id', $request->user()->id);

            if ($userPhoto->first()) {
                # code...
                $dataUser = $userPhoto->first()->path;    
                Storage::disk('public')->delete($dataUser);
                
            }
            // Jika berhasil, baru update atau buat data di database
            $facePhoto = UserPhoto::updateOrCreate(
                ['user_id' => $request->user()->id], // Kunci pencarian (berdasarkan user_id)
                [
                    'path' => 'storage/'.$filePath, // Simpan path file baru
                    'user_id' => $request->user()->id, // ID pengguna
                ]
            );
    
            return response()->json([
                'message' => 'Foto berhasil diupload dan terdaftar di sistem.',
                'data' => [
                    'id' => $facePhoto->id,
                    'uuid' => $request->user()->uuid,
                    'file_name' => $fileName,
                    'file_url' => url( 'storage/'.$filePath),
                    'python_response' => $response->json(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengupload foto.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Recognize wajah dari foto.
     */
    public function recognize(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Ambil file dari request
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Nama unik untuk file

            // Kirim data ke API Python
            $pythonApiUrl = 'http://127.0.0.1:8002/recognize';
            $response = Http::attach(
                'image', file_get_contents($file), $fileName
            )->post($pythonApiUrl, [
                'name' => $request->user()->name, // Kirim nama pengguna
            ]);

            // Cek respons dari API Python
            if ($response->successful()) {
                return response()->json([
                    'message' => 'Recognition berhasil.',
                    'data' => $response->json(),
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Gagal melakukan recognition.',
                    'error' => $response->body(),
                ], 500);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan umum
            return response()->json([
                'message' => 'Terjadi kesalahan saat melakukan recognition.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
     /**
     * Verify wajah dari foto.
     */
    public function verify(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Ambil file dari request
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Nama unik untuk file

            // Kirim data ke API Python
            $pythonApiUrl = 'http://127.0.0.1:8002/verify';
            $response = Http::attach(
                'image', file_get_contents($file), $fileName
            )->post($pythonApiUrl, [
                'name' => $request->user()->uuid, // Kirim nama pengguna
            ]);

            // Cek respons dari API Python
            if ($response->successful()) {
                return response()->json([
                    'message' => 'Verifikasi berhasil.',
                    'data' => $response->json(),
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Gagal melakukan verifikasi.',
                    'error' => $response->body(),
                ], 500);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan umum
            return response()->json([
                'message' => 'Terjadi kesalahan saat melakukan verifikasi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

}
