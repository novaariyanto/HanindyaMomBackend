<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PegawaiJasaNonMedis;
use App\Models\IndeksJasaLangsungNonMedis;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PegawaiJasaNonMedisApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = PegawaiJasaNonMedis::with(['pegawai', 'jasa.kategori']);
        
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
            $existing = PegawaiJasaNonMedis::where('pegawai_id', $request->pegawai_id)
                ->where('jasa_id', $request->jasa_id)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data indeks jasa langsung non medis untuk pegawai ini sudah ada'
                ], 409);
            }

            $pegawaiJasaNonMedis = PegawaiJasaNonMedis::create([
                'pegawai_id' => $request->pegawai_id,
                'jasa_id' => $request->jasa_id,
                'nilai' => $request->nilai
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $pegawaiJasaNonMedis->load(['pegawai', 'jasa.kategori'])
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
            $data = PegawaiJasaNonMedis::with(['pegawai', 'jasa.kategori'])->findOrFail($id);
            
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
            $pegawaiJasaNonMedis = PegawaiJasaNonMedis::findOrFail($id);
            
            // Cek apakah sudah ada data untuk pegawai dan jasa yang sama (kecuali yang sedang diedit)
            $existing = PegawaiJasaNonMedis::where('pegawai_id', $request->pegawai_id)
                ->where('jasa_id', $request->jasa_id)
                ->where('id', '!=', $id)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data indeks jasa langsung non medis untuk pegawai ini sudah ada'
                ], 409);
            }

            $pegawaiJasaNonMedis->update([
                'pegawai_id' => $request->pegawai_id,
                'jasa_id' => $request->jasa_id,
                'nilai' => $request->nilai
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $pegawaiJasaNonMedis->load(['pegawai', 'jasa.kategori'])
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
            $pegawaiJasaNonMedis = PegawaiJasaNonMedis::findOrFail($id);
            $pegawaiJasaNonMedis->delete();

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
     * Get indeks jasa langsung non medis options for dropdown
     */
    public function getIndeksOptions(Request $request): JsonResponse
    {
        try {
            $query = IndeksJasaLangsungNonMedis::with('kategori')
                ->orderBy('nama_indeks');
                
            // Filter berdasarkan kategori jika ada
            if ($request->has('kategori_id') && $request->kategori_id) {
                $query->where('kategori_id', $request->kategori_id);
            }
            
            $data = $query->get(['id', 'nama_indeks', 'nilai', 'kategori_id']);
            
            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data indeks'
            ], 500);
        }
    }
} 