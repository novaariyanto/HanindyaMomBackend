<?php

namespace App\Http\Controllers;

use App\Models\IndeksJasaLangsungNonMedis;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;

class IndeksJasaLangsungNonMedisController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = IndeksJasaLangsungNonMedis::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('indeks-jasa-langsung-non-medis.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <a href="#" data-url="' . route('indeks-jasa-langsung-non-medis.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete"><i class="ti ti-trash"></i></a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('indeks-jasa-langsung-non-medis.index');
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'nama_jabatan' => 'required|string|max:100',
            'nilai' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            IndeksJasaLangsungNonMedis::create($request->all());
            return ResponseFormatter::success(null, 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal disimpan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = IndeksJasaLangsungNonMedis::findOrFail($id);
            return ResponseFormatter::success($data, 'Data berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'nama_jabatan' => 'required|string|max:100',
            'nilai' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $indeks = IndeksJasaLangsungNonMedis::findOrFail($id);
            $indeks->update($request->all());
            return ResponseFormatter::success(null, 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal diupdate: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $indeks = IndeksJasaLangsungNonMedis::findOrFail($id);
            $indeks->delete();
            return ResponseFormatter::success(null, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
} 