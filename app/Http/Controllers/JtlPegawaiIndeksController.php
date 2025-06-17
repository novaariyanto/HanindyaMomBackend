<?php

namespace App\Http\Controllers;

use App\Models\JtlPegawaiIndeks;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class JtlPegawaiIndeksController extends Controller
{
    /**
     * Menampilkan daftar jtl pegawai indeks.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JtlPegawaiIndeks::with(['unitKerja']);
            // Filter berdasarkan unit kerja
            if ($request->has('unit_kerja_id') && $request->unit_kerja_id != '') {
                $data->where('unit_kerja_id', $request->unit_kerja_id);
            }
            
            // Filter berdasarkan pencarian global
            if ($request->has('search') && $request->search != '') {
               $data->where('nama_pegawai', 'like', '%'.$request->search.'%')
                    ->orWhere('nik', 'like', '%'.$request->search.'%');
            }
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_pegawai', function($row) {
                    return $row->nama_pegawai;
                })
                ->addColumn('nik_pegawai', function($row) {
                    return $row->nik;
                })
                ->addColumn('unit_kerja', function($row) {
                    return $row->unitKerja ? $row->unitKerja->nama : '-';
                })
                ->editColumn('dasar', function($row) {
                    return number_format($row->dasar, 2);
                })
                ->editColumn('kompetensi', function($row) {
                    return number_format($row->kompetensi, 2);
                })
                ->editColumn('resiko', function($row) {
                    return number_format($row->resiko, 2);
                })
                ->editColumn('emergensi', function($row) {
                    return number_format($row->emergensi, 2);
                })
                ->editColumn('posisi', function($row) {
                    return number_format($row->posisi, 2);
                })
                ->editColumn('kinerja', function($row) {
                    return number_format($row->kinerja, 2);
                })
                ->editColumn('jumlah', function($row) {
                    return '<strong>' . number_format($row->jumlah, 2) . '</strong>';
                })
                ->addColumn('rekening', function($row) {
                    return $row->rekening ?? '-';
                })
                ->addColumn('pajak', function($row) {
                    return $row->pajak ? number_format($row->pajak, 2) : '-';
                })
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('jtl-pegawai-indeks.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('jtl-pegawai-indeks.destroy', $row->id) . '"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['action', 'jumlah'])
                ->make(true);
        }

        $pegawai = Pegawai::all();
        $unitKerja = UnitKerja::orderBy('nama')->get();
        
        return view('jtl-pegawai-indeks.index', compact('pegawai', 'unitKerja'));
    }

    /**
     * Menyimpan jtl pegawai indeks baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pegawai' => 'required',
            'dasar' => 'required|numeric|min:0|max:99999999.99',
            'kompetensi' => 'required|numeric|min:0|max:99999999.99',
            'resiko' => 'required|numeric|min:0|max:99999999.99',
            'emergensi' => 'required|numeric|min:0|max:99999999.99',
            'posisi' => 'required|numeric|min:0|max:99999999.99',
            'kinerja' => 'required|numeric|min:0|max:99999999.99',
            'rekening' => 'nullable|string|max:50',
            'pajak' => 'nullable|numeric|min:0|max:99999999.99'
        ], [
            'id_pegawai.required' => 'Pegawai harus dipilih',
            'id_pegawai.exists' => 'Pegawai tidak ditemukan',
            'id_pegawai.unique' => 'Indeks untuk pegawai ini sudah ada',
            'dasar.required' => 'Nilai dasar harus diisi',
            'dasar.numeric' => 'Nilai dasar harus berupa angka',
            'dasar.min' => 'Nilai dasar tidak boleh negatif',
            'kompetensi.required' => 'Nilai kompetensi harus diisi',
            'kompetensi.numeric' => 'Nilai kompetensi harus berupa angka',
            'kompetensi.min' => 'Nilai kompetensi tidak boleh negatif',
            'resiko.required' => 'Nilai resiko harus diisi',
            'resiko.numeric' => 'Nilai resiko harus berupa angka',
            'resiko.min' => 'Nilai resiko tidak boleh negatif',
            'emergensi.required' => 'Nilai emergensi harus diisi',
            'emergensi.numeric' => 'Nilai emergensi harus berupa angka',
            'emergensi.min' => 'Nilai emergensi tidak boleh negatif',
            'posisi.required' => 'Nilai posisi harus diisi',
            'posisi.numeric' => 'Nilai posisi harus berupa angka',
            'posisi.min' => 'Nilai posisi tidak boleh negatif',
            'kinerja.required' => 'Nilai kinerja harus diisi',
            'kinerja.numeric' => 'Nilai kinerja harus berupa angka',
            'kinerja.min' => 'Nilai kinerja tidak boleh negatif',
            'rekening.string' => 'Rekening harus berupa teks',
            'rekening.max' => 'Rekening maksimal 50 karakter',
            'pajak.numeric' => 'Pajak harus berupa angka',
            'pajak.min' => 'Pajak tidak boleh negatif'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $jtlPegawaiIndeks = JtlPegawaiIndeks::create($request->all());
            return ResponseFormatter::success($jtlPegawaiIndeks, 'Data indeks pegawai berhasil ditambahkan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat menyimpan data', 500);
        }
    }

    /**
     * Menampilkan jtl pegawai indeks spesifik.
     */
    public function show($id)
    {
        try {
            $jtlPegawaiIndeks = JtlPegawaiIndeks::with(['pegawai'])->findOrFail($id);
            return ResponseFormatter::success($jtlPegawaiIndeks, 'Data indeks pegawai berhasil ditemukan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }
    }

    /**
     * Mengupdate jtl pegawai indeks yang ada.
     */
    public function update(Request $request, $id)
    {
        $jtlPegawaiIndeks = JtlPegawaiIndeks::find($id);

        if (!$jtlPegawaiIndeks) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan', 404);
        }

        $validator = Validator::make($request->all(), [
            'id_pegawai' => 'required',
            'dasar' => 'required|numeric|min:0|max:99999999.99',
            'kompetensi' => 'required|numeric|min:0|max:99999999.99',
            'resiko' => 'required|numeric|min:0|max:99999999.99',
            'emergensi' => 'required|numeric|min:0|max:99999999.99',
            'posisi' => 'required|numeric|min:0|max:99999999.99',
            'kinerja' => 'required|numeric|min:0|max:99999999.99',
            'rekening' => 'nullable|string|max:50',
            'pajak' => 'nullable|numeric|min:0|max:99999999.99'
        ], [
            'id_pegawai.required' => 'Pegawai harus dipilih',
            'id_pegawai.exists' => 'Pegawai tidak ditemukan',
            'id_pegawai.unique' => 'Indeks untuk pegawai ini sudah ada',
            'dasar.required' => 'Nilai dasar harus diisi',
            'dasar.numeric' => 'Nilai dasar harus berupa angka',
            'dasar.min' => 'Nilai dasar tidak boleh negatif',
            'kompetensi.required' => 'Nilai kompetensi harus diisi',
            'kompetensi.numeric' => 'Nilai kompetensi harus berupa angka',
            'kompetensi.min' => 'Nilai kompetensi tidak boleh negatif',
            'resiko.required' => 'Nilai resiko harus diisi',
            'resiko.numeric' => 'Nilai resiko harus berupa angka',
            'resiko.min' => 'Nilai resiko tidak boleh negatif',
            'emergensi.required' => 'Nilai emergensi harus diisi',
            'emergensi.numeric' => 'Nilai emergensi harus berupa angka',
            'emergensi.min' => 'Nilai emergensi tidak boleh negatif',
            'posisi.required' => 'Nilai posisi harus diisi',
            'posisi.numeric' => 'Nilai posisi harus berupa angka',
            'posisi.min' => 'Nilai posisi tidak boleh negatif',
            'kinerja.required' => 'Nilai kinerja harus diisi',
            'kinerja.numeric' => 'Nilai kinerja harus berupa angka',
            'kinerja.min' => 'Nilai kinerja tidak boleh negatif',
            'rekening.string' => 'Rekening harus berupa teks',
            'rekening.max' => 'Rekening maksimal 50 karakter',
            'pajak.numeric' => 'Pajak harus berupa angka',
            'pajak.min' => 'Pajak tidak boleh negatif'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $jtlPegawaiIndeks->update($request->all());
            return ResponseFormatter::success($jtlPegawaiIndeks, 'Data indeks pegawai berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat mengupdate data', 500);
        }
    }

    /**
     * Menghapus jtl pegawai indeks.
     */
    public function destroy($id)
    {
        try {
            $jtlPegawaiIndeks = JtlPegawaiIndeks::findOrFail($id);
            $jtlPegawaiIndeks->delete();
            return ResponseFormatter::success(null, 'Data indeks pegawai berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage(), 500);
        }
    }
    function hapusGelar($nama)
    {
        // Gelar di awal nama (prefix)
        $gelarAwal = [
            'dr', 'drg', 'dra', 'drh', 'prof', 'h', 'hj'
        ];

        // Gelar di akhir nama (sarjana, diploma, magister, spesialis, dll)
        $gelarAkhir = [
            // Sarjana
            's.t', 's.kom', 's.si', 's.pd', 's.e', 's.h', 's.s', 's.ag', 's.ked',
            's.farm', 's.kep', 's.gz', 's.ip', 's.i.kom', 's.i.p', 's.sn', 's.kar',
            's.p', 's.pt', 's.hum', 's.bns', 's.psi', 's.tr', 's.ak', 's.k.m',
            's.t.p', 's.pi', 's.k',

            // Gelar tanpa titik umum
            'se', 'sh', 'skom', 'st', 'spd', 'ssi', 'sag', 'sked', 'sfarm', 'sik', 'sip',

            // Diploma
            'a.md', 'amd','A.Md','S. Akt','S.Akt','S.M',

            // Pascasarjana
            'm.kes', 'm.si', 'm.pd', 'm.hum', 'm.p', 'm.m', 'mm', 'm.sc', 'm.eng', 
            'm.ag', 'm.kom', 'm.h', 'ph.d',

            // Spesialis
            'sp.a', 'sp.pd', 'sp.b', 'sp.og', 'sp.kj', 'sp.k', 'sp.m', 'sp.tht', 'sp.an'
        ];
        $nama = preg_replace('/,/', '', $nama);
        // Normalisasi nama ke huruf kecil
        $nama = strtolower(trim($nama));

        // Hapus gelar di awal nama (prefix)
        foreach ($gelarAwal as $gelar) {
            if (preg_match('/^' . preg_quote($gelar, '/') . '\.?\s+/i', $nama)) {
                $nama = preg_replace('/^' . preg_quote($gelar, '/') . '\.?\s+/i', '', $nama);
            }
        }

        // Hapus semua gelar di akhir nama (loop sampai tidak ada lagi)
        do {
            $pattern = '/[, ]*\b(' . implode('|', array_map('preg_quote', $gelarAkhir)) . ')\b\.?/i';
            $nama = preg_replace($pattern, '', $nama, -1, $count);
        } while ($count > 0);

        // Kembalikan format nama kapital
        return ucwords(trim($nama));
    }

    function ambilDuaKataPertama($teks) {
        $kata = preg_split('/\s+/', trim($teks));
        return implode(' ', array_slice($kata, 0, 2));
    }

    /**
     * Import data dari Excel
     */
    public function import(Request $request)
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
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            // Remove header
            array_shift($rows);
            
            $success = 0;
            $failed = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                $rowData = [
                    'id_pegawai' => trim($row[0] ?? ''),
                    'dasar' => floatval($row[1] ?? 0),
                    'kompetensi' => floatval($row[2] ?? 0),
                    'resiko' => floatval($row[3] ?? 0),
                    'emergensi' => floatval($row[4] ?? 0),
                    'posisi' => floatval($row[5] ?? 0),
                    'kinerja' => floatval($row[6] ?? 0),
                    'rekening' => trim($row[7] ?? ''),
                    'pajak' => floatval($row[8] ?? 0)
                ];

                // Validate each row
                $rowValidator = Validator::make($rowData, [
                    'id_pegawai' => 'required|string',
                    'dasar' => 'required|numeric|min:0|max:99999999.99',
                    'kompetensi' => 'required|numeric|min:0|max:99999999.99',
                    'resiko' => 'required|numeric|min:0|max:99999999.99',
                    'emergensi' => 'required|numeric|min:0|max:99999999.99',
                    'posisi' => 'required|numeric|min:0|max:99999999.99',
                    'kinerja' => 'required|numeric|min:0|max:99999999.99',
                    'rekening' => 'nullable|string|max:50',
                    'pajak' => 'nullable|numeric|min:0|max:99999999.99'
                ]);

                if ($rowValidator->fails()) {
                    $failed++;
                    $errors[] = "Baris " . ($index + 2) . ": " . implode(', ', $rowValidator->errors()->all());
                    continue;
                }

                // Check if pegawai exists
                $nama = $this->hapusGelar($rowData['id_pegawai']);
                $nama = $this->ambilDuaKataPertama($nama);
                $nama = str_replace("'", "", $nama);
                $pegawai = Pegawai::where('nik', $nama)
                    ->orWhere('nama', 'like','%'.$nama.'%')
                    ->first();

                if (!$pegawai) {
                    $failed++;
                    $errors[] = "Baris " . ($index + 2) . ": Pegawai dengan NIK {$nama} tidak ditemukan";
                    continue;
                }

                // Update id_pegawai to use pegawai ID
                $rowData['id_pegawai'] = $pegawai->id;
                $rowData['nama_pegawai'] = $pegawai->nama;
                $rowData['nik'] = $pegawai->nik;
                
                $rowData['unit_kerja_id'] = @$pegawai->mutasiAktif->unit_kerja_id;
             
                

                // Check if data already exists
                $existing = JtlPegawaiIndeks::where('id_pegawai', $pegawai->id)->first();
                
                try {
                    if ($existing) {
                        // Update existing
                        $existing->update($rowData);
                    } else {
                        // Create new
                        JtlPegawaiIndeks::create($rowData);
                    }
                    $success++;
                } catch (\Exception $e) {
                    $failed++;
                    $errors[] = "Baris " . ($index + 2) . ": Gagal menyimpan data - " . $e->getMessage();
                }
            }

            $message = "Import selesai. Berhasil: {$success}, Gagal: {$failed}";
            
            if (!empty($errors)) {
                $message .= "\n\nError Detail:\n" . implode("\n", array_slice($errors, 0, 10));
                if (count($errors) > 10) {
                    $message .= "\n... dan " . (count($errors) - 10) . " error lainnya";
                }
            }

            return ResponseFormatter::success([
                'success' => $success,
                'failed' => $failed,
                'errors' => $errors
            ], $message);
            
        } catch (\Exception $e) {
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
            $sheet->setTitle('Template JTL Pegawai Indeks');

            // Set header kolom
            $headers = [
                'A1' => 'NIK Pegawai',
                'B1' => 'Dasar',
                'C1' => 'Kompetensi',
                'D1' => 'Resiko',
                'E1' => 'Emergensi',
                'F1' => 'Posisi',
                'G1' => 'Kinerja',
                'H1' => 'Rekening',
                'I1' => 'Pajak'
            ];

            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }

            // Set contoh data
            $exampleData = [
                'A2' => '1234567890123456',
                'B2' => '1000.00',
                'C2' => '800.00',
                'D2' => '500.00',
                'E2' => '300.00',
                'F2' => '700.00',
                'G2' => '600.00',
                'H2' => '622123xxx',
                'I2' => '5'
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

            // Set format angka untuk kolom nilai
            $sheet->getStyle('B2:G2')->getNumberFormat()->setFormatCode('#,##0.00');

            // Tambahkan instruksi
            $sheet->setCellValue('A4', 'PETUNJUK:');
            $sheet->setCellValue('A5', '1. NIK Pegawai harus sesuai dengan data pegawai yang ada di database');
            $sheet->setCellValue('A6', '2. Semua nilai harus berupa angka (decimal)');
            $sheet->setCellValue('A7', '3. Nilai minimum adalah 0.00 dan maksimum 99,999,999.99');
            $sheet->setCellValue('A8', '4. Jika NIK sudah ada, data akan diupdate');
            $sheet->setCellValue('A9', '5. Total akan dihitung otomatis oleh sistem');
            $sheet->setCellValue('A10', '6. Rekening dan Pajak boleh diisi dengan nomor rekening dan pajak');
            
            $sheet->getStyle('A4')->getFont()->setBold(true);
            $sheet->getStyle('A5:A10')->getFont()->setSize(10);

            // Buat writer untuk output
            $writer = new Xlsx($spreadsheet);

            // Set header untuk download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="template_jtl_pegawai_indeks.xlsx"');
            header('Cache-Control: max-age=0');

            // Simpan file ke output
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Gagal mengunduh template: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Export data berdasarkan filter
     */
    public function export(Request $request)
    {
        try {
            // Ambil data berdasarkan filter yang sama seperti di index
            $query = JtlPegawaiIndeks::with(['unitKerja']);
            
            // Filter berdasarkan unit kerja
            if ($request->has('unit_kerja_id') && $request->unit_kerja_id != '') {
                $query->where('unit_kerja_id', $request->unit_kerja_id);
            }
            
            // Filter berdasarkan pencarian global
            if ($request->has('search') && $request->search != '') {
                $query->where('nama_pegawai', 'like', '%'.$request->search.'%')
                     ->orWhere('nik', 'like', '%'.$request->search.'%');
            }
            
            $data = $query->orderBy('nama_pegawai')->get();
            
            // Buat spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set judul worksheet
            $sheet->setTitle('Data JTL Pegawai Indeks');
            
            // Set header
            $headers = [
                'A1' => 'NIK',
                'B1' => 'Dasar',
                'C1' => 'Kompetensi',
                'D1' => 'Resiko',
                'E1' => 'Emergensi',
                'F1' => 'Posisi',
                'G1' => 'Kinerja',
                'H1' => 'Rekening',
                'I1' => 'Pajak',
                'J1' => 'Nama Pegawai',
                'K1' => 'Unit Kerja'
            ];
            
            foreach ($headers as $cell => $value) {
                $sheet->setCellValue($cell, $value);
            }
            
            // Style header
            $sheet->getStyle('A1:K1')->getFont()->setBold(true);
            $sheet->getStyle('A1:K1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E2E2E2');
            
            // Tambahkan data
            $row = 2;
            $no = 1;
            foreach ($data as $item) {
                $sheet->setCellValue('A' . $row, "'".$item->nik);
                $sheet->setCellValue('B' . $row,  $item->dasar);
                $sheet->setCellValue('C' . $row,  $item->kompetensi);
                $sheet->setCellValue('D' . $row,  $item->resiko);
                $sheet->setCellValue('E' . $row,  $item->emergensi);
                $sheet->setCellValue('F' . $row,  $item->posisi);
                $sheet->setCellValue('G' . $row,  $item->kinerja);
                $sheet->setCellValue('H' . $row,  $item->rekening ?? '-');
                $sheet->setCellValue('I' . $row, $item->pajak ?? '-');
                $sheet->setCellValue('J' . $row, $item->nama_pegawai ?? '-');
                $sheet->setCellValue('K' . $row,  $item->unitKerja ? $item->unitKerja->nama : '-');            
                $row++;
                $no++;
            }
            
            // Format angka untuk kolom nilai
            $lastRow = $row - 1;
            if ($lastRow > 1) {
                $sheet->getStyle('B2:I' . $lastRow)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('J2:K' . $lastRow)->getNumberFormat()->setFormatCode('#,##0.00');
            }
            
            // Set lebar kolom otomatis
            foreach(range('A','K') as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
            
            // Tambahkan border
            if ($lastRow > 1) {
                $sheet->getStyle('A1:K' . $lastRow)->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            }
            
            // Generate filename dengan timestamp dan filter info
            $filename = 'jtl_pegawai_indeks_' . date('Y-m-d_H-i-s');
            if ($request->unit_kerja_id) {
                $unitKerja = UnitKerja::find($request->unit_kerja_id);
                if ($unitKerja) {
                    $filename .= '_' . str_replace(' ', '_', strtolower($unitKerja->nama));
                }
            }
            if ($request->search) {
                $filename .= '_filter_' . str_replace(' ', '_', strtolower($request->search));
            }
            $filename .= '.xlsx';
            
            // Buat writer untuk output
            $writer = new Xlsx($spreadsheet);
            
            // Set header untuk download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            // Simpan file ke output
            $writer->save('php://output');
            exit;
            
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Gagal mengeksport data: ' . $e->getMessage(), 500);
        }
    }
} 