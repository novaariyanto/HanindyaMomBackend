<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;

class GradeController extends Controller
{
    /**
     * Menampilkan daftar grade.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Grade::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('grade.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('grade.destroy', $row->id) . '"><i class="ti ti-trash"></i></button>';
                })
                ->editColumn('persentase', function($row) {
                    return number_format($row->persentase, 2);
                })
                ->editColumn('persentase_top', function($row) {
                    return number_format($row->persentase_top, 2);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('grade.index');
    }

    /**
     * Menyimpan grade baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grade' => 'required|string|max:50|unique:grade,grade',
            'persentase' => 'required|numeric|between:0,100',
             'persentase_top' => 'required|numeric|between:0,100'
        ], [
            'grade.required' => 'Grade harus diisi',
            'grade.unique' => 'Grade sudah ada',
            'grade.max' => 'Grade maksimal 50 karakter',
            'persentase.required' => 'Persentase bottom harus diisi',
            'persentase.numeric' => 'Persentase bottom harus berupa angka',
            'persentase.between' => 'Persentase bottom harus antara 0 dan 100',
            'persentase_top.required' => 'Persentase top harus diisi',
            'persentase_top.numeric' => 'Persentase top harus berupa angka',
            'persentase_top.between' => 'Persentase top harus antara 0 dan 100'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $grade = Grade::create($request->all());
            return ResponseFormatter::success($grade, 'Data grade berhasil ditambahkan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat menyimpan data', 500);
        }
    }

    /**
     * Menampilkan grade spesifik.
     */
    public function show($id)
    {
        try {
            $grade = Grade::findOrFail($id);
            return ResponseFormatter::success($grade, 'Data grade berhasil ditemukan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }
    }

    /**
     * Mengupdate grade yang ada.
     */
    public function update(Request $request, $id)
    {
        $grade = Grade::find($id);

        if (!$grade) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }

        $validator = Validator::make($request->all(), [
            'grade' => 'required|string|max:50|unique:grade,grade,'.$id,
            'persentase' => 'required|numeric|between:0,100',
              'persentase_top' => 'required|numeric|between:0,100'
        ], [
            'grade.required' => 'Grade harus diisi',
            'grade.unique' => 'Grade sudah ada',
            'grade.max' => 'Grade maksimal 50 karakter',
            'persentase.required' => 'Persentase bottom harus diisi',
            'persentase.numeric' => 'Persentase bottom harus berupa angka',
            'persentase.between' => 'Persentase bottom harus antara 0 dan 100',
            'persentase_top.required' => 'Persentase top harus diisi',
            'persentase_top.numeric' => 'Persentase top harus berupa angka',
            'persentase_top.between' => 'Persentase top harus antara 0 dan 100'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $grade->update($request->all());
            return ResponseFormatter::success($grade, 'Data grade berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat mengupdate data', 500);
        }
    }

    /**
     * Menghapus grade.
     */
    public function destroy($id)
    {
        try {
            \Log::info('Attempting to delete grade with ID: ' . $id);
            
            $grade = Grade::findOrFail($id);
            \Log::info('Grade found:', ['grade' => $grade->toArray()]);
            
            $grade->delete();
            \Log::info('Grade deleted successfully');

            return ResponseFormatter::success(null, 'Data grade berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error deleting grade: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage(), 500);
        }
    }
} 