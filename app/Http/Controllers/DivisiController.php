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
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:191',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Divisi: ' . $validator->errors()->first(), 422);
        }

        $divisi = new Divisi;
        $divisi->nama = $request->nama;
        $divisi->keterangan = $request->keterangan;

        if (!$divisi->save()) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Divisi', 500);
        }

        return ResponseFormatter::success($divisi, 'Berhasil Menyimpan Divisi');
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
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:191',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Mengubah Divisi', 422);
        }

        $divisi = Divisi::where('uuid',$id)->first();

        $divisi->nama = $request->nama;
        $divisi->keterangan = $request->keterangan;

        if (!$divisi->save()) {
            return ResponseFormatter::error(null, 'Gagal Mengubah Divisi', 500);
        }

        return ResponseFormatter::success($divisi, 'Berhasil Mengubah Divisi');
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