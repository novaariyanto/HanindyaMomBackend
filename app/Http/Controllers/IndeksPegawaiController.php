<?php

namespace App\Http\Controllers;

use App\Models\IndeksPegawai;
use App\Models\Profesi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;

class IndeksPegawaiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = IndeksPegawai::with('profesi');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('profesi_nama', function($row) {
                    return $row->profesi ? $row->profesi->nama : '-';
                })
                ->addColumn('jenis_pegawai_label', function($row) {
                    return $row->jenis_pegawai_label;
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

        $profesi = Profesi::all();
        return view('indeks-pegawai.index', compact('profesi'));
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:30',
            'nik' => 'required|string|max:20|unique:indeks_pegawai',
            'unit' => 'nullable|string|max:255',
            'jenis_pegawai' => 'nullable|in:PNS,PPPK,KONTRAK,HONORER',
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
            'nip' => 'required|string|max:30|unique:indeks_pegawai,nip,' . $id,
            'nik' => 'required|string|max:20|unique:indeks_pegawai,nik,' . $id,
            'unit' => 'nullable|string|max:255',
            'jenis_pegawai' => 'nullable|in:PNS,PPPK,KONTRAK,HONORER',
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
}
