<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Jabatan::query();
            return DataTables::eloquent($query)
                ->addColumn('action', function (Jabatan $jabatan) {
                    return '
                        <a href="' . route('jabatan.show', $jabatan->uuid) . '" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>
                        <a href="#" data-url="' . route('jabatan.edit', $jabatan->uuid) . '" class="btn btn-warning btn-sm btn-create"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('jabatan.destroy', $jabatan->uuid) . '"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $title = 'Jabatan ';
        $slug = 'jabatan';
        return view('pages.jabatan.index', compact('slug', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('pages.jabatan.create');
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
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Jabatan: ' . $validator->errors()->first(), 422);
        }

        $jabatan = new Jabatan;
        $jabatan->nama = $request->nama;
        $jabatan->keterangan = $request->keterangan;

        if (!$jabatan->save()) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Jabatan', 500);
        }

        return ResponseFormatter::success($jabatan, 'Berhasil Menyimpan Jabatan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan, Request $request)
    {
        if ($request->ajax()) {
            return view('pages.jabatan.edit', compact('jabatan'));
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
            return ResponseFormatter::error($validator->errors(), 'Gagal Mengubah Jabatan', 422);
        }

        $jabatan = Jabatan::where('uuid', $id)->first();

        $jabatan->nama = $request->nama;
        $jabatan->keterangan = $request->keterangan;

        if (!$jabatan->save()) {
            return ResponseFormatter::error(null, 'Gagal Mengubah Jabatan', 500);
        }

        return ResponseFormatter::success($jabatan, 'Berhasil Mengubah Jabatan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('pages.jabatan.show', compact('jabatan'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan)
    {
        if (!$jabatan->delete()) {
            return ResponseFormatter::error([], 'Jabatan gagal dihapus', 500);
        }
        return ResponseFormatter::success([], 'Jabatan berhasil dihapus');
    }
}