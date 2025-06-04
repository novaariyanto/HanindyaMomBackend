<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IndeksJasaLangsungNonMedis;
use App\Models\PegawaiJasaNonMedis;
use App\Models\KategoriIndeksJasaLangsungNonMedis;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class IndeksJasaLangsungNonMedisApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = IndeksJasaLangsungNonMedis::with(['kategori', 'pegawaiJasaNonMedis'])
            ->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Form create ready'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_indeks' => 'required|string|max:255',
            'nilai' => 'required|numeric',
            'kategori_id' => 'nullable|exists:kategori_indeks_jasa_langsung_non_medis,id',
            'pegawai_id' => 'required|exists:pegawai,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Simpan ke tabel IndeksJasaLangsungNonMedis
            $indeksJasaLangsungNonMedis = IndeksJasaLangsungNonMedis::create([
                'nama_indeks' => $request->nama_indeks,
                'nilai' => $request->nilai,
                'kategori_id' => $request->kategori_id,
                'status' => true
            ]);

            // Simpan relasi dengan pegawai di tabel PegawaiJasaNonMedis
            PegawaiJasaNonMedis::create([
                'pegawai_id' => $request->pegawai_id,
                'jasa_id' => $indeksJasaLangsungNonMedis->id,
                'nilai' => $request->nilai
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $indeksJasaLangsungNonMedis->load(['kategori', 'pegawaiJasaNonMedis'])
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
            $data = IndeksJasaLangsungNonMedis::with(['kategori', 'pegawaiJasaNonMedis'])
                ->findOrFail($id);
            
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): JsonResponse
    {
        try {
            $data = IndeksJasaLangsungNonMedis::with('kategori')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diambil untuk edit',
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
            'nama_indeks' => 'required|string|max:255',
            'nilai' => 'required|numeric',
            'kategori_id' => 'nullable|exists:kategori_indeks_jasa_langsung_non_medis,id',
            'pegawai_id' => 'required|exists:pegawai,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $indeksJasaLangsungNonMedis = IndeksJasaLangsungNonMedis::findOrFail($id);
            
            $indeksJasaLangsungNonMedis->update([
                'nama_indeks' => $request->nama_indeks,
                'nilai' => $request->nilai,
                'kategori_id' => $request->kategori_id
            ]);

            // Update relasi dengan pegawai
            PegawaiJasaNonMedis::where('jasa_id', $id)
                ->where('pegawai_id', $request->pegawai_id)
                ->update(['nilai' => $request->nilai]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $indeksJasaLangsungNonMedis->load(['kategori', 'pegawaiJasaNonMedis'])
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
            $indeksJasaLangsungNonMedis = IndeksJasaLangsungNonMedis::findOrFail($id);
            
            // Hapus relasi dengan pegawai terlebih dahulu
            PegawaiJasaNonMedis::where('jasa_id', $id)->delete();
            
            // Hapus data indeks jasa langsung non medis
            $indeksJasaLangsungNonMedis->delete();

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
     * Get kategori options for dropdown
     */
    public function getKategoriOptions(): JsonResponse
    {
        try {
            $data = KategoriIndeksJasaLangsungNonMedis::where('status', true)
                ->orderBy('nama_kategori')
                ->get(['id', 'nama_kategori']);
            
            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data kategori'
            ], 500);
        }
    }
} 