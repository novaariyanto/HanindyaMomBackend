<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PegawaiStruktural;
use App\Models\IndeksStruktural;
use App\Models\IndeksPegawai;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PegawaiStrukturalApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = PegawaiStruktural::with(['pegawai', 'jasa']);
        
        if ($request->has('pegawai_id')) {
            $query->where('pegawai_id', $request->pegawai_id);
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'pegawai_id' => 'required|exists:indeks_pegawai,id',
            'jasa_id' => 'required',
            'nilai' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Cek apakah sudah ada data untuk pegawai dan jasa yang sama
           $existing = PegawaiStruktural::where('pegawai_id', $request->pegawai_id)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Data indeks struktural untuk pegawai ini sudah ada'
                ], 409);
            }


            $pegawaiStruktural = PegawaiStruktural::create([
                'pegawai_id' => $request->pegawai_id,
                'jasa_id' => $request->jasa_id,
                'nilai' => $request->nilai
            ]);
            $indekspegawai = IndeksPegawai::find($request->pegawai_id);
            $indekspegawai->cluster_3 = $request->nilai;
            $indekspegawai->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $pegawaiStruktural->load(['pegawai', 'jasa'])
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $data = PegawaiStruktural::with(['pegawai', 'jasa'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diambil',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'pegawai_id' => 'required|exists:indeks_pegawai,id',
            'jasa_id' => 'required',
            'nilai' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pegawaiStruktural = PegawaiStruktural::findOrFail($id);
            
            // Cek apakah sudah ada data untuk pegawai dan jasa yang sama (kecuali yang sedang diedit)
            $existing = PegawaiStruktural::where('pegawai_id', $request->pegawai_id)
                ->where('jasa_id', $request->jasa_id)
                ->where('id', '!=', $id)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data indeks struktural untuk pegawai ini sudah ada'
                ], 409);
            }

            $pegawaiStruktural->update([
                'pegawai_id' => $request->pegawai_id,
                'jasa_id' => $request->jasa_id,
                'nilai' => $request->nilai
            ]);
            $indekspegawai = IndeksPegawai::find($request->pegawai_id);
            $indekspegawai->cluster_3 = $request->nilai;
            $indekspegawai->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $pegawaiStruktural->load(['pegawai', 'jasa'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $pegawaiStruktural = PegawaiStruktural::findOrFail($id);
            $pegawaiStruktural->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get indeks struktural options for dropdown
     */
    public function getIndeksOptions(): JsonResponse
    {
        try {
            $data = IndeksStruktural::orderBy('nama_jabatan')
                ->get(['id', 'nama_jabatan', 'nilai']);
            
            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data indeks'
            ], 500);
        }
    }
} 