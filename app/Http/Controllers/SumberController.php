<?php

namespace App\Http\Controllers;

use App\Models\Sumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;

class SumberController extends Controller
{
    /**
     * Menampilkan daftar sumber.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Sumber::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('sumber.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('sumber.destroy', $row->id) . '"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('sumber.index');
    }

    /**
     * Menyimpan sumber baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:sumber,name',
        ], [
            'name.required' => 'Nama sumber harus diisi',
            'name.unique' => 'Nama sumber sudah ada',
            'name.max' => 'Nama sumber maksimal 50 karakter'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $sumber = Sumber::create($request->all());
            return ResponseFormatter::success($sumber, 'Data sumber berhasil ditambahkan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat menyimpan data', 500);
        }
    }

    /**
     * Menampilkan sumber spesifik.
     */
    public function show($id)
    {
        try {
            $sumber = Sumber::findOrFail($id);
            return ResponseFormatter::success($sumber, 'Data sumber berhasil ditemukan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }
    }

    /**
     * Mengupdate sumber yang ada.
     */
    public function update(Request $request, $id)
    {
        $sumber = Sumber::find($id);

        if (!$sumber) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:sumber,name,'.$id,
        ], [
            'name.required' => 'Nama sumber harus diisi',
            'name.unique' => 'Nama sumber sudah ada',
            'name.max' => 'Nama sumber maksimal 50 karakter'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $sumber->update($request->all());
            return ResponseFormatter::success($sumber, 'Data sumber berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat mengupdate data', 500);
        }
    }

    /**
     * Menghapus sumber.
     */
    public function destroy($id)
    {
        try {
            \Log::info('Attempting to delete sumber with ID: ' . $id);
            
            $sumber = Sumber::findOrFail($id);
            \Log::info('Sumber found:', ['sumber' => $sumber->toArray()]);
            
            $sumber->delete();
            \Log::info('Sumber deleted successfully');

            return ResponseFormatter::success(null, 'Data sumber berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting sumber: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage(), 500);
        }
    }
} 