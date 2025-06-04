<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IndeksStruktural;
use App\Models\PegawaiStruktural;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class IndeksStrukturalApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = IndeksStruktural::with(['pegawai'])->orderBy('created_at', 'desc')->get();
        
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
            'nama_jabatan' => 'required|string|max:255',
            'nilai' => 'required|numeric',
            'pegawai_id' => 'required|exists:indeks_pegawai,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Simpan ke tabel IndeksStruktural
            $indeksStruktural = IndeksStruktural::create([
                'nama_jabatan' => $request->nama_jabatan,
                'nilai' => $request->nilai
            ]);

            // Simpan relasi dengan pegawai di tabel PegawaiStruktural
            PegawaiStruktural::create([
                'pegawai_id' => $request->pegawai_id,
                'jasa_id' => $indeksStruktural->id,
                'nilai' => $request->nilai
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $indeksStruktural->load('pegawai')
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
            $data = IndeksStruktural::with(['pegawai'])->findOrFail($id);
            
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
            $data = IndeksStruktural::findOrFail($id);
            
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
            'nama_jabatan' => 'required|string|max:255',
            'nilai' => 'required|numeric',
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
            $indeksStruktural = IndeksStruktural::findOrFail($id);
            
            $indeksStruktural->update([
                'nama_jabatan' => $request->nama_jabatan,
                'nilai' => $request->nilai
            ]);

            // Update relasi dengan pegawai
            PegawaiStruktural::where('jasa_id', $id)
                ->where('pegawai_id', $request->pegawai_id)
                ->update(['nilai' => $request->nilai]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $indeksStruktural->load('pegawai')
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
            $indeksStruktural = IndeksStruktural::findOrFail($id);
            
            // Hapus relasi dengan pegawai terlebih dahulu
            PegawaiStruktural::where('jasa_id', $id)->delete();
            
            // Hapus data indeks struktural
            $indeksStruktural->delete();

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
} 