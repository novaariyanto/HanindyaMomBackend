<?php

namespace App\Http\Controllers;

use App\Models\PegawaiStruktural;
use App\Models\IndeksPegawai;
use App\Models\IndeksStruktural;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Validator;

class PegawaiStrukturalController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = PegawaiStruktural::with(['pegawai', 'jasa']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('pegawai_nama', function($row) {
                    return $row->pegawai ? $row->pegawai->nama : '-';
                })
                ->addColumn('jasa_nama', function($row) {
                    return $row->jasa ? $row->jasa->nama_jabatan : '-';
                })
                ->addColumn('nilai_formatted', function($row) {
                    return number_format($row->nilai, 2, ',', '.');
                })
                ->addColumn('action', function($row){
                    return '
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item btn-edit" href="javascript:void(0)" data-url="' . route('pegawai-struktural.update', $row->id) . '">
                                    <i class="ti ti-edit me-1"></i> Edit
                                </a></li>
                                <li><a class="dropdown-item btn-delete text-danger" href="javascript:void(0)" data-url="' . route('pegawai-struktural.destroy', $row->id) . '">
                                    <i class="ti ti-trash me-1"></i> Hapus
                                </a></li>
                            </ul>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $pegawai = IndeksPegawai::all();
        $jasa = IndeksStruktural::all();
        
        return view('pegawai-struktural.index', compact('pegawai', 'jasa'));
    }

    public function create()
    {
        // Return view untuk form create jika diperlukan
        $pegawai = IndeksPegawai::all();
        $jasa = IndeksStruktural::all();
        
        return view('pegawai-struktural.create', compact('pegawai', 'jasa'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pegawai_id' => 'required|exists:indeks_pegawai,id',
            'jasa_id' => 'required|exists:indeks_struktural,id',
            'nilai' => 'required|numeric|min:0'
        ], [
            'pegawai_id.required' => 'Pegawai wajib dipilih',
            'pegawai_id.exists' => 'Pegawai yang dipilih tidak valid',
            'jasa_id.required' => 'Jasa wajib dipilih',
            'jasa_id.exists' => 'Jasa yang dipilih tidak valid',
            'nilai.required' => 'Nilai wajib diisi',
            'nilai.numeric' => 'Nilai harus berupa angka',
            'nilai.min' => 'Nilai minimal 0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'code' => 422,
                    'message' => 'Validation Error'
                ],
                'data' => $validator->errors()
            ], 422);
        }

        try {
            $pegawaiJasa = PegawaiStruktural::create($request->all());
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Data berhasil disimpan'
                ],
                'data' => $pegawaiJasa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'code' => 500,
                    'message' => 'Terjadi kesalahan pada server'
                ]
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $data = PegawaiStruktural::with(['pegawai', 'jasa'])->findOrFail($id);
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Data berhasil diambil'
                ],
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'code' => 404,
                    'message' => 'Data tidak ditemukan'
                ]
            ], 404);
        }
    }

    public function edit($id)
    {
        try {
            $data = PegawaiStruktural::with(['pegawai', 'jasa'])->findOrFail($id);
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Data berhasil diambil'
                ],
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'code' => 404,
                    'message' => 'Data tidak ditemukan'
                ]
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pegawaiJasa = PegawaiStruktural::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'pegawai_id' => 'required|exists:indeks_pegawai,id',
                'jasa_id' => 'required|exists:indeks_struktural,id',
                'nilai' => 'required|numeric|min:0'
            ], [
                'pegawai_id.required' => 'Pegawai wajib dipilih',
                'pegawai_id.exists' => 'Pegawai yang dipilih tidak valid',
                'jasa_id.required' => 'Jasa wajib dipilih',
                'jasa_id.exists' => 'Jasa yang dipilih tidak valid',
                'nilai.required' => 'Nilai wajib diisi',
                'nilai.numeric' => 'Nilai harus berupa angka',
                'nilai.min' => 'Nilai minimal 0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'meta' => [
                        'code' => 422,
                        'message' => 'Validation Error'
                    ],
                    'data' => $validator->errors()
                ], 422);
            }

            $pegawaiJasa->update($request->all());
            
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Data berhasil diperbarui'
                ],
                'data' => $pegawaiJasa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'code' => 500,
                    'message' => 'Terjadi kesalahan pada server'
                ]
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pegawaiJasa = PegawaiStruktural::findOrFail($id);
            $pegawaiJasa->delete(); // Soft delete jika model menggunakan SoftDeletes
            
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Data berhasil dihapus'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'code' => 500,
                    'message' => 'Terjadi kesalahan pada server'
                ]
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $pegawaiJasa = PegawaiStruktural::withTrashed()->findOrFail($id);
            $pegawaiJasa->restore();
            
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Data berhasil dipulihkan'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'code' => 500,
                    'message' => 'Terjadi kesalahan pada server'
                ]
            ], 500);
        }
    }

    public function forceDelete($id)
    {
        try {
            $pegawaiJasa = PegawaiStruktural::withTrashed()->findOrFail($id);
            $pegawaiJasa->forceDelete();
            
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Data berhasil dihapus permanen'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'code' => 500,
                    'message' => 'Terjadi kesalahan pada server'
                ]
            ], 500);
        }
    }
} 