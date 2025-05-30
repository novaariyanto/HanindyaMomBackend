<?php

namespace App\Http\Controllers;

use App\Models\TransaksiRemunerasiPegawai;
use App\Models\Pegawai;
use App\Models\RemunerasiBatch;
use App\Models\RemunerasiSource;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TransaksiRemunerasiPegawaiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = TransaksiRemunerasiPegawai::with(['pegawai', 'remunerasiBatch', 'remunerasiSource']);
            
            if (request()->has('batch') && request()->batch != '') {
                $data->where('id_remunerasi_batch', request()->batch);
            }
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('transaksi-remunerasi-pegawai.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <a href="#" data-url="' . route('transaksi-remunerasi-pegawai.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete"><i class="ti ti-trash"></i></a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $pegawai = Pegawai::all();
        $remunerasi_batch = RemunerasiBatch::all();
        $remunerasi_source = RemunerasiSource::all();
        
        return view('transaksi-remunerasi-pegawai.index', compact('pegawai', 'remunerasi_batch', 'remunerasi_source'));
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'id_remunerasi_batch' => 'required|exists:remunerasi_batch,id',
            'id_remunerasi_source' => 'required|exists:remunerasi_source,id',
            'indeks_cluster_1' => 'required|numeric|min:0',
            'indeks_cluster_2' => 'required|numeric|min:0',
            'indeks_cluster_3' => 'required|numeric|min:0',
            'indeks_cluster_4' => 'required|numeric|min:0',
            'nilai_indeks_1' => 'required|numeric|min:0',
            'nilai_indeks_2' => 'required|numeric|min:0',
            'nilai_indeks_3' => 'required|numeric|min:0',
            'nilai_indeks_4' => 'required|numeric|min:0',
            'nilai_remunerasi' => 'required|numeric|min:0',
            'id_pegawai' => 'required|exists:pegawai,id'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            TransaksiRemunerasiPegawai::create($request->all());
            return ResponseFormatter::success(null, 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal disimpan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = TransaksiRemunerasiPegawai::with(['pegawai', 'remunerasiBatch', 'remunerasiSource'])->findOrFail($id);
            return ResponseFormatter::success($data, 'Data berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'id_remunerasi_batch' => 'required|exists:remunerasi_batch,id',
            'id_remunerasi_source' => 'required|exists:remunerasi_source,id',
            'indeks_cluster_1' => 'required|numeric|min:0',
            'indeks_cluster_2' => 'required|numeric|min:0',
            'indeks_cluster_3' => 'required|numeric|min:0',
            'indeks_cluster_4' => 'required|numeric|min:0',
            'nilai_indeks_1' => 'required|numeric|min:0',
            'nilai_indeks_2' => 'required|numeric|min:0',
            'nilai_indeks_3' => 'required|numeric|min:0',
            'nilai_indeks_4' => 'required|numeric|min:0',
            'nilai_remunerasi' => 'required|numeric|min:0',
            'id_pegawai' => 'required|exists:pegawai,id'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $transaksi = TransaksiRemunerasiPegawai::findOrFail($id);
            $transaksi->update($request->all());
            return ResponseFormatter::success(null, 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal diupdate: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $transaksi = TransaksiRemunerasiPegawai::findOrFail($id);
            $transaksi->delete();
            return ResponseFormatter::success(null, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal dihapus: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        if ($request->action === 'prepare') {
            // Validasi file
            $validator = validator($request->all(), [
                'file' => 'required|mimes:xlsx,xls|max:10240'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'File tidak valid'
                ]);
            }

            // Hitung total baris
            $totalRows = 0;
            $reader = IOFactory::createReaderForFile($request->file('file'));
            $spreadsheet = $reader->load($request->file('file'));
            $worksheet = $spreadsheet->getActiveSheet();
            $totalRows = $worksheet->getHighestRow() - 1; // Kurangi 1 untuk header

            // Hitung jumlah chunk
            $chunkSize = 100;
            $totalChunks = ceil($totalRows / $chunkSize);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'total_rows' => $totalRows,
                    'total_chunks' => $totalChunks
                ]
            ]);
        } else if ($request->action === 'process') {
            $chunk = $request->chunk;
            $totalChunks = $request->total_chunks;
            $chunkSize = 100;

            $reader = IOFactory::createReaderForFile($request->file('file'));
            $spreadsheet = $reader->load($request->file('file'));
            $worksheet = $spreadsheet->getActiveSheet();

            $startRow = ($chunk - 1) * $chunkSize + 2; // Mulai dari baris 2 (setelah header)
            $endRow = min($startRow + $chunkSize - 1, $worksheet->getHighestRow());

            $success = 0;
            $failed = 0;

            for ($row = $startRow; $row <= $endRow; $row++) {
                try {
                    $data = [
                        'id_pegawai' => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                        'id_remunerasi_batch' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                        'id_remunerasi_source' => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                        'indeks_cluster_1' => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
                        'indeks_cluster_2' => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
                        'indeks_cluster_3' => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
                        'indeks_cluster_4' => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
                        'nilai_indeks_1' => $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
                        'nilai_indeks_2' => $worksheet->getCellByColumnAndRow(9, $row)->getValue(),
                        'nilai_indeks_3' => $worksheet->getCellByColumnAndRow(10, $row)->getValue(),
                        'nilai_indeks_4' => $worksheet->getCellByColumnAndRow(11, $row)->getValue(),
                        'nilai_remunerasi' => $worksheet->getCellByColumnAndRow(12, $row)->getValue(),
                    ];

                    TransaksiRemunerasiPegawai::create($data);
                    $success++;
                } catch (\Exception $e) {
                    $failed++;
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'success' => $success,
                    'failed' => $failed
                ]
            ]);
        }
    }

    public function template()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $headers = [
            'ID Pegawai',
            'ID Batch Remunerasi',
            'ID Source Remunerasi',
            'Indeks Cluster 1',
            'Indeks Cluster 2',
            'Indeks Cluster 3',
            'Indeks Cluster 4',
            'Nilai Indeks 1',
            'Nilai Indeks 2',
            'Nilai Indeks 3',
            'Nilai Indeks 4',
            'Nilai Remunerasi'
        ];

        foreach ($headers as $key => $header) {
            $sheet->setCellValueByColumnAndRow($key + 1, 1, $header);
        }

        // Set style header
        $headerStyle = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'E2EFDA',
                ],
            ],
        ];

        $sheet->getStyle('A1:L1')->applyFromArray($headerStyle);

        // Set column width
        foreach (range('A', 'L') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'template_import_transaksi_remunerasi.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function getUnsyncedCount()
    {
        $count = TransaksiRemunerasiPegawai::whereNull('synced_at')->count();
        return response()->json(['total' => $count]);
    }

    public function syncBatch(Request $request)
    {
        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 5;

        $records = TransaksiRemunerasiPegawai::whereNull('synced_at')
            ->skip($offset)
            ->take($limit)
            ->get();

        $processed = 0;
        $success = 0;
        $failed = 0;

        foreach ($records as $record) {
            try {
                // Proses sinkronisasi di sini
                $record->update(['synced_at' => now()]);
                $success++;
            } catch (\Exception $e) {
                $failed++;
            }
            $processed++;
        }

        return response()->json([
            'processed' => $processed,
            'success' => $success,
            'failed' => $failed,
            'hasMore' => TransaksiRemunerasiPegawai::whereNull('synced_at')->count() > 0
        ]);
    }
}