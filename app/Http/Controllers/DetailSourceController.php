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
use App\Models\Sepbpjs;
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
use App\Models\Tradiologi;
use App\Models\Divisi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;

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

            $detail = DetailSource::with(['remunerasiSource'])->findOrFail($id);
            return view('detail-source.show', compact('detail'));
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return ResponseFormatter::error(null, 'Data tidak ditemukan');
            }
            
            return redirect()->route('remunerasi-source.index')
                ->with('error', 'Data tidak ditemukan');
        }
    }
    public function showpembagian($id_remunerasi_source)
    {
        try {
          

            $detail = RemunerasiSource::with('batch')->findOrFail($id_remunerasi_source);
            $result = \DB::table('detail_source')
            ->where('id_remunerasi_source', $id_remunerasi_source)
            ->selectRaw('SUM(total_remunerasi) as total,sum(biaya_riil_rs) as biaya_riil_rs,sum(biaya_disetujui) as biaya_disetujui, COUNT(*) as jumlah')
            ->first();
       
        
    
           return view('detail-source.show-pembagian', compact('detail', 'result'));
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return ResponseFormatter::error(null, 'Data tidak ditemukan');
            }
            print_r($e);
            // return redirect()->route('remunerasi-source.index')
            //     ->with('error', 'Data tidak ditemukan');
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
            $update = DetailSource::where('id', $detailSource->id)
                                   ->update($request->all());
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
                        $action .= '<a href="#" onclick="syncSepData(\''.$row->id.'\')" class="btn btn-primary btn-sm" title="Sinkronisasi Data SEP">
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
                $chunkSize = 100; // Process 100 rows per chunk
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
                    if (DetailSource::where(['no_sep' => $noSep, 'id_remunerasi_source' => $sourceId])->exists()) {
                        $failed++;
                        $errors[] = "Baris " . ($start + $index + 2) . ": No SEP '$noSep' sudah ada dalam database";
                        continue;
                    }

                    try {
                        $tglVerifikasi = $this->transformDate2($row[1]);
                        
                        $rowData = [
                            'id_remunerasi_source' => $sourceId,
                            'no_sep' => $noSep,
                            'tgl_verifikasi' => $tglVerifikasi,
                            'biaya_riil_rs' => $this->transformToDecimal($row[2]),
                            'biaya_diajukan' => $this->transformToDecimal($row[3]),
                            'biaya_disetujui' => $this->transformToDecimal($row[4]),
                            'status' => strtolower($row[5]) == 'aktif' ? 1 : 0,
                            'jenis' => $row[6],
                            'idxdaftar' => $row[7]
                        ];

                        $rowValidator = Validator::make($rowData, [
                            'id_remunerasi_source' => 'required|exists:remunerasi_source,id',
                            'no_sep' => 'required|string|max:30',
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

                        DetailSource::create($rowData);
                        $success++;
                    } catch (\Exception $e) {
                        $failed++;
                        $errors[] = "Baris " . ($start + $index + 2) . ": " . $e->getMessage();
                        continue;
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
                'H1' => 'Idxdaftar'
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
                'H2' => '0'
            ];

            foreach ($exampleData as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Set style header
            $sheet->getStyle('A1:H1')->getFont()->setBold(true);
            $sheet->getStyle('A1:H1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E2E2E2');
            
            // Set lebar kolom otomatis
            foreach(range('A','H') as $column) {
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
            // Jika input kosong atau null
            if (empty($value)) {
                throw new \Exception("Tanggal tidak boleh kosong");
            }

            // Jika tanggal dalam format Excel (numeric)
            if (is_numeric($value)) {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))
                    ->format('Y-m-d');
            }

            // Bersihkan string dari karakter yang tidak diinginkan
            $value = trim($value);
            
            // Coba parse tanggal menggunakan Carbon secara langsung
            try {
                $date = Carbon::parse($value);
                return $date->format('Y-m-d');
            } catch (\Exception $e) {
                // Jika gagal, lanjut ke pengecekan format spesifik
            }

            // Deteksi format tanggal yang umum digunakan
            $patterns = [
                '/^(\d{2})-(\d{2})-(\d{4})$/' => 'd-m-Y',    // 13-04-2025
                '/^(\d{2})\/(\d{2})\/(\d{4})$/' => 'd/m/Y',  // 13/04/2025
                '/^(\d{4})-(\d{2})-(\d{2})$/' => 'Y-m-d',    // 2025-04-13
                '/^(\d{4})\/(\d{2})\/(\d{2})$/' => 'Y/m/d',  // 2025/04/13
                '/^(\d{2})-([A-Za-z]{3})-(\d{4})$/' => 'd-M-Y', // 13-Apr-2025
                '/^(\d{4})-([A-Za-z]{3})-(\d{2})$/' => 'Y-M-d'  // 2025-Apr-13
            ];

            foreach ($patterns as $pattern => $format) {
                if (preg_match($pattern, $value)) {
                    try {
                        $date = Carbon::createFromFormat($format, $value);
                        if ($date && $date->year >= 1900 && $date->year <= 2100) {
                            return $date->format('Y-m-d');
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }

            // Jika semua format gagal, coba parse dengan strtotime
            $timestamp = strtotime($value);
            if ($timestamp !== false) {
                return date('Y-m-d', $timestamp);
            }

            throw new \Exception("Format tanggal tidak valid. Gunakan format dd-mm-yyyy (contoh: 13-04-2025) atau dd/mm/yyyy (contoh: 13/04/2025)");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage() . " untuk nilai: " . $value);
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
    function hitung($sourceId,DetailSource $detailSource) {
      
       
        $failed = 0;
        $success = 0;
        $message = [];
        $data_detail_source = $detailSource;
        // foreach($detail_source as $row){
            // $data_detail_source = $row;
        if($data_detail_source->jenis == 'Rawat Jalan'){
            if(strpos($data_detail_source->no_sep,"-")){
                    //membaca idxdaftar dan nomr / pasien umum
                    $idxdaftar = $data_detail_source->idxdaftar;
                    $data_pendaftaran = Tpendaftaran::where('IDXDAFTAR',$idxdaftar)->first();
                    $totalTarifRs = $data_pendaftaran->getTotalTarifRsAttribute();
                    $data_pendaftaran->total_tarif_rs = $totalTarifRs;
                    $idxdaftar = $data_pendaftaran->IDXDAFTAR;
                    $nomr = $data_pendaftaran->NOMR;
                   
    
                    $selisih = $totalTarifRs-$totalTarifRs;
                    if($selisih > 0){
                        $persentase_selisih = $selisih/$totalTarifRs;
                        $persentase_selisih = $persentase_selisih*100;
                        $persentase_selisih = round($persentase_selisih, 2);
                    }else{
                        if($data_pendaftaran->KDPOLY == 201){
                            $persentase_selisih = 0;
                        }else{
                            $persentase_selisih = 10;
                        }
                    }
                    
                
            
                    $grade = Grade::where('persentase', '>=', $persentase_selisih)
                        ->orderBy('persentase', 'ASC')
                        ->first();
                        
                    $grade = $grade->grade;
                    $VERIFIKASITOTAL = $totalTarifRs;
            }else{
                // bpjps
                $sep = $data_detail_source->no_sep;
                $data = $this->getIdxDaftar($sep);
                $idxdaftar = $data['idxdaftar'];
                $nomr = $data['nomr'];
                  
                $selisih = $data_detail_source->biaya_disetujui-$data_detail_source->biaya_riil_rs;
                $selisih = $selisih*-1;
                if ($data_detail_source->biaya_disetujui != 0) {
                    $persentase_selisih = ($selisih / $data_detail_source->biaya_disetujui) * 100;
                } else {
                    $persentase_selisih = 0; // Atau null, tergantung logika kamu
                }
                $persentase_selisih = $persentase_selisih*100;
                if($persentase_selisih < 0){
                    $persentase_selisih = 0;
                }else if($persentase_selisih >= 20){
                    $persentase_selisih = 20;
                }else{
                    $persentase_selisih = $persentase_selisih;
                }        
                $grade = Grade::where('persentase', '>=', $persentase_selisih)
                    ->orderBy('persentase', 'ASC')
                    ->first();   
    
            
                    $grade = $grade->grade;
                    $sep = $data_detail_source->no_sep;
    
                 $VERIFIKASITOTAL = $data_detail_source->biaya_disetujui;
            }
        
    
            $tpendaftaran = Tpendaftaran::where('IDXDAFTAR', $idxdaftar)->first();
            $databilling = Tbillrajal::where(['IDXDAFTAR' => $idxdaftar, 'NOMR' => $nomr])->get();
           
            
           
            $pisau = 0; //v
            $TOTALLPA = 0;//v
            $TOTALPATKLIN = 0;//v
            $TOTALRADIOLOGI = 0;//v
            $TOTALBDRS = 0;//
            $TOTALHD = 0;
            $TINDAKANRAJAL_HARGA = 0;//
            $TOTALBANKDARAH = 0;
            $EMBALACE = 0;
            $Dokter_Umum_IGD = 0;
            
            $DPJP = @$tpendaftaran->KDDOKTER;
            // ------------	
            $DOKTERKONSUL = "";
            $KONSULEN = "";
            $DPJPRABER = "";
            $DOKTERRABER = "";
            // ------------
            $LABORATORIST = "";
            $RADIOLOGIST = "";
            $AHLIGIZI = "";
            $ANALISLABKLINIK = "";
            $RADIOGRAFER = "";

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
            $Apoteker = "";
            $STRUKTURAL = 1;
            $JTL = 1;
            $PENATABANKDARAH = "";
            
            
            foreach($databilling as $row){
                
                if(in_array($row->id_kategori, [3,41,30,4,5,6,28,22,23,24,25,26,27,29,30])){
                 
                    $TINDAKANRAJAL_HARGA += $row->TARIFRS;
                    $TINDAKANRAJAL = $row->KDDOKTER;
                   
                }
               
                if($row->UNIT == 15){
                    $pisau += 1;
                    $data_operasi = Moperasi::where(['IDXDAFTAR' => $idxdaftar, 'nomr' => $nomr])->where('status', '!=', 'batal')->get();
                    foreach($data_operasi as $row_operasi){
                        $OPERATOR[] = $row_operasi->kode_dokteroperator;
                        if($row_operasi->kode_dokteranastesi != ""){
                            $ANESTESI = $row_operasi->kode_dokteranastesi;
                            $PENATA = "9";
                        }
                        
                    }
                    $ASISTEN = "10";
                   
                  
                }
                if(in_array($row->id_kategori, [14])){
                        
                    if($row->UNIT == '16'){
                        $TOTALPATKLIN += $row->TARIFRS;
                        $LABORATORIST = $row->KDDOKTER;
                        $ANALISLABKLINIK = "17";
                    }else if($row->UNIT == '163'){
                        $TOTALLPA += $row->TARIFRS;
                        $DOKTERLPA = 884;
                        $ANALISLABKLINIK = "18";
                    }
                    
                    
                }
                if(in_array($row->id_kategori, [15])){
                        
                    $TOTALBANKDARAH += $row->TARIFRS;
                    $PENATABANKDARAH = 19;
                     
                 }
            
                if($row->UNIT == 17){
                    // cari dokter radiologi
                     $TOTALRADIOLOGI += $row->TARIFRS;
                    // $RADIOLOGIST = $row->KDDOKTER;
                    // cari dokterariologi
                    $radiologi = Tradiologi::where('IDXDAFTAR', $idxdaftar)->where('NOMR', $nomr)->first();
                    if($radiologi){
                        $RADIOLOGIST = $radiologi->DRRADIOLOGI;
                    }else{
                        $RADIOLOGIST = $row->KDDOKTER;
                    } 
                    

                    $RADIOGRAFER = "16";
                }
                if(in_array($row->id_kategori, [21])){
                    $HD  = $row->KDDOKTER;
                    // $DOKTERHDRANAP = $row->KDDOKTER;
                    $TOTALHD += $row->TARIFRS;
                    $PERAWATHDRAJAL = 8;
                }
                
                if(in_array($row->KODETARIF, ['07'])){
                    $Apoteker = 6;
                    $EMBALACE += 1;
                }
    
            }
            
            if(in_array(@$tpendaftaran->KDPOLY,[31,168,169])){
                $TINDAKANRAJAL = $tpendaftaran->KDDOKTER;
                $DPJP = "813" ;
                
            }else if(in_array(@$tpendaftaran->KDPOLY,[101])){
                $TINDAKANRAJAL = "832";
                $DPJP = "832";
            }

             if($EMBALACE > 0){
                
                if($EMBALACE > 0){
                
                $jumlah = DB::connection('simrs')
                    ->table('penjualan as a')
                    ->join('detail_penjualan as b', 'a.id', '=', 'b.id_penjualan')
                    ->where('a.id_pelanggan', '506637278')
                    ->orderByDesc('a.id')
                    ->selectRaw('COUNT(b.id) as jumlah')
                    ->first();
               
               
                $EMBALACE = $jumlah->jumlah*0.95;
                
            }
             
               
                $EMBALACE = $jumlah->jumlah*0.95;
                
            }
            
            $data_sumber = [
                "HARGA" => $TINDAKANRAJAL_HARGA,
                "EMBALACE" => $EMBALACE,
                "TOTALPATKLIN" => $TOTALPATKLIN,
                "TOTALLPA" => $TOTALLPA,
                "TOTALRADIOLOGI" => $TOTALRADIOLOGI,
                "TOTALBDRS" => $TOTALBDRS,
                "VERIFIKASITOTAL" => $VERIFIKASITOTAL,
                "TOTALBANKDARAH" => $TOTALBANKDARAH
            ];
         
            
            
    
            
            // cari data proporsi
            $proporsi_fairness = ProporsiFairness::
            where('grade', $grade)
            ->where('groups', ($data_detail_source->jenis == 'Rawat Jalan')?"RJTL":"RITL")
            ->where('jenis', ($pisau)?"PISAU":"NONPISAU")
            ->get();
            
            $pembagian = [];
            $divisi = Divisi::pluck('nama', 'id');
            $total_remunerasi = 0;
    
            $proporsi_fairness_radiologi = [];
            $proporsi_fairness_laboratorist = [];

            foreach($proporsi_fairness as $row){
                
                if(@${$row['ppa']} != "" && @${$row['ppa']} != 0){
    
                        $divisi_id = $divisi->search(function ($item, $key) use ($row) {
                            return $item == $row->ppa;
                        });
    
    
                        if($divisi_id !== false){
                            $nama_dokter = $row->ppa;
                            $kode_dokter = $divisi_id;
                            if($row->ppa == "Dokter_Umum_IGD"){
                                $cluster = 1;
                            }else if($row->ppa == "STRUKTURAL"){
                                $cluster = 3;
                            }else if($row->ppa == "TERAPIS"){
                                $cluster = 2;
                            }else if($row->ppa == "JTL"){
                                $cluster = 4;
                            }else{
                                $cluster = 2;
                            }
                        }else{
                            $dokter = Dokter::where('KDDOKTER', @${$row['ppa']})->first();
                            $nama_dokter = $dokter->NAMADOKTER;
                            $kode_dokter = @${$row['ppa']};
                            $cluster = 1;
                        }
                        
                        if($nama_dokter == ""){
                            $kode_dokter = 0;
                            $nilai_remunerasi = 0;
                        }
    
                        if($row['sumber'] == "HARGA"){
                            if($row['value'] > 1 ){
                                if(@$tpendaftaran->KDPOLY == 104){
                                    $nilai_remunerasi = 20000;
                                }else{
                                    $nilai_remunerasi = $row['value'];
                                }
                            }else{
                                $nilai_remunerasi = $row['value'] * $data_sumber[$row['sumber']];
                            }
                            
                        }else if($row['sumber'] == "EMBALACE"){
                            $nilai_remunerasi = $row['value'] * $data_sumber[$row['sumber']];
                        }
                        else{
                            $nilai_remunerasi = $data_sumber[$row['sumber']]*$row['value'];
                        }

                      
                        if($row['ppa'] == "Dokter_Umum_IGD"){
                            $proporsi_fairness_umum_igd = $row;
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
                            'cluster'=>$cluster,
                            'idxdaftar'=>$idxdaftar,
                            'nomr'=>$nomr,
                            'tanggal'=>$data_detail_source->tgl_verifikasi,
                            'nama_ppa'=>$nama_dokter,
                            'kode_dokter'=>@$kode_dokter,
                            'sumber_value'=>$data_sumber[$row['sumber']],
                            'nilai_remunerasi'=>$nilai_remunerasi,
                            'remunerasi_source_id' => $data_detail_source->id_remunerasi_source
                        ];     
                        $total_remunerasi += $nilai_remunerasi;          
                        $savePembagianKlaim = PembagianKlaim::create($data);
                    }
            } 

            if( $TOTALBANKDARAH > 0){
                $dokter_bankdarah = [705,133];
                $persentase_bankdarah = [0.03,0.02];
                foreach($dokter_bankdarah as $key => $dokter){
                    $nama_dokter = Dokter::where('KDDOKTER', $dokter)->first()->NAMADOKTER;
                    $data = [
                        'groups'=>($data_detail_source->jenis == 'Rawat Jalan')?"RJTL":"RITL",
                        'jenis'=>$data_detail_source->jenis,
                        'grade'=>$grade,
                        'ppa'=>"Dokter_Bank_Darah",
                        'value'=>$persentase_bankdarah[$key],
                        'sumber'=>'TOTALBANKDARAH',
                        'flag'=>'',
                        'del'=>0,
                        'sep'=>$data_detail_source->no_sep,
                        'id_detail_source'=>$data_detail_source->id,
                        'cluster'=>1,
                        'idxdaftar'=>$idxdaftar,
                        'nomr'=>$nomr,
                        'tanggal'=>$data_detail_source->tgl_verifikasi,
                        'nama_ppa'=>$nama_dokter,
                        'kode_dokter'=>@$dokter,
                        'sumber_value'=>($data_sumber['TOTALBANKDARAH']),
                        'nilai_remunerasi'=>$persentase_bankdarah[$key]*$data_sumber['TOTALBANKDARAH'],
                        'remunerasi_source_id' => $data_detail_source->id_remunerasi_source
                    ];   
                    $total_remunerasi += $persentase_bankdarah[$key]*$data_sumber['TOTALBANKDARAH'];  
                    $savePembagianKlaim = PembagianKlaim::create($data);
                }
                
            }
           
           

            if($savePembagianKlaim){
              
                if($data_detail_source->biaya_disetujui == 0){
                    
                    $update = DetailSource::where('id', $detailSource->id)
                    ->update([
                            'status_pembagian_klaim'=>1,
                            'idxdaftar'=>$idxdaftar,
                            'biaya_disetujui'=>$VERIFIKASITOTAL,
                            'biaya_riil_rs'=>$VERIFIKASITOTAL,
                            'biaya_diajukan'=>$VERIFIKASITOTAL,
                            'total_remunerasi'=>$total_remunerasi,
                            'nomr'=>$nomr
                        ]);
                }else{
                    $update = DetailSource::where('id', $detailSource->id)
                    ->update([
                            'status_pembagian_klaim'=>1,
                            'idxdaftar'=>$idxdaftar,
                            'total_remunerasi'=>$total_remunerasi,
                            'nomr'=>$nomr
                        ]);
                }
                $failed += 0;
                $success += 1;
                    $message[] = "data $detailSource->no_sep berhasil di proses";
            }else{
                $update = DetailSource::where('id', $detailSource->id)
                ->update([
                    'status_pembagian_klaim'=>2
                ]);
                $failed += 1;
                $success += 0;
                $message[] = "data $detailSource->no_sep gagal di proses";
            }      
        }else if($data_detail_source->jenis == 'Rawat Inap'){
            // bpjps
            if(strpos($data_detail_source->no_sep,"-")){
                //membaca idxdaftar dan nomr / pasien umum
                $idxdaftar = $data_detail_source->idxdaftar;
                $data_admission = Tadmission::where('id_admission',$idxdaftar)->first();
                $totalTarifRs = $data_admission->getTotalTarifRsAttribute();
                $data_admission->total_tarif_rs = $totalTarifRs;
                $idxdaftar = $data_admission->id_admission;
                $nomr = $data_admission->nomr;
    
    
                $selisih = $totalTarifRs-$totalTarifRs;
                $persentase_selisih = $selisih/$totalTarifRs;
                $persentase_selisih = $persentase_selisih*100;
                
                $persentase_selisih = round($persentase_selisih, 2);
            
    
                $grade = Grade::where('persentase', '>=', $persentase_selisih)
                    ->orderBy('persentase', 'ASC')
                    ->first();
                    
                $grade = $grade->grade;
                
                $VERIFIKASITOTAL = $totalTarifRs;
    
            }else{
                // bpjps
                 $sep = $data_detail_source->no_sep;
                $data = $this->getIdxDaftar($sep);
                $idxdaftar = $data['idxdaftar'];
                $nomr = $data['nomr'];
                
                $selisih = $data_detail_source->biaya_disetujui-$data_detail_source->biaya_riil_rs;
                $selisih = $selisih*-1;
                if ($data_detail_source->biaya_disetujui != 0) {
                    $persentase_selisih = ($selisih / $data_detail_source->biaya_disetujui) * 100;
                } else {
                    $persentase_selisih = 0; // Atau null, tergantung logika kamu
                }
                $persentase_selisih = $persentase_selisih*100;
                if($persentase_selisih < 0){
                    $persentase_selisih = 0;
                }else if($persentase_selisih >= 20){
                    $persentase_selisih = 20;
                }else{
                    $persentase_selisih = $persentase_selisih;
                }        
                $grade = Grade::where('persentase', '>=', $persentase_selisih)
                    ->orderBy('persentase', 'ASC')
                    ->first();   
    
    
                    $grade = $grade->grade;
                    $sep = $data_detail_source->no_sep;
    
                $VERIFIKASITOTAL = $data_detail_source->biaya_disetujui;
            }
          
            $tadmission = Tadmission::where('id_admission', $idxdaftar)->first();
            $databilling = Tbillranap::where(['IDXDAFTAR' => $idxdaftar, 'NOMR' => $nomr])->get();
            $databilling_rajal = Tbillrajal::where(['IDXDAFTAR' => $idxdaftar, 'NOMR' => $nomr])->get();
          
    
            
            $pisau = 0; //
            $TOTALLPA = 0;//
            $TOTALPATKLIN = 0;//
            $TOTALRADIOLOGI = 0;//
            $TOTALBDRS = 0;//
            $TOTALHD = 0;
            $TOTALBANKDARAH = 0;
            $TINDAKANRAJAL_HARGA = 0;//
            $EMBALACE = 0;
            $TAHLIGIZI = 0;
            $Dokter_Umum_IGD = 0;
            
            $DPJP = @$tadmission->dokter_penanggungjawab;
            // ------------	
            $DOKTERKONSUL = "";
            $KONSULEN = "";
            $DPJPRABER = "";
            $DOKTERRABER = "";
            // ------------
            $LABORATORIST = "";
            $RADIOLOGIST = "";
            $AHLIGIZI = "";
            $ANALISLABKLINIK = "";
            $RADIOGRAFER = "";

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
            $Perawat_HD_Rajal = "";
            $DPJPCATHLAB = "";
            $PERAWAT_HD = "";
            $Apoteker = "";
            $STRUKTURAL = 1;
            $JTL = 1;
            $AHLIGIZI= "";
    
    
            
            $kddokter = [];
            $kddokter[] = $DPJP;
            $dokters_umum = [];
            $PENATABANKDARAH = "";
            

            $billing= [];
            foreach($databilling as $row1){
                $billing[] = $row1;
            }
            foreach($databilling_rajal as $row2){
                $billing[] = $row2;
            }
           

            foreach($billing as $row){
                
               
                if($row->UNIT == 15){
                    $pisau += 1;
                    $data_operasi = Moperasi::where(['IDXDAFTAR' => $idxdaftar, 'nomr' => $nomr])->where('status', '!=', 'batal')->get();
                    foreach($data_operasi as $row_operasi){
                        $OPERATOR[] = $row_operasi->kode_dokteroperator;
                        if($row_operasi->kode_dokteranastesi != ""){
                            $ANESTESI = $row_operasi->kode_dokteranastesi;
                              $PENATA = "9";
                        }
                        
                    }
    
                  
                    $ASISTEN = "10";
                }else if($row->UNIT == 17){
                    // cari dokter radiologi
                     $TOTALRADIOLOGI += $row->TARIFRS;
                    // $RADIOLOGIST = $row->KDDOKTER;
                    // cari dokterariologi
                    $radiologi = Tradiologi::where('IDXDAFTAR', $idxdaftar)->where('NOMR', $nomr)->first();
                    if($radiologi){
                        $RADIOLOGIST = $radiologi->DRRADIOLOGI;
                    }else{
                        $RADIOLOGIST = $row->KDDOKTER;
                    } 
                    

                    $RADIOGRAFER = "16";
                }
                if($row->id_kategori == 2||$row->id_kategori == 1){
                    if(!($row->KDDOKTER == $DPJP) && !in_array($row->KDDOKTER, [415,800,856,888])){
                        $kdprofesi = Dokter::where('KDDOKTER', $row->KDDOKTER)->first()->KDPROFESI;
                        if($kdprofesi == 1){
                            $kddokter[] = $row->KDDOKTER;
                        }else{
                            if (!in_array($row->KDDOKTER, $dokters_umum)) {
                                $dokters_umum[] = $row->KDDOKTER;
                            }
                        }
                    }
                }
                
                if(in_array($row->id_kategori, [14])){
                        
                    if($row->UNIT == '16'){
                        $TOTALPATKLIN += $row->TARIFRS;
                        $LABORATORIST = $row->KDDOKTER;
                        $ANALISLABKLINIK = "17";
                    }else if($row->UNIT == '163'){
                        $TOTALLPA += $row->TARIFRS;
                        $DOKTERLPA = 884;
                        $ANALISLABKLINIK = "18";
                    }
                    
                    
                }
                if(in_array($row->id_kategori, [15])){
                        
                   $TOTALBANKDARAH += $row->TARIFRS;
                   $PENATABANKDARAH = 19;
                    
                }
               
                if(in_array($row->id_kategori, [21])){
                    $HD  = $row->KDDOKTER;
                    $DOKTERHDRANAP = $row->KDDOKTER;
                    $TOTALHD += $row->TARIFRS;
                    $PERAWAT_HD_RANAP = 8;
                }
                if(in_array($row->id_kategori, [38,27])){
                  $AHLIGIZI = 15;
                  $TAHLIGIZI += 1;
                }
                if(in_array($row->KODETARIF, ['07'])){
                    $Apoteker = 6;
                    $EMBALACE += 1;
                }
            }
        

            if($EMBALACE > 0){
                
                $jumlah = DB::connection('simrs')
                    ->table('penjualan as a')
                    ->join('detail_penjualan as b', 'a.id', '=', 'b.id_penjualan')
                    ->where('a.id_pelanggan', '506637278')
                    ->orderByDesc('a.id')
                    ->selectRaw('COUNT(b.id) as jumlah')
                    ->first();
               
               
                $EMBALACE = $jumlah->jumlah*0.95;
                
            }
            
        
            $data_sumber = [
                "HARGA" => $TINDAKANRAJAL_HARGA,
                "EMBALACE" => $EMBALACE,
                "AHLIGIZI"=>$TAHLIGIZI,
                "TOTALPATKLIN" => $TOTALPATKLIN,
                "TOTALLPA" => $TOTALLPA,
                "TOTALRADIOLOGI" => $TOTALRADIOLOGI,
                "TOTALBDRS" => $TOTALBDRS,
                "VERIFIKASITOTAL" => $VERIFIKASITOTAL,
                "TOTALHD" => $TOTALHD,
                "TOTALBANKDARAH" => $TOTALBANKDARAH
            ];
           
          
          
            
            // cari data proporsi
            $proporsi_fairness = ProporsiFairness::
            where('grade', $grade)
            ->where('groups', ($data_detail_source->jenis == 'Rawat Jalan')?"RJTL":"RITL")
            ->where('jenis', ($pisau)?"PISAU":"NONPISAU")
            ->get();
            
            
            
            $pembagian = [];
            
            if(count($kddokter) > 0 && $kddokter[0] != ""){
                $dpjpraber = $this->groupAndCount($kddokter);
                if(count($dpjpraber['filtered']) > 1){
                    $DPJPRABER  =$tadmission->dokter_penanggungjawab;
                    $notdpjp = current(array_filter($dpjpraber['most_frequent']['value'], fn($val) => $val !== $DPJP));
                    $DOKTERRABER = $notdpjp;
                    $DPJP = "";
               }else{
                    
                    $notdpjp = current(array_filter($dpjpraber['most_frequent']['value'], fn($val) => $val !== $DPJP));
                    if(!$notdpjp == ""){
                        $DOKTERKONSUL = $tadmission->dokter_penanggungjawab;
                        $KONSULEN = $notdpjp;
                        $DPJP = "";
                    }

                   
               }
              
            }
        
           
           
            $divisi = Divisi::pluck('nama', 'id');
            $total_remunerasi = 0;
            $proporsi_fairness_radiologi = [];
            $proporsi_fairness_laboratorist = [];
             
            foreach($proporsi_fairness as $row){
                
              
                if(@${$row['ppa']} != "" && @${$row['ppa']} != 0){
    
                    $divisi_id = $divisi->search(function ($item, $key) use ($row) {
                        return $item == $row->ppa;
                    });
    
    
                    if($divisi_id !== false){
                        $nama_dokter = $row->ppa;
                        $kode_dokter = $divisi_id;
                        if($row->ppa == "Dokter_Umum_IGD"){
                            $cluster = 1;
                        }else if($row->ppa == "STRUKTURAL"){
                            $cluster = 3;
                        }else if($row->ppa == "JTL"){
                            $cluster = 4;
                        }else{
                            $cluster = 2;
                        }
                    }else{
                        $dokter = Dokter::where('KDDOKTER', @${$row['ppa']})->first();
                        $nama_dokter = $dokter->NAMADOKTER;
                        $kode_dokter = @${$row['ppa']};
                        $cluster = 1;
                    }
                    
                    if($nama_dokter == ""){
                        $kode_dokter = 0;
                        $nilai_remunerasi = 0;
                    }
    
                    if($row['sumber'] == "HARGA"){
                        if($row['value'] > 1 ){
                            if($row['ppa'] == "AHLIGIZI"){
                                $nilai_remunerasi = (int)$row['value'] * $data_sumber[$row['ppa']];
                            }else{
                                $nilai_remunerasi = $row['value'];
                            }
                          
                        }else{
                            $nilai_remunerasi = $row['value'] * $data_sumber[$row['sumber']];
                        }
                        
                    }else if($row['sumber'] == "EMBALACE"){
                        $nilai_remunerasi = $row['value'] * $data_sumber[$row['sumber']];
                    }
                    else{
                        $nilai_remunerasi = $data_sumber[$row['sumber']]*$row['value'];
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
                        'cluster'=>$cluster,
                        'idxdaftar'=>$idxdaftar,
                        'nomr'=>$nomr,
                        'tanggal'=>$data_detail_source->tgl_verifikasi,
                        'nama_ppa'=>$nama_dokter,
                        'kode_dokter'=>@$kode_dokter,
                        'sumber_value'=>$data_sumber[$row['sumber']],
                        'nilai_remunerasi'=>$nilai_remunerasi,
                        'remunerasi_source_id' => $data_detail_source->id_remunerasi_source
                    ]; 
                    $total_remunerasi += $nilai_remunerasi;        
                         
                    $savePembagianKlaim = PembagianKlaim::create($data);
                }
               
                if($row['ppa'] == "Dokter_Umum_IGD"){
                    $proporsi_fairness_umum_igd = $row;
                }

            }
           
            
            if( $TOTALBANKDARAH > 0){
                $dokter_bankdarah = [705,133];
                $persentase_bankdarah = [0.03,0.02];
                foreach($dokter_bankdarah as $key => $dokter){
                    $nama_dokter = Dokter::where('KDDOKTER', $dokter)->first()->NAMADOKTER;
                    $data = [
                        'groups'=>($data_detail_source->jenis == 'Rawat Jalan')?"RJTL":"RITL",
                        'jenis'=>$data_detail_source->jenis,
                        'grade'=>$grade,
                        'ppa'=>"Dokter_Bank_Darah",
                        'value'=>$persentase_bankdarah[$key],
                        'sumber'=>'TOTALBANKDARAH',
                        'flag'=>'',
                        'del'=>0,
                        'sep'=>$data_detail_source->no_sep,
                        'id_detail_source'=>$data_detail_source->id,
                        'cluster'=>1,
                        'idxdaftar'=>$idxdaftar,
                        'nomr'=>$nomr,
                        'tanggal'=>$data_detail_source->tgl_verifikasi,
                        'nama_ppa'=>$nama_dokter,
                        'kode_dokter'=>@$dokter,
                        'sumber_value'=>($data_sumber['TOTALBANKDARAH']),
                        'nilai_remunerasi'=>$persentase_bankdarah[$key]*$data_sumber['TOTALBANKDARAH'],
                        'remunerasi_source_id' => $data_detail_source->id_remunerasi_source
                    ];   
                    $total_remunerasi += $persentase_bankdarah[$key]*$data_sumber['TOTALBANKDARAH'];  
                    $savePembagianKlaim = PembagianKlaim::create($data);
                }
                
            }
            
            if(count($dokters_umum) > 0){
                foreach($dokters_umum as $dokter){
                    $nama_dokter = Dokter::where('KDDOKTER', $dokter)->first()->NAMADOKTER;
                
                    $data = [
                        'groups'=>($data_detail_source->jenis == 'Rawat Jalan')?"RJTL":"RITL",
                        'jenis'=>$data_detail_source->jenis,
                        'grade'=>$grade,
                        'ppa'=>"Dokter_Umum",
                        'value'=>$proporsi_fairness_umum_igd['value'],
                        'sumber'=>'VERIFIKASITOTAL',
                        'flag'=>'',
                        'del'=>0,
                        'sep'=>$data_detail_source->no_sep,
                        'id_detail_source'=>$data_detail_source->id,
                        'cluster'=>1,
                        'idxdaftar'=>$idxdaftar,
                        'nomr'=>$nomr,
                        'tanggal'=>$data_detail_source->tgl_verifikasi,
                        'nama_ppa'=>$nama_dokter,
                        'kode_dokter'=>@$dokter,
                        'sumber_value'=>(1/count($dokters_umum))*$data_sumber['VERIFIKASITOTAL'],
                        'nilai_remunerasi'=>(1/count($dokters_umum))*$proporsi_fairness_umum_igd['value']*$data_sumber['VERIFIKASITOTAL'],
                        'remunerasi_source_id' => $data_detail_source->id_remunerasi_source
                    ];   
                    $total_remunerasi += (1/count($dokters_umum))*$proporsi_fairness_umum_igd['value']*$data_sumber['VERIFIKASITOTAL'];  
                    $savePembagianKlaim = PembagianKlaim::create($data);
                }
            }
          
    
            // RADIOLOGIST
         
          
            

           
            $data['total_remunerasi'] = $total_remunerasi;
            if($data_detail_source->biaya_disetujui == 0){
                $data['persentase_remunerasi'] = 0;
            }else{
                $data['persentase_remunerasi'] = round($total_remunerasi/$data_detail_source->biaya_disetujui*100, 2);
            }
           
            
            if($savePembagianKlaim){
                if($data_detail_source->biaya_disetujui == 0){
                    
                    $update = DetailSource::where('id', $detailSource->id)
                    ->update([
                            'status_pembagian_klaim'=>1,
                            'idxdaftar'=>$idxdaftar,
                            'biaya_disetujui'=>$VERIFIKASITOTAL,
                            'total_remunerasi'=>$total_remunerasi,
                            'nomr'=>$nomr
                        ]);
                }else{
                    $update = DetailSource::where('id', $detailSource->id)
                    ->update([
                            'status_pembagian_klaim'=>1,
                            'idxdaftar'=>$idxdaftar,
                            'total_remunerasi'=>$total_remunerasi,
                            'nomr'=>$nomr
                        ]);
                }

               
                $success += 1;
                $failed += 0;
                    $message[] = "data $detailSource->no_sep berhasil diproses";
    
            }else{
                $update = DetailSource::where('id', $detailSource->id)
            ->update([
                    'status_pembagian_klaim'=>2
                ]);
                $failed += 1;
                $success += 0;
                $message[] = "data $detailSource->no_sep gagal diproses";
            }
            
        }
       
        return [
            "failed"=>$failed,
            "success"=>$success,
            "message"=>$message,
            "data"=>$data_detail_source
        ];
    }
    
    
    function groupAndCount(array $data): array {
        // Hitung jumlah kemunculan
        if(!is_array($data)){
            return [];
        }
        if($data[0] == ""){
              return [];
        }
        $counted = array_count_values($data);
    
        // Ambil hanya elemen yang muncul lebih dari 1 kali
        $filtered = array_filter($counted, fn($count) => $count > 1);
    
        // Jika tidak ada yang muncul lebih dari 1 kali
        if (empty($filtered)) {
           
            $maxValue = max($counted);
            $minValue = min($counted);
            $mostFrequent = array_keys($counted, $maxValue);
            $minFrequent = array_keys($counted, $minValue);
            return [
                'filtered' => [],
                'most_frequent' => [
                    'value' => $mostFrequent,
                    'count' => $maxValue
                ],
                'min_frequent' => [
                    'value' => $minFrequent,
                    'count' => $minValue
                ]
            ];
        }
    
        // Cari jumlah terbanyak
        $maxValue = max($filtered);
        $minValue = min($filtered);
    
        // Ambil semua elemen yang muncul sebanyak nilai maksimum
        $mostFrequent = array_keys($filtered, $maxValue);
        $minFrequent = array_keys($filtered, $minValue);
    
        return [
            'filtered' => $filtered,
            'most_frequent' => [
                'value' => $mostFrequent,
                'count' => $maxValue
            ],
            'min_frequent' => [
                'value' => $minFrequent,
                'count' => $minValue
            ]
        ];
    }

    /**
     * Proses sinkronisasi batch
     */
    public function syncBatch(Request $request, $sourceId)
    {
     
                $limit = $request->limit;
                $offset = $request->offset;
                $success = 0;
                $failed = 0;
             
                $detailSource =  DetailSource::where('id_remunerasi_source', $sourceId)
                ->where('status_pembagian_klaim', '<>', 1)
                // ->inRandomOrder()
                ->limit($limit);
           
                if($detailSource->count() < 1){
                    $failed += 1;
                    $message[] = "data $detailSource->no_sep tidak ditemukan";
                }else{
                    foreach ($detailSource->get() as $key => $row) {

                        $response = $this->hitung($sourceId,$row);
                      
                        $failed  += $response['failed'];
                        $success += $response['success'];
                        $message[] = $response['message'];
                    }
                      
                }



                    // Cek apakah masih ada data yang perlu diproses
                    $remainingCount = DetailSource::where('id_remunerasi_source', $sourceId)
                            ->where('status_pembagian_klaim', 0)
                            ->count();
                
                

                    return response()->json([
                        'processed' => $success+$failed,
                        'success' => $success,
                        'failed' => $failed,
                        "message"=>$message,
                        'hasMore' => $remainingCount > 0
                    ]);

      
    }
    function getIdxDaftar($sep) {
        if(strpos($sep,"-") !== false){
            $tpendaftaran = Tpendaftaran::where('IDXDAFTAR', $sep)->first();
            if($tpendaftaran){
                $idxdaftar = $tpendaftaran->IDXDAFTAR;
                $nomr = $tpendaftaran->NOMR;
            }
        }else{
            $detailSource = DetailSource::where('no_sep', $sep)->where('idxdaftar', '>', 1);
            if($detailSource->count() > 0){
                $idxdaftar = $detailSource->orderBy('idxdaftar', 'desc')->first()->idxdaftar;
                $nomr = $detailSource->orderBy('idxdaftar', 'desc')->first()->nomr;
            }else{
                $tbpjs = Sepbpjs::where('noSep', $sep)->first();
                if($tbpjs){
                    $idxdaftar = $tbpjs->idxdaftar;
                    $nomr = $tbpjs->peserta_noMr;
                    if($nomr == ""){
                        $response = $tbpjs->responseJSON;
                        $nomr = $this->ambilNoMR($response);
                    }
                    if($nomr == ""){
                        
                        $datasep = $this->getApi("http://192.168.10.5/bpjs_2/cari_pasien/cari_idx2.php?q=".$sep);
                        $data = json_decode($datasep);
                        if(@$data->success){
                            $idxdaftar = $data->data->idxdaftar;
                            $nomr = $data->data->nomr;
                        }else{
                            $pendaftaran = Tpendaftaran::where('IDXDAFTAR', $idxdaftar);
                            if($pendaftaran->count() > 0){
                                $pendaftaran = $pendaftaran->first();
                                $nomr = $pendaftaran->NOMR;
                            }

                        }
                        
                    
                    }
                
                    
                
                }else{
                
                    $datasep = $this->getApi("http://192.168.10.5/bpjs_2/cari_pasien/cari_idx2.php?q=".$sep);
                    $data = json_decode($datasep);
            
                    
                    if($data->success){
                        $idxdaftar = $data->data->idxdaftar;
                        $nomr = $data->data->nomr;
                    }else{
                        return [
                            'idxdaftar' => "",
                            'nomr' => ""
                        ];
                    }
                
                
                }

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