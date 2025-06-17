<?php

namespace App\Http\Controllers;

use App\Models\SubCluster;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;

class SubClusterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubCluster::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="d-flex justify-content-center gap-2">';
                    $actionBtn .= '<a href="javascript:void(0)" class="btn btn-primary btn-sm btn-edit" data-url="' . route('sub-cluster.edit', $row->id) . '"><i class="ti ti-pencil"></i></a>';
                    $actionBtn .= '<a href="javascript:void(0)" class="btn btn-danger btn-sm btn-delete" data-url="' . route('sub-cluster.destroy', $row->id) . '"><i class="ti ti-trash"></i></a>';
                    $actionBtn .= '</div>';
                    return $actionBtn;
                })
                ->addColumn('nilai_', function ($row) {
                    return $row->jenis == 'fix' ? 'Rp ' . number_format($row->nilai, 0, ',', '.') : '-';
                })
                ->rawColumns(['action','nilai_'])
                ->make(true);
        }

        return view('sub-cluster.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ppa' => 'required|string|max:255',
            'cluster' => 'required|string|max:255',
            'jenis' => 'required|in:fix,dinamis'
        ]);

        try {
            $subCluster = SubCluster::create($request->all());
            return ResponseFormatter::success($subCluster, 'Data Sub Cluster berhasil ditambahkan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat menyimpan data ', 500);
        }
    }

    public function edit($id)
    {
        try {
            $subCluster = SubCluster::findOrFail($id);
            return ResponseFormatter::success($subCluster, 'Data Sub Cluster berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ppa' => 'required|string|max:255',
            'cluster' => 'required|string|max:255',
            'jenis' => 'required|in:fix,dinamis'
        ]);

        try {
            $subCluster = SubCluster::findOrFail($id);
            $subCluster->update($request->all());
            return ResponseFormatter::success($subCluster, 'Data Sub Cluster berhasil diubah');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat mengubah data', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $subCluster = SubCluster::findOrFail($id);
            $subCluster->delete();
            return ResponseFormatter::success($subCluster, 'Data Sub Cluster berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat menghapus data', 500);
        }
    }
} 