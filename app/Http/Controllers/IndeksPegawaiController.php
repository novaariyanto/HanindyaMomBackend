<?php

namespace App\Http\Controllers;

use App\Models\IndeksPegawai;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;

class IndeksPegawaiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = IndeksPegawai::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('indeks-pegawai.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <a href="#" data-url="' . route('indeks-pegawai.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete"><i class="ti ti-trash"></i></a>
                    ';
                })
                ->editColumn('tmt_cpns', function($row) {
                    return $row->tmt_cpns ? $row->tmt_cpns->format('d/m/Y') : '';
                })
                ->editColumn('tmt_di_rs', function($row) {
                    return $row->tmt_di_rs ? $row->tmt_di_rs->format('d/m/Y') : '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('indeks-pegawai.index');
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:30|unique:indeks_pegawai',
            'tmt_cpns' => 'required|date',
            'tmt_di_rs' => 'required|date',
            'masa_kerja_di_rs' => 'required|string|max:50',
            'indeks_masa_kerja' => 'required|numeric|min:0|max:99.99',
            'kualifikasi_pendidikan' => 'required|string|max:100',
            'indeks_kualifikasi_pendidikan' => 'required|integer|min:0',
            'indeks_resiko' => 'required|integer|min:0',
            'indeks_emergency' => 'required|integer|min:0',
            'jabatan' => 'required|string|max:255',
            'indeks_posisi_unit_kerja' => 'required|integer|min:0',
            'ruang' => 'required|string|max:100',
            'indeks_jabatan_tambahan' => 'required|integer|min:0',
            'indeks_performa' => 'required|integer|min:0',
            'total' => 'required|numeric|min:0|max:999.99'
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
            return ResponseFormatter::success($data, 'Data berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:30|unique:indeks_pegawai,nip,' . $id,
            'tmt_cpns' => 'required|date',
            'tmt_di_rs' => 'required|date',
            'masa_kerja_di_rs' => 'required|string|max:50',
            'indeks_masa_kerja' => 'required|numeric|min:0|max:99.99',
            'kualifikasi_pendidikan' => 'required|string|max:100',
            'indeks_kualifikasi_pendidikan' => 'required|integer|min:0',
            'indeks_resiko' => 'required|integer|min:0',
            'indeks_emergency' => 'required|integer|min:0',
            'jabatan' => 'required|string|max:255',
            'indeks_posisi_unit_kerja' => 'required|integer|min:0',
            'ruang' => 'required|string|max:100',
            'indeks_jabatan_tambahan' => 'required|integer|min:0',
            'indeks_performa' => 'required|integer|min:0',
            'total' => 'required|numeric|min:0|max:999.99'
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
            $indeks->delete();
            return ResponseFormatter::success(null, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
}
