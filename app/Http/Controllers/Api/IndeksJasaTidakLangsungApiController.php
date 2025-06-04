<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IndeksJasaTidakLangsung;
use App\Models\PegawaiJasaTidakLangsung;
use App\Models\KategoriIndeksJasaTidakLangsung;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class IndeksJasaTidakLangsungApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = IndeksJasaTidakLangsung::with(['kategori', 'pegawaiJasaTidakLangsung'])
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
            'kategori_id' => 'nullable|exists:kategori_indeks_jasa_tidak_langsung,id',
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
            // Simpan ke tabel IndeksJasaTidakLangsung
            $indeksJasaTidakLangsung = IndeksJasaTidakLangsung::create([
                'nama_indeks' => $request->nama_indeks,
                'nilai' => $request->nilai,
                'kategori_id' => $request->kategori_id
            ]);

            // Simpan relasi dengan pegawai di tabel PegawaiJasaTidakLangsung
            PegawaiJasaTidakLangsung::create([
                'pegawai_id' => $request->pegawai_id,
                'jasa_id' => $indeksJasaTidakLangsung->id,
                'nilai' => $request->nilai
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $indeksJasaTidakLangsung->load(['kategori', 'pegawaiJasaTidakLangsung'])
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
            $data = IndeksJasaTidakLangsung::with(['kategori', 'pegawaiJasaTidakLangsung'])
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
            $data = IndeksJasaTidakLangsung::with('kategori')->findOrFail($id);
            
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
            'kategori_id' => 'nullable|exists:kategori_indeks_jasa_tidak_langsung,id',
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
            $indeksJasaTidakLangsung = IndeksJasaTidakLangsung::findOrFail($id);
            
            $indeksJasaTidakLangsung->update([
                'nama_indeks' => $request->nama_indeks,
                'nilai' => $request->nilai,
                'kategori_id' => $request->kategori_id
            ]);

            // Update relasi dengan pegawai
            PegawaiJasaTidakLangsung::where('jasa_id', $id)
                ->where('pegawai_id', $request->pegawai_id)
                ->update(['nilai' => $request->nilai]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $indeksJasaTidakLangsung->load(['kategori', 'pegawaiJasaTidakLangsung'])
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
            $indeksJasaTidakLangsung = IndeksJasaTidakLangsung::findOrFail($id);
            
            // Hapus relasi dengan pegawai terlebih dahulu
            PegawaiJasaTidakLangsung::where('jasa_id', $id)->delete();
            
            // Hapus data indeks jasa tidak langsung
            $indeksJasaTidakLangsung->delete();

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
            $data = KategoriIndeksJasaTidakLangsung::where('status', true)
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