<?php

namespace App\Http\Controllers;

use App\Models\KategoriIndeksJasaTidakLangsung;
use App\Models\IndeksJasaTidakLangsung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KategoriIndeksJasaTidakLangsungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Jika request untuk mendapatkan semua data kategori (untuk dropdown)
        if ($request->has('get_all')) {
            $data = KategoriIndeksJasaTidakLangsung::where('status', 1)
                ->select('id', 'nama_kategori', 'status')
                ->orderBy('nama_kategori', 'asc')
                ->get();
            
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Data kategori berhasil diambil'
                ],
                'data' => $data
            ]);
        }

        if ($request->ajax()) {
            $data = KategoriIndeksJasaTidakLangsung::select('*');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status_badge', function($row) {
                    if ($row->status) {
                        return '<span class="badge bg-success">Aktif</span>';
                    } else {
                        return '<span class="badge bg-danger">Tidak Aktif</span>';
                    }
                })
                ->addColumn('action', function($row) {
                    $btn = '<div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item btn-edit" href="javascript:void(0)" data-url="'.route('kategori-tidak-langsung.edit', $row->id).'">
                                        <i class="ti ti-edit me-1"></i> Edit
                                    </a></li>
                                    <li><a class="dropdown-item btn-delete text-danger" href="javascript:void(0)" data-url="'.route('kategori-tidak-langsung.destroy', $row->id).'">
                                        <i class="ti ti-trash me-1"></i> Hapus
                                    </a></li>
                                </ul>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }
        
        return view('kategori-tidak-langsung.index');
    }
    public function getByKategori($kategoriId)
    {
        $jasa = IndeksJasaTidakLangsung::where('kategori_id', $kategoriId)->get();
        return response()->json([
            'meta' => ['code' => 200],
            'data' => $jasa
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255|unique:kategori_indeks_jasa_tidak_langsung,nama_kategori',
            'deskripsi' => 'nullable|string',
            'status' => 'required|boolean'
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique' => 'Nama kategori sudah ada',
            'status.required' => 'Status wajib dipilih'
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
            $kategori = KategoriIndeksJasaTidakLangsung::create($request->all());
            
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Kategori berhasil ditambahkan'
                ],
                'data' => $kategori
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $kategoriIndeksJasaTidakLangsung = KategoriIndeksJasaTidakLangsung::findOrFail($id);
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Data kategori ditemukan'
                ],
                'data' => $kategoriIndeksJasaTidakLangsung
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'code' => 404,
                    'message' => 'Data kategori tidak ditemukan'
                ]
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $kategoriIndeksJasaTidakLangsung = KategoriIndeksJasaTidakLangsung::findOrFail($id);
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Data kategori ditemukan'
                ],
                'data' => $kategoriIndeksJasaTidakLangsung
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'meta' => [
                    'code' => 404,
                    'message' => 'Data kategori tidak ditemukan'
                ]
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $kategoriIndeksJasaTidakLangsung = KategoriIndeksJasaTidakLangsung::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'nama_kategori' => 'required|string|max:255|unique:kategori_indeks_jasa_tidak_langsung,nama_kategori,'.$kategoriIndeksJasaTidakLangsung->id,
                'deskripsi' => 'nullable|string',
                'status' => 'required|boolean'
            ], [
                'nama_kategori.required' => 'Nama kategori wajib diisi',
                'nama_kategori.unique' => 'Nama kategori sudah ada',
                'status.required' => 'Status wajib dipilih'
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

            $kategoriIndeksJasaTidakLangsung->update($request->all());
            
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Kategori berhasil diperbarui'
                ],
                'data' => $kategoriIndeksJasaTidakLangsung
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $kategoriIndeksJasaTidakLangsung = KategoriIndeksJasaTidakLangsung::findOrFail($id);
            
            
            $kategoriIndeksJasaTidakLangsung->delete();
            
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Kategori berhasil dihapus'
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
