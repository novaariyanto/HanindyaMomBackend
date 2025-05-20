<?php

namespace App\Http\Controllers;

use App\Models\RemunerasiBatch;
use App\Models\RemunerasiSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;

class RemunerasiBatchController extends Controller
{
    /**
     * Menampilkan daftar remunerasi batch.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RemunerasiBatch::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="' . route('remunerasi-source.list-by-batch', $row->id) . '" class="btn btn-primary btn-sm"><i class="ti ti-list"></i> Sources</a>
                        <a href="#" data-url="' . route('remunerasi-batch.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <a href="#" data-url="' . route('remunerasi-batch.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete"><i class="ti ti-trash"></i></a>
                    ';
                })
                ->editColumn('status', function($row) {
                    switch ($row->status) {
                        case 'draft':
                            return '<span class="badge bg-warning">Draft</span>';
                        case 'pending':
                            return '<span class="badge bg-info">Pending</span>';
                        case 'finalized':
                            return '<span class="badge bg-success">Finalized</span>';
                        default:
                            return '<span class="badge bg-danger">Unknown</span>';
                    }
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('remunerasi-batch.index');
    }

    /**
     * Menyimpan remunerasi batch baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_batch' => 'required|string|max:100|unique:remunerasi_batch,nama_batch',
            'tahun' => 'required|integer|min:2000|max:2100',
             'status' => 'required|in:draft,pending,finalized'
        ], [
            'nama_batch.required' => 'Nama batch harus diisi',
            'nama_batch.unique' => 'Nama batch sudah ada',
            'nama_batch.max' => 'Nama batch maksimal 100 karakter',
            'tahun.required' => 'Tahun harus diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'tahun.min' => 'Tahun minimal 2000',
            'tahun.max' => 'Tahun maksimal 2100',
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status harus draft, pending, atau finalized'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $batch = RemunerasiBatch::create($request->all());
            return ResponseFormatter::success($batch, 'Data batch berhasil ditambahkan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat menyimpan data', 500);
        }
    }

    /**
     * Menampilkan remunerasi batch spesifik.
     */
    public function show($id)
    {
        try {
            $batch = RemunerasiBatch::findOrFail($id);
            return ResponseFormatter::success($batch, 'Data batch berhasil ditemukan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }
    }

    /**
     * Mengupdate remunerasi batch yang ada.
     */
    public function update(Request $request, $id)
    {
        $batch = RemunerasiBatch::find($id);

        if (!$batch) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_batch' => 'required|string|max:100|unique:remunerasi_batch,nama_batch,'.$id,
            'tahun' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:draft,pending,finalized'
        ], [
            'nama_batch.required' => 'Nama batch harus diisi',
            'nama_batch.unique' => 'Nama batch sudah ada',
            'nama_batch.max' => 'Nama batch maksimal 100 karakter',
            'tahun.required' => 'Tahun harus diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'tahun.min' => 'Tahun minimal 2000',
            'tahun.max' => 'Tahun maksimal 2100',
            'status.required' => 'Status harus diisi',
            'status.in' => 'Status harus draft, pending, atau finalized'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $batch->update($request->all());
            return ResponseFormatter::success($batch, 'Data batch berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat mengupdate data', 500);
        }
    }

    /**
     * Menghapus remunerasi batch.
     */
    public function destroy($id)
    {
        try {
            $batch = RemunerasiBatch::findOrFail($id);
            $batch->delete();
            return ResponseFormatter::success(null, 'Data batch berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat menghapus data', 500);
        }
    }
} 