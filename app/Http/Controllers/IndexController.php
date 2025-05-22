<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Index;
use App\Models\IndexKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Index::with('kategori')->select('index_grade.*'); // Include relasi kategori
            return DataTables::eloquent($query)
                ->addColumn('kategori_nama', function (Index $index) {
                    return $index->kategori ? $index->kategori->nama : '-';
                })
                ->addColumn('action', function (Index $index) {
                    return '
                        <a href="#" data-url="' . route('index.edit', $index->id) . '" class="btn btn-warning btn-sm btn-create"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('index.destroy', $index->id) . '"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $title = 'Index Grade';
        $slug = 'index';
        return view('pages.index.index', compact('slug', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Ambil semua data kategori dari tabel index_kategori
        $kategoris = IndexKategori::all();

        if ($request->ajax()) {
            return view('pages.index.create', compact('kategoris'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:191',
            'index' => 'required|numeric',
            'index_kategori_id' => 'nullable|exists:index_kategori,id', // Validasi foreign key
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Index: ' . $validator->errors()->first(), 422);
        }

        $index = new Index;
        $index->nama = $request->nama;
        $index->index = $request->index;
        $index->index_kategori_id = $request->index_kategori_id;

        if (!$index->save()) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Index', 500);
        }

        return ResponseFormatter::success($index, 'Berhasil Menyimpan Index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Index $index, Request $request)
    {
        // Ambil semua data kategori dari tabel index_kategori
        $kategoris = IndexKategori::all();

        if ($request->ajax()) {
            return view('pages.index.edit', compact('index', 'kategoris'));
        }

        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:191',
            'index' => 'required|numeric',
            'index_kategori_id' => 'nullable|exists:index_kategori,id', // Validasi foreign key
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Mengubah Index', 422);
        }

        $index = Index::findOrFail($id);
        $index->nama = $request->nama;
        $index->index = $request->index;
        $index->index_kategori_id = $request->index_kategori_id;

        if (!$index->save()) {
            return ResponseFormatter::error(null, 'Gagal Mengubah Index', 500);
        }

        return ResponseFormatter::success($index, 'Berhasil Mengubah Index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $index = Index::with('kategori')->findOrFail($id); // Include relasi kategori
        return view('pages.index.show', compact('index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Index $index)
    {
        if (!$index->delete()) {
            return ResponseFormatter::error([], 'Index gagal dihapus', 500);
        }
        return ResponseFormatter::success([], 'Index berhasil dihapus');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls', // Validasi tipe file
        ]);

        try {
            // Ambil file yang diunggah
            $file = $request->file('file');

            // Baca file Excel menggunakan PHPSpreadsheet
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Proses setiap baris (skip header jika ada)
            foreach ($rows as $index => $row) {
                if ($index === 0) {
                    continue; // Skip header row
                }

                // Validasi data dari Excel
                $nama = $row[0] ?? null;
                $index = $row[1] ?? null;
                $index_kategori_id = $row[2] ?? null;

                if (empty($nama) || empty($index)) {
                    continue; // Lewati baris kosong atau tidak valid
                }

                // Simpan data ke database
                \App\Models\Index::create([
                    'nama' => $nama,
                    'index' => $index,
                    'index_kategori_id' => $index_kategori_id,
                ]);
            }

            return redirect()->back()->with('success', 'Data berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }
}
