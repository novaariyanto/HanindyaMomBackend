<?php

namespace App\Http\Controllers;

use App\Models\RemunerasiSource;
use App\Models\RemunerasiBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Models\Tadmission;
use App\Models\DetailSource;

class RemunerasiSourceController extends Controller
{
    /**
     * Menampilkan daftar remunerasi source.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RemunerasiSource::with('batch');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="' . route('detail-source.listBySource', $row->id) . '" class="btn btn-info btn-sm" title="Lihat Detail Source">
                            <i class="ti ti-list"></i>
                        </a>
                        
                        <a href="#" data-url="' . route('remunerasi-source.show', $row->id) . '" class="btn btn-warning btn-sm btn-edit" title="Edit">
                            <i class="ti ti-pencil"></i>
                        </a>
                        <a href="#" data-url="' . route('remunerasi-source.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                            <i class="ti ti-trash"></i>
                        </a>
                        
                       
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $batches = RemunerasiBatch::get();
        return view('remunerasi-source.index', compact('batches'));
    }

    /**
     * Menyimpan remunerasi source baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_source' => 'required|string|max:100|unique:remunerasi_source,nama_source',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'batch_id' => 'nullable|exists:remunerasi_batch,id'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            RemunerasiSource::create($request->all());
            return ResponseFormatter::success(null, 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal disimpan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail remunerasi source.
     */
    public function show($id)
    {
        try {
            $data = RemunerasiSource::findOrFail($id);
            return ResponseFormatter::success($data, 'Data berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan');
        }
    }

    /**
     * Mengupdate remunerasi source.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_source' => 'required|string|max:100|unique:remunerasi_source,nama_source,' . $id,
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
            'batch_id' => 'nullable|exists:remunerasi_batch,id'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $source = RemunerasiSource::findOrFail($id);
            $source->update($request->all());
            return ResponseFormatter::success(null, 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal diupdate: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus remunerasi source.
     */
    public function destroy($id)
    {
        try {
            $source = RemunerasiSource::findOrFail($id);
            $source->delete();
            return ResponseFormatter::success(null, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal dihapus: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman list source berdasarkan batch.
     */
    public function listByBatch($batchId)
    {
        try {
            $batch = RemunerasiBatch::findOrFail($batchId);
            return view('remunerasi-source.list', compact('batch'));
        } catch (\Exception $e) {
            return redirect()->route('remunerasi-batch.index')
                ->with('error', 'Batch tidak ditemukan');
        }
    }

    /**
     * Get data source berdasarkan batch untuk DataTables.
     */
    public function getByBatch(Request $request, $batchId)
    {
        if ($request->ajax()) {
            $data = RemunerasiSource::where('batch_id', $batchId);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="' . route('detail-source.listBySource', $row->id) . '" class="btn btn-warning btn-sm" title="Lihat Detail Source">
                            <i class="ti ti-list"></i>
                        </a>
                         <a href="' . route('pembagian-klaim.laporan', ['sourceId' => $row->id]) . '" class="btn btn-success btn-sm" title="Lihat Laporan Pembagian Klaim">
                            <i class="ti ti-file"></i>
                        </a>
                          <a href="' . route('detail-source.showpembagian', ['id' => $row->id]) . '" class="btn btn-secondary btn-sm" title="Lihat Laporan Pembagian Klaim">
                            <i class="ti ti-eye"></i>
                        </a>
                        <a href="' . route('jtldata.index', $row->id) . '" class="btn btn-primary btn-sm" title="Proses JTL">
                            <i class="ti ti-plus"></i>
                        </a>
                        <a href="' . route('detail-source.listIndeksbySource', $row->id) . '" class="btn btn-primary btn-sm" title="Proses Indeks Pegawai">
                            <i class="ti ti-file-search "></i>
                        </a>
                         <a href="' . route('jtl-pegawai-hasil.by-remunerasi-source', $row->id) . '" class="btn btn-primary btn-sm" title="Hasil Pembagian JTL">
                            <i class="ti ti-shopping-cart "></i>
                        </a>
                        <a href="#" data-url="' . route('remunerasi-source.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <a href="#" data-url="' . route('remunerasi-source.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete"><i class="ti ti-trash"></i></a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        return abort(404);
    }
    public function addSourcebyidxdaftar(Request $request)
    {
        $idxdaftar = $request->idxdaftar;
        $data = Tadmission::where('id_admission',$idxdaftar)->first();
        $totalTarifRs = $data->getTotalTarifRsAttribute();
        $data->total_tarif_rs = $totalTarifRs;

        echo json_encode($data);
    }

    public function importAdmission(Request $request)
    {
        if ($request->ajax()) {
            $data = Tadmission::with(['pasien','billranap','billrajal']);
            
            // Default filter untuk bulan dan tahun sekarang
            $bulan = $request->get('bulan', date('n')); 
            $tahun = $request->get('tahun', date('Y')); 
            
            if ($bulan && $tahun) {
                $data->whereMonth('keluarrs', $bulan)
                     ->whereYear('keluarrs', $tahun);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('total_tarif_rs', function ($row) {
                    return number_format($row->total_tarif_rs, 0, ',', '.');
                })
                  ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="admission-checkbox" value="'.$row->ID_ADMISSION.'">';
                })
                ->rawColumns(['checkbox'])
               
                ->rawColumns(['action'])
                ->make(true);
        }

        $batches = RemunerasiBatch::where('status', 'draft')->get();
        return view('remunerasi-source.import-admission', compact('batches'));
    }

    public function storeFromAdmission(Request $request)
    {
        $request->validate([
            'admission_ids' => 'required|array',
            'admission_ids.*' => 'required|string',
            'batch_id' => 'required|exists:remunerasi_batch,id'
        ]);

        try {
            DB::beginTransaction();

            $batch = RemunerasiBatch::findOrFail($request->batch_id);
            if ($batch->status !== 'draft') {
                throw new \Exception('Batch harus berstatus draft');
            }

            $admissionData = DB::connection('sqlsrv')
                ->table('ADMISSION')
                ->join('PASIEN', 'ADMISSION.NORM', '=', 'PASIEN.NORM')
                ->whereIn('ADMISSION.ID_ADMISSION', $request->admission_ids)
                ->get();

            foreach ($admissionData as $admission) {
                // Create remunerasi source
                $source = new RemunerasiSource();
                $source->batch_id = $request->batch_id;
                $source->admission_id = $admission->ID_ADMISSION;
                $source->no_rm = $admission->NORM;
                $source->nama_pasien = $admission->NAMA;
                $source->tgl_masuk = $admission->MASUKRS;
                $source->tgl_keluar = $admission->KELUARRS;
                $source->kelas = $admission->KELAS_TARIF;
                $source->total_biaya = $admission->TOTAL_TARIF_RS;
                $source->save();

                // Get billing details
                $billingDetails = DB::connection('sqlsrv')
                    ->table('BILLING')
                    ->where('ID_ADMISSION', $admission->ID_ADMISSION)
                    ->get();

                foreach ($billingDetails as $billing) {
                    $detailSource = new DetailSource();
                    $detailSource->remunerasi_source_id = $source->id;
                    $detailSource->kode_tarif = $billing->KODE_TARIF;
                    $detailSource->nama_tarif = $billing->NAMA_TARIF;
                    $detailSource->jumlah = $billing->JUMLAH;
                    $detailSource->tarif = $billing->TARIF;
                    $detailSource->total = $billing->TOTAL;
                    $detailSource->save();
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diimport'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal import data: ' . $e->getMessage()
            ], 500);
        }
    }
} 