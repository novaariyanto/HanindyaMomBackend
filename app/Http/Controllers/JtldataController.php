<?php

namespace App\Http\Controllers;

use App\Models\Jtldata;
use App\Models\RemunerasiSource;
use App\Models\JtlPegawaiIndeksSource;
use App\Exports\JtldataExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JtldataController extends Controller
{
    /**
     * Menampilkan daftar data JTL.
     */
    public function index(Request $request,$id_remunerasi_source)
    {
        if ($request->ajax()) {
            try {
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
                    ->addColumn('allpegawai_formatted', function($row){
                        return $row->allpegawai == 1 ? 'Ya' : 'Tidak';
                    })
                    ->addColumn('action', function($row){
                        return '
                           
                            <a href="#" data-url="' . route('jtldata.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                                <i class="ti ti-trash"></i>
                            </a>
                        ';
                         // <a href="#" data-url="' . route('jtldata.show', $row->id) . '" class="btn btn-warning btn-sm btn-edit" title="Edit">
                            //     <i class="ti ti-pencil"></i>
                            // </a>
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } catch (\Exception $e) {
                \Log::error('JTL Data error: ' . $e->getMessage());
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        $remunerasiSources = RemunerasiSource::where('status', 'aktif')->where('batch_id', '!=', null)->where('id', $id_remunerasi_source)->get();
        return view('jtldata.index', compact('remunerasiSources','id_remunerasi_source'));
    }

    /**
     * Menyimpan data JTL baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_remunerasi_source' => 'required|exists:remunerasi_source,id',
            'jumlah_jtl' => 'required|numeric|min:0',
            'nama_pembagian' => 'required|string|max:255',
            'jumlah_indeks' => 'required|numeric|min:0',
            'nilai_indeks' => 'required|numeric|min:0',
            'allpegawai' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            
            $data = $request->all();

            if (isset($data['allpegawai']) && $data['allpegawai'] == 0) {
                $data['nilai_indeks'] = 0;
                $data['jumlah_indeks'] = 0;
            }

            Jtldata::create($data);
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
            'nama_pembagian' => 'required|string|max:255',
            'jumlah_jtl' => 'required|numeric|min:0',
            'jumlah_indeks' => 'required|numeric|min:0',
            'nilai_indeks' => 'required|numeric|min:0',
            'allpegawai' => 'required|integer|min:0'
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
     * Mendapatkan jumlah JTL otomatis berdasarkan remunerasi source
     */
    public function getJumlahJtl(Request $request)
    {
        try {
            $remunerasiSourceId = $request->input('remunerasi_source_id');
            
            if (!$remunerasiSourceId) {
                return ResponseFormatter::error(null, 'Remunerasi source ID harus diisi', 422);
            }

            $jumlahJtl = JtlPegawaiIndeksSource::where('remunerasi_source', $remunerasiSourceId)
                                              ->sum('jumlah');

            return ResponseFormatter::success([
                'jumlah_jtl' => $jumlahJtl
            ], 'Jumlah JTL berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Gagal mengambil jumlah JTL: ' . $e->getMessage());
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

    /**
     * Export data JTL ke Excel.
     */
    public function export(Request $request, $id_remunerasi_source = null)
    {
        try {
            $export = new JtldataExport($id_remunerasi_source);
            $spreadsheet = $export->export();
            
            $fileName = 'Data_JTL_' . date('Y-m-d_H-i-s') . '.xlsx';
            
            // Create writer
            $writer = new Xlsx($spreadsheet);
            
            // Set headers for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');
            
            // Save to output
            $writer->save('php://output');
            exit;
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }
} 