<?php

namespace App\Http\Controllers;

use App\Models\IndeksJasaTidakLangsung;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;

class IndeksJasaTidakLangsungController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = IndeksJasaTidakLangsung::with('kategori')->select('*');
            
            // Filter berdasarkan kategori jika ada
            if ($request->filled('kategori_filter')) {
                $query->where('kategori_id', $request->kategori_filter);
            }
            
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('kategori', function($row) {
                    return $row->kategori->nama_kategori;
                })
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('indeks-jasa-tidak-langsung.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <a href="#" data-url="' . route('indeks-jasa-tidak-langsung.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete"><i class="ti ti-trash"></i></a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('indeks-jasa-tidak-langsung.index');
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'nama_indeks' => 'required|string|max:100',
            'nilai' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategori_indeks_jasa_tidak_langsung,id'
        ], [
            'nama_indeks.required' => 'Nama indeks wajib diisi',
            'nilai.required' => 'Nilai wajib diisi',
            'nilai.numeric' => 'Nilai harus berupa angka',
            'nilai.min' => 'Nilai minimal 0',
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            IndeksJasaTidakLangsung::create($request->all());
            return ResponseFormatter::success(null, 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal disimpan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = IndeksJasaTidakLangsung::with('kategori')->findOrFail($id);
            return ResponseFormatter::success($data, 'Data berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'nama_indeks' => 'required|string|max:100',
            'nilai' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategori_indeks_jasa_tidak_langsung,id'
        ], [
            'nama_indeks.required' => 'Nama indeks wajib diisi',
            'nilai.required' => 'Nilai wajib diisi',
            'nilai.numeric' => 'Nilai harus berupa angka',
            'nilai.min' => 'Nilai minimal 0',
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $indeks = IndeksJasaTidakLangsung::findOrFail($id);
            $indeks->update($request->all());
            return ResponseFormatter::success(null, 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal diupdate: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $indeks = IndeksJasaTidakLangsung::findOrFail($id);
            $indeks->delete();
            return ResponseFormatter::success(null, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
} 