<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PegawaiJasaTidakLangsung;
use App\Models\IndeksJasaTidakLangsung;
use App\Models\IndeksPegawai;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PegawaiJasaTidakLangsungApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = PegawaiJasaTidakLangsung::with(['pegawai', 'jasa.kategori']);
        
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
            // Cek apakah sudah ada data untuk pegawai dan jasa yang sama (kecuali yang sedang diedit)
            $pegawaidata = PegawaiJasaTidakLangsung::where('pegawai_id', $request->pegawai_id);

            $existing = $pegawaidata
                ->where('jasa_id', $request->jasa_id)
                ->where('id', '!=', $request->id)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data indeks jasa tidak langsung untuk pegawai ini sudah ada'
                ], 409);
            }
            // cari total_cluster 4
          

            $pegawaiJasaTidakLangsung = PegawaiJasaTidakLangsung::create([
                'pegawai_id' => $request->pegawai_id,
                'jasa_id' => $request->jasa_id,
                'nilai' => $request->nilai
            ]);
            $total_cluster_4 = $pegawaidata->sum('nilai');
            
            $indekspegawai = IndeksPegawai::find($request->pegawai_id);
            $indekspegawai->cluster_4 = $total_cluster_4 ;
            $indekspegawai->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $pegawaiJasaTidakLangsung->load(['pegawai', 'jasa.kategori'])
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
            $data = PegawaiJasaTidakLangsung::with(['pegawai', 'jasa.kategori'])->findOrFail($id);
            
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
            $pegawaiJasaTidakLangsung = PegawaiJasaTidakLangsung::findOrFail($id);
            
            // Cek apakah sudah ada data untuk pegawai dan jasa yang sama (kecuali yang sedang diedit)
            $pegawaidata = PegawaiJasaTidakLangsung::where('pegawai_id', $request->pegawai_id);

            $existing = $pegawaidata
                ->where('jasa_id', $request->jasa_id)
                ->where('id', '!=', $id)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data indeks jasa tidak langsung untuk pegawai ini sudah ada'
                ], 409);
            }
            // cari total_cluster 4
          
            $pegawaiJasaTidakLangsung->update([
                'pegawai_id' => $request->pegawai_id,
                'jasa_id' => $request->jasa_id,
                'nilai' => $request->nilai
            ]);
            
            $total_cluster_4 = $pegawaidata->sum('nilai');
            
            $indekspegawai = IndeksPegawai::find($request->pegawai_id);
            $indekspegawai->cluster_4 = $total_cluster_4 ;
            $indekspegawai->save();


            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => $pegawaiJasaTidakLangsung->load(['pegawai', 'jasa.kategori'])
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
            $pegawaiJasaTidakLangsung = PegawaiJasaTidakLangsung::findOrFail($id);
            $pegawai_id = $pegawaiJasaTidakLangsung->pegawai_id;
            $pegawaiJasaTidakLangsung->delete();

            $total_cluster_4 = PegawaiJasaTidakLangsung::where('pegawai_id', $pegawai_id)->sum('nilai');
            
            $indekspegawai = IndeksPegawai::find($pegawai_id);
            $indekspegawai->cluster_4 = $total_cluster_4 ;
            $indekspegawai->save();

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
     * Get indeks jasa tidak langsung options for dropdown
     */
    public function getIndeksOptions(Request $request): JsonResponse
    {
        try {
            $query = IndeksJasaTidakLangsung::with('kategori')
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