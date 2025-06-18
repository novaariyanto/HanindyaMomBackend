<?php

namespace App\Http\Controllers;

use App\Models\Jtldata;
use App\Models\RemunerasiSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;

class JtldataController extends Controller
{
    /**
     * Menampilkan daftar data JTL.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Jtldata::with('remunerasiSource');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('remunerasi_source', function($row){
                    return $row->remunerasiSource ? $row->remunerasiSource->nama_source : '-';
                })
                ->addColumn('jumlah_jtl_formatted', function($row){
                    return number_format($row->jumlah_jtl, 2);
                })
                ->addColumn('jumlah_indeks_formatted', function($row){
                    return number_format($row->jumlah_indeks, 2);
                })
                ->addColumn('nilai_indeks_formatted', function($row){
                    return number_format($row->nilai_indeks, 2);
                })
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('jtldata.show', $row->id) . '" class="btn btn-warning btn-sm btn-edit" title="Edit">
                            <i class="ti ti-pencil"></i>
                        </a>
                        <a href="#" data-url="' . route('jtldata.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                            <i class="ti ti-trash"></i>
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $remunerasiSources = RemunerasiSource::where('status', 'aktif')->get();
        return view('jtldata.index', compact('remunerasiSources'));
    }

    /**
     * Menyimpan data JTL baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_remunerasi_source' => 'required|exists:remunerasi_source,id',
            'jumlah_jtl' => 'required|numeric|min:0',
            'jumlah_indeks' => 'required|numeric|min:0',
            'nilai_indeks' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            Jtldata::create($request->all());
            return ResponseFormatter::success(null, 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal disimpan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail data JTL.
     */
    public function show($id)
    {
        try {
            $data = Jtldata::with('remunerasiSource')->findOrFail($id);
            return ResponseFormatter::success($data, 'Data berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan');
        }
    }

    /**
     * Mengupdate data JTL.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_remunerasi_source' => 'required|exists:remunerasi_source,id',
            'jumlah_jtl' => 'required|numeric|min:0',
            'jumlah_indeks' => 'required|numeric|min:0',
            'nilai_indeks' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $jtldata = Jtldata::findOrFail($id);
            $jtldata->update($request->all());
            return ResponseFormatter::success(null, 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal diupdate: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data JTL.
     */
    public function destroy($id)
    {
        try {
            $jtldata = Jtldata::findOrFail($id);
            $jtldata->delete();
            return ResponseFormatter::success(null, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal dihapus: ' . $e->getMessage());
        }
    }
} 