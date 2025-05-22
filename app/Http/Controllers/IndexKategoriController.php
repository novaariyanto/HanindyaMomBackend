<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\IndexKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class IndexKategoriController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = IndexKategori::query()->orderBy('id', 'asc');
            return DataTables::eloquent($query)
                ->addColumn('action', function (IndexKategori $kategori) {
                    return '
                        <a href="#" data-url="' . route('index-kategori.edit', $kategori->id) . '" class="btn btn-warning btn-sm btn-create"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('index-kategori.destroy', $kategori->id) . '"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $title = 'Index Grup';
        $slug = 'index-kategori';
        return view('pages.index-kategori.index', compact('slug', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('pages.index-kategori.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Kategori: ' . $validator->errors()->first(), 422);
        }

        $kategori = new IndexKategori;
        $kategori->nama = $request->nama;

        if (!$kategori->save()) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Kategori', 500);
        }

        return ResponseFormatter::success($kategori, 'Berhasil Menyimpan Kategori');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, Request $request)
    {
        // Temukan kategori berdasarkan ID
        $kategori = IndexKategori::findOrFail($id);

        // Jika request adalah AJAX, kembalikan view edit
        if ($request->ajax()) {
            return view('pages.index-kategori.edit', compact('kategori'));
        }

        // Jika bukan AJAX, kembalikan error 404
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Mengubah Kategori', 422);
        }

        $kategori = IndexKategori::findOrFail($id);
        $kategori->nama = $request->nama;

        if (!$kategori->save()) {
            return ResponseFormatter::error(null, 'Gagal Mengubah Kategori', 500);
        }

        return ResponseFormatter::success($kategori, 'Berhasil Mengubah Kategori');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kategori = IndexKategori::findOrFail($id);
        return view('pages.index-kategori.show', compact('kategori'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = IndexKategori::findOrFail($id);

        if (!$kategori->delete()) {
            return ResponseFormatter::error([], 'Kategori gagal dihapus', 500);
        }
        return ResponseFormatter::success([], 'Kategori berhasil dihapus');
    }
}
