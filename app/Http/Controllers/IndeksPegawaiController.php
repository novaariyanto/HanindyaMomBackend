<?php

namespace App\Http\Controllers;

use App\Models\IndeksPegawai;
use App\Models\Profesi;
use App\Models\Pegawai;
use App\Models\PegawaiMutasi;
use App\Models\JenisPegawai;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;

class IndeksPegawaiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = IndeksPegawai::with('profesi', 'unitKerja','jenisPegawai');

            // Filter berdasarkan profesi
            if (request()->has('profesi_id') && request('profesi_id') != '') {
                $data->where('profesi_id', request('profesi_id'));
            }

            // Filter berdasarkan unit kerja
            if (request()->has('unit_kerja_id') && request('unit_kerja_id') != '') {
                $data->where('unit', request('unit_kerja_id'));
            }

            // Filter berdasarkan jenis pegawai
            if (request()->has('jenis_pegawai') && request('jenis_pegawai') != '') {
                $data->where('jenis_pegawai', request('jenis_pegawai'));
            }

            // Filter berdasarkan pencarian global
            if (request()->has('search') && request('search') != '') {
                $searchValue = request('search');
                $data->where(function($query) use ($searchValue) {
                    $query->where('nama', 'like', "%{$searchValue}%")
                          ->orWhere('nip', 'like', "%{$searchValue}%")
                          ->orWhere('nik', 'like', "%{$searchValue}%");
                });
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('profesi_nama', function($row) {
                    return $row->profesi ? $row->profesi->nama : '-';
                })
                ->addColumn('unit_kerja_nama', function($row) {
                    return $row->unitKerja ? $row->unitKerja->nama : ($row->unit ?? '-');
                })
                ->addColumn('jenis_pegawai_label', function($row) {
                    return $row->jenis_pegawai_label;
                })
                ->addColumn('jenis_pegawai', function($row) {
                    return $row->jenisPegawai?$row->jenisPegawai->nama:'-';
                })
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('indeks-pegawai.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <a href="#" data-url="' . route('indeks-pegawai.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete"><i class="ti ti-trash"></i></a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $jenisPegawai = JenisPegawai::all();
        $dprofesi = Profesi::all();
        
        $unitKerja = UnitKerja::all();
        return view('indeks-pegawai.index', compact('dprofesi','jenisPegawai','unitKerja'));
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:30',
            'nik' => 'required|string|max:20|unique:indeks_pegawai',
            'unit' => 'nullable|string|max:255',
            'unit_kerja_id' => 'nullable|exists:eprofile.unit_kerja,id',
            'jenis_pegawai' => 'nullable',
            'profesi_id' => 'nullable|exists:eprofile.profesi,id',
            'cluster_1' => 'nullable|numeric|min:0',
            'cluster_2' => 'nullable|numeric|min:0',
            'cluster_3' => 'nullable|numeric|min:0',
            'cluster_4' => 'nullable|numeric|min:0',
            'is_deleted' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            IndeksPegawai::create($request->all());
            return ResponseFormatter::success(null, 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal disimpan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = IndeksPegawai::findOrFail($id);
            return ResponseFormatter::success($data->toArray(), 'Data berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:30',
            'nik' => 'required|string|max:20|unique:indeks_pegawai,nik,' . $id,
            'unit' => 'nullable|string|max:255',
            'unit_kerja_id' => 'nullable|exists:eprofile.unit_kerja,id',
            'jenis_pegawai' => 'nullable',
            'profesi_id' => 'nullable|exists:eprofile.profesi,id',
            'cluster_1' => 'nullable|numeric|min:0',
            'cluster_2' => 'nullable|numeric|min:0',
            'cluster_3' => 'nullable|numeric|min:0',
            'cluster_4' => 'nullable|numeric|min:0',
            'is_deleted' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $indeks = IndeksPegawai::findOrFail($id);
            $indeks->update($request->all());
            return ResponseFormatter::success(null, 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal diupdate: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $indeks = IndeksPegawai::findOrFail($id);
            // Soft delete - menandai sebagai dihapus tanpa benar-benar menghapus dari database
            $indeks->delete(); // Ini akan menggunakan soft delete
            return ResponseFormatter::success(null, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal dihapus: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $indeks = IndeksPegawai::withTrashed()->findOrFail($id);
            $indeks->restore();
            return ResponseFormatter::success(null, 'Data berhasil dipulihkan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal dipulihkan: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $indeks = IndeksPegawai::withTrashed()->findOrFail($id);
            $indeks->forceDelete(); // Hapus permanent
            return ResponseFormatter::success(null, 'Data berhasil dihapus permanen');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal dihapus permanen: ' . $e->getMessage());
        }
    }

    public function sync()
    {
       
        try {
            // Ambil semua data pegawai dari database eprofile dengan eager loading
            $pegawaiData = Pegawai::with(['mutasiAktif.unitKerja'])
                ->get();
          
            $syncedCount = 0;
            $updatedCount = 0;
            $errors = [];

            foreach ($pegawaiData as $pegawai) {
                try {
                    // Cek apakah pegawai sudah ada di indeks_pegawai berdasarkan NIK
                    $indeksPegawai = IndeksPegawai::where('nik', $pegawai->nik)->first();
                    
                    // Ambil unit dari mutasi aktif
                    $unit = "-";
                    $unitKerjaId = null;
                    if ($pegawai->mutasiAktif) {
                        $unitKerjaId = $pegawai->mutasiAktif->unit_kerja_id;
                        if ($pegawai->mutasiAktif->unitKerja) {
                            $unit = $pegawai->mutasiAktif->unitKerja->nama;
                        }
                    }
                    
                    $dataToSync = [
                        'nama' => $pegawai->nama,
                        'nip' => $pegawai->nip,
                        'nik' => $pegawai->nik,
                        'unit' => $unit,
                        'unit_kerja_id' => $unitKerjaId,
                        'jenis_pegawai' => $pegawai->jenis_pegawai,
                        'profesi_id' => $pegawai->profesi_id,
                    ];

                    if ($indeksPegawai) {
                        // Update data yang sudah ada
                        IndeksPegawai::where('nik', $pegawai->nik)->update($dataToSync);
                        $updatedCount++;
                    } else {
                        // Buat data baru
                        IndeksPegawai::create($dataToSync);
                        $syncedCount++;
                    }
                } catch (\Exception $e) {
                    $errors[] = "Error untuk pegawai {$pegawai->nama} (NIK: {$pegawai->nik}): " . $e->getMessage();
                }
            }

            $message = "Sinkronisasi berhasil! Data baru: {$syncedCount}, Data diperbarui: {$updatedCount}";
            
            if (!empty($errors)) {
                $message .= ". Terdapat " . count($errors) . " error.";
                return ResponseFormatter::error($errors, $message, 422);
            }

            return ResponseFormatter::success([
                'synced_count' => $syncedCount,
                'updated_count' => $updatedCount
            ], $message);

        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Sinkronisasi gagal: ' . $e->getMessage(), 500);
        }
    }
}
