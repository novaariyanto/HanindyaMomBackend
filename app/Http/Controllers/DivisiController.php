<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Divisi::query();
            return DataTables::eloquent($query)
                ->addColumn('action', function (Divisi $divisi) {
                    return '
                        <a href="' . route('divisi.show', $divisi->uuid) . '" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>
                        <a href="#" data-url="' . route('divisi.edit', $divisi->uuid) . '" class="btn btn-warning btn-sm btn-create"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('divisi.destroy', $divisi->uuid) . '"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $title = 'Divisi ';
        $slug = 'divisi';
        return view('pages.divisi.index', compact('slug', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('pages.divisi.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:191|unique:divisis,nama',
                'keterangan' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(
                    $validator->errors(), 
                    'Validasi gagal: ' . $validator->errors()->first(), 
                    422
                );
            }

            // Simpan data divisi
            $divisi = new Divisi;
            $divisi->nama = trim($request->nama);
            $divisi->keterangan = $request->keterangan ? trim($request->keterangan) : null;

            if (!$divisi->save()) {
                return ResponseFormatter::error(null, 'Gagal menyimpan data divisi', 500);
            }

            return ResponseFormatter::success(
                $divisi, 
                'Berhasil menyimpan divisi: ' . $divisi->nama
            );

        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Divisi $divisi, Request $request)
    {
        if ($request->ajax()) {
            return view('pages.divisi.edit', compact('divisi'));
        }
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Cari divisi berdasarkan UUID
            $divisi = Divisi::where('uuid', $id)->firstOrFail();

            // Validasi input dengan unique rule yang mengecualikan record saat ini
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:191|unique:divisis,nama,' . $divisi->id,
                'keterangan' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error(
                    $validator->errors(), 
                    'Validasi gagal: ' . $validator->errors()->first(), 
                    422
                );
            }

            // Update data divisi
            $divisi->nama = trim($request->nama);
            $divisi->keterangan = $request->keterangan ? trim($request->keterangan) : null;

            if (!$divisi->save()) {
                return ResponseFormatter::error(null, 'Gagal memperbarui data divisi', 500);
            }

            return ResponseFormatter::success(
                $divisi, 
                'Berhasil memperbarui divisi: ' . $divisi->nama
            );

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ResponseFormatter::error(null, 'Divisi tidak ditemukan', 404);
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid){
        $divisi = Divisi::where('uuid', $uuid)->first();
        $slug = 'divisi';
        $title = 'Divisi '. $divisi->nama;
        return view('pages.divisi.show', compact('slug', 'title','divisi'));


    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Divisi $divisi)
    {
        if (!$divisi->delete()) {
            return ResponseFormatter::error([], 'Divisi gagal dihapus', 500);
        }
        return ResponseFormatter::success([], 'Divisi berhasil dihapus');
    }
}