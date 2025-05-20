<?php

namespace App\Http\Controllers;

use App\Models\DetailSource;
use App\Models\RemunerasiSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DetailSourceImport;
use App\Exports\DetailSourceExport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;
use App\Models\Tbpjs;
use App\Models\Dokter;
use App\Models\ProporsiFairness;
use App\Models\Grade;
use App\Models\PembagianKlaim;
use App\Models\Tbillrajal;
use App\Models\Tbillranap;
use App\Models\Tpendaftaran;
use App\Models\Tadmission;
use App\Models\Moperasi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class DetailSourceController extends Controller
{
    /**
     * Menampilkan daftar detail source.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DetailSource::with('remunerasiSource');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('detail-source.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <a href="#" data-url="' . route('detail-source.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete"><i class="ti ti-trash"></i></a>
                    ';
                })
                ->editColumn('tgl_verifikasi', function($row) {
                    return $row->tgl_verifikasi->format('d/m/Y');
                })
                
                ->rawColumns(['action'])
                ->make(true);
        }

        $remunerasiSources = RemunerasiSource::where('status', 'aktif')->get();
        return view('detail-source.index', compact('remunerasiSources'));
    }

    /**
     * Menyimpan detail source baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_sep' => 'required|string|max:30|unique:detail_source,no_sep',
            'tgl_verifikasi' => 'required|date',
            'jenis' => 'required|string|max:50',
            'status' => 'required|integer',
            'id_remunerasi_source' => 'required|exists:remunerasi_source,id',
            'biaya_riil_rs' => 'required|numeric|min:0',
            'biaya_diajukan' => 'required|numeric|min:0',
            'biaya_disetujui' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            DetailSource::create($request->all());
            return ResponseFormatter::success(null, 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal disimpan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail source.
     */
    public function show($id)
    {
        try {
            if (request()->ajax()) {
                $data = DetailSource::with('remunerasiSource')->findOrFail($id);
                return ResponseFormatter::success($data, 'Data berhasil diambil');
            }

            $detail = DetailSource::with(['remunerasiSource','remunerasiSource2'])->findOrFail($id);
            return view('detail-source.show', compact('detail'));
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return ResponseFormatter::error(null, 'Data tidak ditemukan');
            }
            return redirect()->route('remunerasi-source.index')
                ->with('error', 'Data tidak ditemukan');
        }
    }

    /**
     * Mengupdate detail source.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'no_sep' => 'required|string|max:30',
            'tgl_verifikasi' => 'required|date',
            'jenis' => 'required|string|max:50',
            'status' => 'required|integer',
            'id_remunerasi_source' => 'required|exists:remunerasi_source,id',
            'biaya_riil_rs' => 'required|numeric|min:0',
            'biaya_diajukan' => 'required|numeric|min:0',
            'biaya_disetujui' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $detailSource = DetailSource::findOrFail($id);
            $detailSource->update($request->all());
            return ResponseFormatter::success(null, 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal diupdate: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus detail source.
     */
    public function destroy($id)
    {
        try {
            $detailSource = DetailSource::findOrFail($id);
            $detailSource->delete();
            return ResponseFormatter::success(null, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal dihapus: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail source berdasarkan remunerasi source.
     */
    public function listBySource($sourceId)
    {
        try {
            $source = RemunerasiSource::with('batch')->findOrFail($sourceId);
            return view('detail-source.list', compact('source'));
        } catch (\Exception $e) {
            return redirect()->route('remunerasi-source.index')
                ->with('error', 'Source tidak ditemukan');
        }
    }

    /**
     * Get data detail source berdasarkan remunerasi source untuk DataTables.
     */
    public function getBySource(Request $request, $sourceId)
    {
        if ($request->ajax()) {
            $data = DetailSource::where('id_remunerasi_source', $sourceId);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                       

                        $action = '
                        <a href="' . route('detail-source.show', $row->id) . '" class="btn btn-info btn-sm" title="Lihat Detail">
                            <i class="ti ti-eye"></i>
                        </a>
                        <a href="#" data-url="' . route('detail-source.show', $row->id) . '" class="btn btn-warning btn-sm btn-edit" title="Edit">
                            <i class="ti ti-pencil"></i>
                        </a>
                        <a href="#" data-url="' . route('detail-source.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete" title="Hapus">
                            <i class="ti ti-trash"></i>
                        </a>
                    ';
                    if($row->status_pembagian_klaim == 0) {
                        $action .= '<a href="#" onclick="syncSepData(\''.$row->no_sep.'\')" class="btn btn-primary btn-sm" title="Sinkronisasi Data SEP">
                                <i class="ti ti-refresh"></i>
                            </a>';
                    }
                    return $action;
                })
                
                ->editColumn('biaya_riil_rs', function($row) {
                    return '' . number_format($row->biaya_riil_rs, 0, ',', '.');
                })
                ->editColumn('biaya_diajukan', function($row) {
                    return '' . number_format($row->biaya_diajukan, 0, ',', '.');
                })
                ->editColumn('biaya_disetujui', function($row) {
                    return '' . number_format($row->biaya_disetujui, 0, ',', '.');
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        
        return abort(404);
    }

    /**
     * Import data dari Excel
     */
    public function import(Request $request, $sourceId)
    {
       
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls|max:2048'
        ], [
            'file.required' => 'File harus diupload',
            'file.file' => 'Upload harus berupa file',
            'file.mimes' => 'Format file harus xlsx atau xls',
            'file.max' => 'Ukuran file maksimal 2MB'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $file = $request->file('file');
            $action = $request->query('action', 'process');

            // Prepare import
            if ($action === 'prepare') {
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
                array_shift($rows); // Remove header

                // Filter out empty rows
                $rows = array_filter($rows, function($row) {
                    return !empty(array_filter($row));
                });

                $totalRows = count($rows);
                $chunkSize = 1; // Process 1 rows per chunk
                $totalChunks = ceil($totalRows / $chunkSize);

                // Store the file temporarily
                $tempPath = storage_path('app/temp');
                if (!file_exists($tempPath)) {
                    mkdir($tempPath, 0777, true);
                }
                $tempFile = $tempPath . '/import_' . time() . '.xlsx';
                $file->move($tempPath, basename($tempFile));

                // Store import session data
                session([
                    'import_file' => $tempFile,
                    'total_rows' => $totalRows,
                    'chunk_size' => $chunkSize,
                    'total_chunks' => $totalChunks
                ]);

                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'total_rows' => $totalRows,
                        'total_chunks' => $totalChunks
                    ]
                ]);
            }

            // Process chunk
            if ($action === 'process') {
                $chunk = $request->input('chunk', 1);
                $tempFile = session('import_file');
                $chunkSize = session('chunk_size');

                if (!file_exists($tempFile)) {
                    return ResponseFormatter::error(null, 'File import tidak ditemukan', 404);
                }

                $spreadsheet = IOFactory::load($tempFile);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
                array_shift($rows); // Remove header

                // Get chunk of rows
                $start = ($chunk - 1) * $chunkSize;
                $chunkRows = array_slice($rows, $start, $chunkSize);

                $success = 0;
                $failed = 0;
                $errors = [];

                foreach ($chunkRows as $index => $row) {
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    // Validasi no_sep unik untuk setiap baris
                    $noSep = $row[0];
                    if (DetailSource::where('no_sep', $noSep)->exists()) {
                        $failed++;
                        $errors[] = "Baris " . ($start + $index + 2) . ": No SEP '$noSep' sudah ada dalam database";
                        continue;
                    }

                    $rowData = [
                        'id_remunerasi_source' => $sourceId,
                        'no_sep' => $noSep,
                        'tgl_verifikasi' => $this->transformDate2($row[1]),
                        'biaya_riil_rs' => $this->transformToDecimal($row[2]),
                        'biaya_diajukan' => $this->transformToDecimal($row[3]),
                        'biaya_disetujui' => $this->transformToDecimal($row[4]),
                        'status' => strtolower($row[5]) == 'aktif' ? 1 : 0,
                        'jenis' => $row[6]
                    ];
                   

                    $rowValidator = Validator::make($rowData, [
                        'id_remunerasi_source' => 'required|exists:remunerasi_source,id',
                        'no_sep' => 'required|string|max:30|unique:detail_source,no_sep',
                        'tgl_verifikasi' => 'required|date',
                        'biaya_riil_rs' => 'required|numeric|min:0',
                        'biaya_diajukan' => 'required|numeric|min:0',
                        'biaya_disetujui' => 'required|numeric|min:0',
                        'status' => 'required|in:0,1',
                        'jenis' => 'required|string|max:50'
                    ]);

                    if ($rowValidator->fails()) {
                        $failed++;
                        $errors[] = "Baris " . ($start + $index + 2) . ": " . implode(', ', $rowValidator->errors()->all());
                        continue;
                    }

                    try {
                        DetailSource::create($rowData);
                        $success++;
                    } catch (\Exception $e) {
                        $failed++;
                        $errors[] = "Baris " . ($start + $index + 2) . ": Gagal menyimpan data - " . $e->getMessage();
                    }
                }

                // If this is the last chunk, clean up
                if ($chunk == session('total_chunks')) {
                    unlink($tempFile);
                    session()->forget(['import_file', 'total_rows', 'chunk_size', 'total_chunks']);
                }

                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'success' => $success,
                        'failed' => $failed,
                        'errors' => $errors
                    ]
                ]);
            }

        } catch (\Exception $e) {
            // Clean up on error
            if (isset($tempFile) && file_exists($tempFile)) {
                unlink($tempFile);
            }
            session()->forget(['import_file', 'total_rows', 'chunk_size', 'total_chunks']);
            
            return ResponseFormatter::error(null, 'Gagal memproses file: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Download template Excel
     */
    public function downloadTemplate()
    {
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set judul worksheet
            $sheet->setTitle('Template Detail Source');

            // Set header kolom
            $headers = [
                'A1' => 'No SEP',
                'B1' => 'Tanggal Verifikasi',
                'C1' => 'Biaya Riil RS',
                'D1' => 'Biaya Diajukan',
                'E1' => 'Biaya Disetujui',
                'F1' => 'Status',
                'G1' => 'Jenis',
            ];

            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Set contoh data
            $exampleData = [
                'A2' => '0001234567',
                'B2' => '01/01/2024',
                'C2' => '1000000',
                'D2' => '900000',
                'E2' => '850000',
                'F2' => 'Aktif',
                'G2' => 'Rawat Inap',
            ];

            foreach ($exampleData as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Set style header
            $sheet->getStyle('A1:G1')->getFont()->setBold(true);
            $sheet->getStyle('A1:G1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E2E2E2');
            
            // Set lebar kolom otomatis
            foreach(range('A','G') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }

            // Tambahkan validasi data untuk kolom Status
            $validation = $sheet->getCell('G2')->getDataValidation();
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION);
            $validation->setAllowBlank(false);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(true);
            $validation->setFormula1('"Aktif,Nonaktif"');

            // Set format angka untuk kolom biaya
            $sheet->getStyle('D2:F2')->getNumberFormat()->setFormatCode('#,##0.00');

            // Buat writer untuk output
            $writer = new Xlsx($spreadsheet);

            // Set header untuk download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="template_detail_source.xlsx"');
            header('Cache-Control: max-age=0');

            // Simpan file ke output
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Gagal mengunduh template: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Transform date value from Excel
     */
    private function transformDate($value)
    {
        try {
            if (is_numeric($value)) {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
            }
            return Carbon::createFromFormat('d/m/Y', $value);
        } catch (\Exception $e) {
            return $e;
        }
    }
    function transformDate2($value) {
        try {
            $tanggal = $value;
            $carbon = Carbon::parse($tanggal);
            return $carbon->format('d/m/Y'); // 10-04-2025
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Transform decimal value from Excel
     */
    private function transformToDecimal($value)
    {
        if (is_string($value)) {
            $value = str_replace(',', '', $value);
            return (float) str_replace(['Rp', '.', ','], ['', '', '.'], $value);
        }
        return $value;
    }

    /**
     * Get jumlah data yang belum disinkronkan
     */
    public function getUnsyncedCount($sourceId)
    {
        try {
            $total = DetailSource::where('id_remunerasi_source', $sourceId)
                    ->where('status_pembagian_klaim', '!=', 1)
                    ->count();

            return response()->json([
                'success' => true,
                'total' => $total
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Proses sinkronisasi batch
     */
    public function syncBatch(Request $request, $sourceId)
    {
     
        
                try {        
                    // Panggil API untuk update SEP
                    $detailSource =  DetailSource::where('id_remunerasi_source', $sourceId)
                    ->where('status_pembagian_klaim', '!=', 1);
                   
                    
                    
                    
                    if($detailSource->count() > 0){
                        $data_detail_source = $detailSource->first();
                        $sep = $data_detail_source->no_sep;
                       
                        $selisih = $data_detail_source->biaya_disetujui-$data_detail_source->biaya_riil_rs;
                        $persentase_selisih = $selisih/$data_detail_source->biaya_disetujui;
                        $persentase_selisih = $persentase_selisih*100;
                        
                       $persentase_selisih = round($persentase_selisih, 2);
                
                        $grade = Grade::where('persentase', '>=', $persentase_selisih)
                            ->orderBy('persentase', 'ASC')
                            ->first();
                    
                        $grade = $grade->grade;
                        $jenis = $data_detail_source->jenis;
                       
            
                        if($jenis == 'Rawat Jalan'){
                       
                            $data = $this->getIdxDaftar($sep);
                            $idxdaftar = $data['idxdaftar'];
                            $nomr = $data['nomr'];
                            
                            $tpendaftaran = Tpendaftaran::where('IDXDAFTAR', $idxdaftar)->first();
                            $databilling = Tbillrajal::where(['IDXDAFTAR' => $idxdaftar, 'NOMR' => $nomr])->get();
                           
                            $VERIFIKASITOTAL = $data_detail_source->biaya_disetujui;
                            $pisau = 0; //v
                            $TOTALLPA = 0;//v
                            $TOTALPATKLIN = 0;//v
                            $TOTALRADIOLOGI = 0;//v
                            $TOTALBDRS = 0;//
                            $TOTALHD = 0;
                            $TINDAKANRAJAL_HARGA = 0;//
                            
                            $DPJP = $tpendaftaran->KDDOKTER;
                            // ------------	
                            $DOKTERKONSUL = "";
                            $KONSULEN = "";
                            $DPJPRABER = "";
                            $DOKTERRABER = "";
                            // ------------
                            $LABORATORIST = "";
                            $RADIOLOGIST = "";
                            $PERAWAT = 127;
                            // ------------
                            $DOKTERBDRS= "";
                            $TIMBDRS = "";
            
                            $ANESTESI = "";
                            $PENATA = "";
                            $ASISTEN = "";
            
                            $CATHLAB = "";
                            $DOKTERLPA = "";
                            $TIMLPA = "";
                            $ESWL = "";
                            $HD = "";
                            
                            
                            $TINDAKANRAJAL = "";
                            $DOKTERHDRAJAL = "";
                            $PERAWATHDRAJAL = "";
                            $DPJPCATHLAB = "";
                            
                            
                            foreach($databilling as $row){
                              
                                if(in_array($row->id_kategori, [7,8,9,10,60,64,65])){
                                    $pisau += 1;
                                    $data_operasi = Moperasi::where(['IDXDAFTAR' => $idxdaftar, 'nomr' => $nomr])->where('status', '!=', 'batal')->get();
                                    foreach($data_operasi as $row_operasi){
                                        $OPERATOR[] = $row_operasi->kode_dokteroperator;
                                        $ANESTESI = $row_operasi->kode_dokteranastesi;
                                    }
                                    $PENATA = "127";
                                    $ASISTEN = "127";
                                }
                                if(in_array($row->id_kategori, [3,41,30,4,5,6,28,22,23,24,25,26,27,29,30])){
                                    $TINDAKANRAJAL_HARGA += $row->TARIFRS;
                                    $TINDAKANRAJAL = $row->KDDOKTER;
                                }
                                if(in_array($row->id_kategori, [14])){
                                    
                                    if($row->UNIT == '16'){
                                        $TOTALPATKLIN += $row->TARIFRS;
                                        $LABORATORIST = $row->KDDOKTER;
                                    }else if($row->UNIT == '163'){
                                        $TOTALLPA += $row->TARIFRS;
                                        $DOKTERLPA = $row->KDDOKTER;
                                    }
                                   
                                }
                                if(in_array($row->id_kategori, [16,17,18,19])){
                                    $TOTALRADIOLOGI += $row->TARIFRS;
                                    $RADIOLOGIST = $row->KDDOKTER;
                                }
                                if(in_array($row->id_kategori, [21])){
                                    $HD  = $row->KDDOKTER;
                                    $DOKTERHDRAJAL = $row->KDDOKTER;
                                    $PERAWATHDRAJAL = 127;
                                    $TOTALHD += $row->TARIFRS;
                                }
                              
                                
            
            
                            }
                            
                            $data_sumber = [
                                "HARGA" => $TINDAKANRAJAL_HARGA,
                                "TOTALPATKLIN" => $TOTALPATKLIN,
                                "TOTALLPA" => $TOTALLPA,
                                "TOTALRADIOLOGI" => $TOTALRADIOLOGI,
                                "TOTALBDRS" => $TOTALBDRS,
                                "VERIFIKASITOTAL" => $VERIFIKASITOTAL,
                                "TOTALHD" => $TOTALHD
                            ];
            
                            
                            // cari data proporsi
                            $proporsi_fairness = ProporsiFairness::
                            where('grade', $grade)
                            ->where('groups', ($jenis == 'Rawat Jalan')?"RJTL":"RITL")
                            ->where('jenis', ($pisau)?"PISAU":"NONPISAU")
                            ->get();
                            
                            $pembagian = [];
            
                            foreach($proporsi_fairness as $row){
                                
                                if(@${$row['ppa']}){
                                    $nama_dokter = Dokter::where('KDDOKTER', @${$row['ppa']})->first()->NAMADOKTER;
                                    if($row['sumber'] == "HARGA"){
                                        if($row['value'] > 1 ){
                                            $nilai_remunerasi = $row['value'];
                                        }else{
                                            $nilai_remunerasi = $row['value'] * $data_sumber[$row['sumber']];
                                        }
                                       
                                    }else{
                                        
                                        $nilai_remunerasi = $data_sumber[$row['sumber']]*$row['value'];
                                    }
                                    $kode_dokter = @${$row['ppa']};
                                }else{
                                    $nilai_remunerasi = 0;
                                    $nama_dokter = "";
                                    $kode_dokter = 0;
            
                                }
            
                                $data = [
                                    'groups'=>$row['groups'],
                                    'jenis'=>$row['jenis'],
                                    'grade'=>$grade,
                                    'ppa'=>$row['ppa'],
                                    'value'=>$row['value'],
                                    'sumber'=>$row['sumber'],
                                    'flag'=>$row['flag'],
                                    'del'=>$row['del'],
                                    'sep'=>$data_detail_source->no_sep,
                                    'id_detail_source'=>$data_detail_source->id,
                                    'cluster'=>($kode_dokter == 127)?2:1,
                                    'idxdaftar'=>$idxdaftar,
                                    'nomr'=>$nomr,
                                    'tanggal'=>$data_detail_source->tgl_verifikasi,
                                    'nama_ppa'=>$nama_dokter,
                                    'kode_dokter'=>$kode_dokter,
                                    'sumber_value'=>$data_sumber[$row['sumber']],
                                    'nilai_remunerasi'=>$nilai_remunerasi
                                ];
                                if($nilai_remunerasi > 0){                   
                                    $savePembagianKlaim = PembagianKlaim::create($data);
                                }
                            }
                         
                           
                            if($savePembagianKlaim){
                                $detailSource->update([
                                    'status_pembagian_klaim'=>1,
                                    'idxdaftar'=>$idxdaftar,
                                    'nomr'=>$nomr
                                ]);

                                $success = 1;
                                $failed = 0;
                            }else{
                                $detailSource->update([
                                    'status_pembagian_klaim'=>2,
                                    'idxdaftar'=>$idxdaftar,
                                    'nomr'=>$nomr
                                ]);
                                $failed = 1;
                                $success = 0;
                            }
                            
                             
                        }else if($jenis == 'Rawat Inap'){
                            
                            $data = $this->getIdxDaftar($sep);
                            $idxdaftar = $data['idxdaftar'];
                            $nomr = $data['nomr'];
            
                            $tadmission = Tadmission::where('id_admission', $idxdaftar)->first();
                            $databilling = Tbillranap::where(['IDXDAFTAR' => $idxdaftar, 'NOMR' => $nomr])->get();
            
                            $VERIFIKASITOTAL = $data_detail_source->biaya_disetujui;
                            $pisau = 0; //
                            $TOTALLPA = 0;//
                            $TOTALPATKLIN = 0;//
                            $TOTALRADIOLOGI = 0;//
                            $TOTALBDRS = 0;//
                            $TOTALHD = 0;
                            $TINDAKANRAJAL_HARGA = 0;//
                            
                            $DPJP = $tadmission->dokter_penanggungjawab;
                            // ------------	
                            $DOKTERKONSUL = "";
                            $KONSULEN = "";
                            $DPJPRABER = "";
                            $DOKTERRABER = "";
                            // ------------
                            $LABORATORIST = "";
                            $RADIOLOGIST = "";
                            $PERAWAT = 127;
                            // ------------
                            $DOKTERBDRS= "";
                            $TIMBDRS = "";
                            $ANESTESI = "";
                            $PENATA = "";
                            $ASISTEN = "";
                            $CATHLAB = "";
                            $DOKTERLPA = "";
                            $TIMLPA = "";
                            $ESWL = "";
                            $HD = "";
                            
                            $TINDAKANRAJAL = "";
                            $DOKTERHDRAJAL = "";
                            $PERAWATHDRAJAL = "";
                            $DPJPCATHLAB = "";
                            
                            
                            $kddokter = [];
                            
                            foreach($databilling as $row){
                                if($row->id_kategori == 2){
                                    if(!($row->KDDOKTER== $DPJP )){
                                        $kdprofesi = Dokter::where('KDDOKTER', $row->KDDOKTER)->first()->KDPROFESI;
                                        if($kdprofesi == 1){
                                            $kddokter[] = $row->KDDOKTER;
                                            $DPJPRABER  = $tadmission->dokter_penanggungjawab;
                                            $DOKTERRABER = $row->KDDOKTER;
                                        }
                                    }
                                }
                                if(in_array($row->id_kategori, [7,8,9,10,60,64,65])){
                                    $pisau += 1;
                                    $data_operasi = Moperasi::where(['IDXDAFTAR' => $idxdaftar, 'nomr' => $nomr])->where('status', '!=', 'batal')->get();
                                    foreach($data_operasi as $row_operasi){
                                        $OPERATOR[] = $row_operasi->kode_dokteroperator;
                                        $ANESTESI = $row_operasi->kode_dokteranastesi;
                                    }
            
                                    $PENATA = "127";
                                    $ASISTEN = "127";
                                }
                               
                                if(in_array($row->id_kategori, [14])){
                                     
                                    if($row->UNIT == '16'){
                                        $TOTALPATKLIN += $row->TARIFRS;
                                        $LABORATORIST = $row->KDDOKTER;
                                    }else if($row->UNIT == '163'){
                                        $TOTALLPA += $row->TARIFRS;
                                        $DOKTERLPA = $row->KDDOKTER;
                                    }
                                  
                                   
                                }
                                if(in_array($row->id_kategori, [16,17,18,19])){
                                    $TOTALRADIOLOGI += $row->TARIFRS;
                                    $RADIOLOGIST = $row->KDDOKTER;
                                }
                                if(in_array($row->id_kategori, [21])){
                                    $HD  = $row->KDDOKTER;
                                    $DOKTERHDRANAP = $row->KDDOKTER;
                                    $TOTALHD += $row->TARIFRS;
                                    $PERAWATHDRANAP = 127;
                                }
                            }
                        
                            $data_sumber = [
                                "HARGA" => $TINDAKANRAJAL_HARGA,
                                "TOTALPATKLIN" => $TOTALPATKLIN,
                                "TOTALLPA" => $TOTALLPA,
                                "TOTALRADIOLOGI" => $TOTALRADIOLOGI,
                                "TOTALBDRS" => $TOTALBDRS,
                                "VERIFIKASITOTAL" => $VERIFIKASITOTAL,
                                "TOTALHD" => $TOTALHD
                            ];
            
                            
                            // cari data proporsi
                            $proporsi_fairness = ProporsiFairness::
                            where('grade', $grade)
                            ->where('groups', ($jenis == 'Rawat Jalan')?"RJTL":"RITL")
                            ->where('jenis', ($pisau)?"PISAU":"NONPISAU")
                            ->get();
                          
                           
                            
                            $pembagian = [];
                            if($DPJPRABER != ""){
                                $DPJP = "";
                            }
            
            
                            foreach($proporsi_fairness as $row){
                                
                                if(@${$row['ppa']} != ""){
                                    $dokter = Dokter::where('KDDOKTER', @${$row['ppa']})->first();
                                    if($dokter && $dokter->NAMADOKTER){
                                       
                                        $nama_dokter = $dokter->NAMADOKTER;
                                        $kode_dokter = @${$row['ppa']};
                                        if($row['sumber'] == "HARGA"){
                                            if($row['value'] > 1 ){
                                                $nilai_remunerasi = $row['value'];
                                            }else{
                                                $nilai_remunerasi = $row['value'] * $data_sumber[$row['sumber']];
                                            }
                                           
                                        }else{
                                            
                                            $nilai_remunerasi = $data_sumber[$row['sumber']]*$row['value'];
                                        }

                                    }else{
                                        $nama_dokter = "";
                                        $kode_dokter = 0;
                                        $nilai_remunerasi = 0;
                                   
                                    }
                                   
                                    
                                }else{
                                    $nilai_remunerasi = 0;
                                    $nama_dokter = "";
                                    $kode_dokter = 0;
            
                                }
            
                             
                                if($nilai_remunerasi > 0){     
                                    $data = [
                                        'groups'=>$row['groups'],
                                        'jenis'=>$row['jenis'],
                                        'grade'=>$grade,
                                        'ppa'=>$row['ppa'],
                                        'value'=>$row['value'],
                                        'sumber'=>$row['sumber'],
                                        'flag'=>$row['flag'],
                                        'del'=>$row['del'],
                                        'sep'=>$data_detail_source->no_sep,
                                        'id_detail_source'=>$data_detail_source->id,
                                        'cluster'=>(@$kode_dokter == 127)?2:1,
                                        'idxdaftar'=>$idxdaftar,
                                        'nomr'=>$nomr,
                                        'tanggal'=>$data_detail_source->tgl_verifikasi,
                                        'nama_ppa'=>$nama_dokter,
                                        'kode_dokter'=>@$kode_dokter,
                                        'sumber_value'=>$data_sumber[$row['sumber']],
                                        'nilai_remunerasi'=>$nilai_remunerasi
                                    ];              
                                    $savePembagianKlaim = PembagianKlaim::create($data);
                                }
                            }
                         
                          
                            if($savePembagianKlaim){
                                $detailSource->update([
                                    'status_pembagian_klaim'=>1,
                                    'idxdaftar'=>$idxdaftar,
                                    'nomr'=>$nomr
                                ]);

                                $success = 1;
                                $failed = 0;
                            }else{
                                $detailSource->update([
                                    'status_pembagian_klaim'=>2,
                                    'idxdaftar'=>$idxdaftar,
                                    'nomr'=>$nomr
                                ]);
                                $failed = 1;
                                $success = 0;
                            }
                            
                            
                        }else{
                            // echo "Jenis tidak diketahui";
                            // die;
                            $detailSource->update([
                                'status_pembagian_klaim'=>2
                            ]);
                            
                            $failed = 1;
                            $success = 0;

                        }
                        // cari grade
                       
                    }else{
                        $remainingCount = DetailSource::where('id_remunerasi_source', $sourceId)
                        ->where('status_pembagian_klaim', 0)
                        ->count();
                        return response()->json([
                            'processed' => 1,
                            'success' => 0,
                            'failed' => 1,
                            'hasMore' => $remainingCount > 0
                        ]);
                    }
                    
                  
                
                // Tambahkan delay kecil untuk menghindari overload server
                // usleep(100000); // 0.1 detik
            

            // Cek apakah masih ada data yang perlu diproses
            $remainingCount = DetailSource::where('id_remunerasi_source', $sourceId)
                    ->where('status_pembagian_klaim', 0)
                    ->count();
        
           

            return response()->json([
                'processed' => 1,
                'success' => $success,
                'failed' => $failed,
                'hasMore' => $remainingCount > 0
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    function getIdxDaftar($sep) {
        if(strlen($sep) != 19){
            $tpendaftaran = Tpendaftaran::where('IDXDAFTAR', $sep)->first();
            if($tpendaftaran){
                $idxdaftar = $tpendaftaran->IDXDAFTAR;
                $nomr = $tpendaftaran->NOMR;
            }
        }else{
            $tbpjs = Tbpjs::where('sep', $sep)->first();
            if($tbpjs){
                $idxdaftar = $tbpjs->idxdaftar;
                $nomr = $tbpjs->noMr;
                if($nomr == ""){
                    $response = $tbpjs->response;
                    $nomr = $this->ambilNoMR($response);
                }
                if($nomr == ""){
                    $datasep = $this->getApi("http://192.168.10.5/bpjs_2/cari_pasien/cari_idx2.php?q=".$sep);
                    $data = json_decode($datasep);
                    $idxdaftar = $data->data->idxdaftar;
                    $nomr = $data->data->nomr;
                }
            
                
            
            }else{
                $datasep = $this->getApi("http://192.168.10.5/bpjs_2/cari_pasien/cari_idx2.php?q=".$sep);
                $data = json_decode($datasep);
                $idxdaftar = $data->data->idxdaftar;
                $nomr = $data->data->nomr;
            
            }
        }
        
        
        return [
            'idxdaftar' => $idxdaftar,
            'nomr' => $nomr
        ];

        
    }
    function ambilNoMR($json) {
        $data = json_decode($json, true);
    
        if (
            isset($data['response']['sep']['peserta']['noMr']) &&
            !empty($data['response']['sep']['peserta']['noMr'])
        ) {
            return $data['response']['sep']['peserta']['noMr'];
        }
    
        return null; // atau bisa return string error
    }
    private function getApi($url)
    {
       
        $headers = array(
            "User-Agent: PHP-SDK",
            "Accept: */*",
            "kode:cahmbarek",
            "Content-type: application/json",
            "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjQiLCJ1c2VybmFtZSI6InVzZXIiLCJpYXQiOjE1ODExMzg5OTEsImV4cCI6MTU4MTE1Njk5MX0.M__6_FFWgD5Uk7f3vvvW9FE517k5HebNEzALEWUCcKQ"
        );
        $ch = curl_init(); 
        // set url 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // tutup curl 
        curl_close($ch); 
        // menampilkan hasil curl
        return $output;
    }

    public function getAdmissionList(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan', date('n'));

        $query = Tadmission::query()
            ->with('pasien')
            ->whereYear('masukrs', $tahun)
            ->whereMonth('masukrs', $bulan);

        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }

    public function storeFromAdmission(Request $request, $sourceId)
    {
        try {
            DB::beginTransaction();

            $source = RemunerasiSource::findOrFail($sourceId);
            $admissionIds = $request->input('admission_ids', []);

            // Validasi batch status
            if ($source->batch->status !== 'draft') {
                throw new \Exception('Hanya batch dengan status draft yang dapat ditambahkan data');
            }

            $admissions = Tadmission::whereIn('id_admission', $admissionIds)
                ->with(['billranap', 'billrajal'])
                ->get();

            foreach ($admissions as $admission) {
                // Process billranap
                foreach ($admission->billranap as $bill) {
                    if ($bill->status != 'BATAL' && $bill->status_tindakan == 1) {
                        DetailSource::updateOrCreate(
                            [
                                'remunerasi_source_id' => $source->id,
                                'kode_tarif' => $bill->kode_tarif,
                                'idxdaftar' => $admission->id_admission
                            ],
                            [
                                'nama_tarif' => $bill->nama_tarif,
                                'jumlah' => $bill->qty,
                                'tarif' => $bill->tarif_rs,
                                'total' => $bill->qty * $bill->tarif_rs,
                                'status' => 'active',
                                'tgl_tindakan' => $bill->tgl_tindakan,
                                'unit' => $bill->unit
                            ]
                        );
                    }
                }

                // Process billrajal
                foreach ($admission->billrajal as $bill) {
                    if ($bill->status != 'BATAL' && $bill->status_tindakan == 1) {
                        DetailSource::updateOrCreate(
                            [
                                'remunerasi_source_id' => $source->id,
                                'kode_tarif' => $bill->kode_tarif,
                                'idxdaftar' => $admission->id_admission
                            ],
                            [
                                'nama_tarif' => $bill->nama_tarif,
                                'jumlah' => $bill->qty,
                                'tarif' => $bill->tarif_rs,
                                'total' => $bill->qty * $bill->tarif_rs,
                                'status' => 'active',
                                'tgl_tindakan' => $bill->tgl_tindakan,
                                'unit' => $bill->unit
                            ]
                        );
                    }
                }
            }

            // Update total biaya di remunerasi source
            $totalBiaya = DetailSource::where('remunerasi_source_id', $source->id)
                ->where('status', 'active')
                ->sum('total');
            
            $source->update(['total_biaya' => $totalBiaya]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diimport'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 