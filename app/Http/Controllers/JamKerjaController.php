<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Divisi;
use App\Models\DivisiShift;
use App\Models\JamKerja;
use App\Models\Shift;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;


class JamKerjaController extends Controller
{
    //


    public function index()
    {
        // Ambil semua shift beserta jam kerjanya
        // $shifts = Shift::with('jamKerja')->get();
    
        // Ambil semua divisi
        $divisis = Divisi::with('shifts')->get();

    
        // return $divisis;
        // Mapping nama hari ke angka
        $hariMapping = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];
    
        return view('pages.jam_kerja.index', compact( 'hariMapping', 'divisis'));
    }

    public function table(Request $request)
    {
        // Ambil parameter divisi dari request
        $divisi = $request->input('divisi');

        // Query untuk mendapatkan data divisi beserta shifts-nya
        $query = Divisi::with('shifts');

        // Jika parameter divisi ada, lakukan filter
        if ($divisi) {
            $query->where('id', $divisi);
        }

        // Eksekusi query
        $divisis = $query->get();

        // Kirim data ke view
        return view('pages.jam_kerja.table', compact('divisis'));
    }
    

    public function create(Request $request){

        $hari = $request->hari;
        $divisi_id = $request->divisi_id;

        $divisi =null;
        if ($divisi_id) {
            # code...
            $divisi = Divisi::find($divisi_id);
        }
        @$shift = Shift::where('uuid',$request->shift)->first();
        return view('pages.jam_kerja.create',compact('shift','divisi','divisi_id'));

    }

  /**
     * Simpan data divisi_shift baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'divisi' => 'required|exists:divisis,id', // Pastikan divisi_id ada di tabel divisis
            'shift' => 'required|exists:shifts,id',   // Pastikan shift_id ada di tabel shifts
        ]);

        // Cek apakah kombinasi divisi_id dan shift_id sudah ada
        $existingRecord = DivisiShift::where('divisi_id', $request->divisi)
                                     ->where('shift_id', $request->shift)
                                     ->first();

        if ($existingRecord) {
            return ResponseFormatter::error(
                [],
                'Kombinasi Divisi dan Shift sudah ada.'
            );
        }

        // Simpan data baru
        $divisiShift = new DivisiShift();
        $divisiShift->divisi_id = $request->divisi;
        $divisiShift->shift_id = $request->shift;

        if ($divisiShift->save()) {
            return ResponseFormatter::success(
                $divisiShift,
                'Berhasil Menambahkan Shift ke Divisi'
            );
        }

        return ResponseFormatter::error(
            [],
            'Gagal Menambahkan Shift ke Divisi'
        );
    }
        /**
     * Export data jam kerja ke Excel.
     */
  /**
     * Export data jam kerja ke Excel.
     */

     public function export()
    {
        // Ambil semua shift beserta jam kerjanya
        $shifts = Shift::with('jamKerja')->get();

        // Mapping nama hari ke angka
        $hariMapping = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        // Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom utama
        $sheet->setCellValue('A1', 'Kode');
        $sheet->setCellValue('B1', 'Nama Shift');

        // Merge cells untuk judul "Kode" dan "Nama Shift" hanya 2 baris
        $sheet->mergeCells("A1:A2"); // Merge Kode
        $sheet->mergeCells("B1:B2"); // Merge Nama Shift

        // Center alignment untuk judul "Kode" dan "Nama Shift"
        $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1:B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Merge cells untuk nama hari
        $col = 'C'; // Mulai dari kolom C
        foreach ($hariMapping as $hari) {
            $sheet->mergeCells($col . '1:' . chr(ord($col) + 1) . '1'); // Gabungkan 2 kolom
            $sheet->setCellValue($col . '1', $hari); // Nama hari
            $sheet->setCellValue($col . '2', 'Jam Mulai'); // Sub-header Jam Mulai
            $sheet->setCellValue(chr(ord($col) + 1) . '2', 'Jam Selesai'); // Sub-header Jam Selesai

            // Center alignment untuk nama hari dan sub-header
            $sheet->getStyle($col . '1:' . chr(ord($col) + 1) . '2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $col = chr(ord($col) + 2); // Pindah ke kolom berikutnya
        }

        // Styling: Border Hitam untuk Semua Sel
        $lastColumn = $sheet->getHighestDataColumn();
        $lastRow = $sheet->getHighestDataRow();
        $sheet->getStyle("A1:$lastColumn$lastRow")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Warna hitam
                ],
            ],
        ]);

        // Styling: Background Hijau untuk Header
        $headerRange = "A1:$lastColumn" . '2'; // Range header (baris pertama dan kedua)
        $sheet->getStyle($headerRange)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '90EE90', // Warna hijau muda
                ],
            ],
        ]);

        // Isi data ke dalam sheet
        $row = 3; // Mulai dari baris ketiga
        foreach ($shifts as $shift) {
            // Isi Kode dan Nama Shift
            $sheet->setCellValue('A' . $row, $shift->kode_shift); // Kode
            $sheet->setCellValue('B' . $row, $shift->nama); // Nama Shift

            // Isi jam kerja untuk setiap hari
            $col = 'C'; // Mulai dari kolom C
            foreach ($hariMapping as $hariValue => $hariLabel) {
                $jamKerja = $shift->jamKerja->firstWhere('hari', $hariValue);
                if ($jamKerja && $jamKerja->jam_mulai && $jamKerja->jam_selesai) {
                    // Format waktu ke H:i
                    $sheet->setCellValue($col . $row, \Carbon\Carbon::createFromFormat('H:i:s', $jamKerja->jam_mulai)->format('H:i')); // Jam Mulai
                    $sheet->setCellValue(chr(ord($col) + 1) . $row, \Carbon\Carbon::createFromFormat('H:i:s', $jamKerja->jam_selesai)->format('H:i')); // Jam Selesai
                } else {
                    $sheet->setCellValue($col . $row, '-'); // Kosong jika tidak ada data
                    $sheet->setCellValue(chr(ord($col) + 1) . $row, '-'); // Kosong jika tidak ada data
                }
                $col = chr(ord($col) + 2); // Pindah ke kolom berikutnya
            }

            $row++;
        }

        // Auto width untuk semua kolom
        foreach (range('A', $sheet->getHighestDataColumn()) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Simpan file Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'jam_kerja.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);

        // Simpan file sementara
        $writer->save($tempFile);

        // Kirim file ke browser
        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    /**
     * Import data jam kerja dari Excel.
     */
      /**
     * Import data jam kerja dari Excel.
     */
    public function import(Request $request)
    {
        // Validasi file upload
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            // Baca file Excel
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Mapping nama hari ke angka
            $hariMapping = [
                'Senin' => 1,
                'Selasa' => 2,
                'Rabu' => 3,
                'Kamis' => 4,
                'Jumat' => 5,
                'Sabtu' => 6,
                'Minggu' => 7,
            ];

            // Proses data baris per baris (mulai dari baris ketiga)
            foreach ($rows as $index => $row) {
                // Lewati header (baris pertama dan kedua)
                if ($index < 2) {
                    continue;
                }

                // Ambil kode shift dan nama shift
                $kode = trim($row[0]);
                $namaShift = trim($row[1]);

                if (!empty($kode)) {
                    # code...
                // Cari atau buat shift berdasarkan kode
                $shift = Shift::firstOrCreate(['kode_shift' => $kode], ['nama' => $namaShift]);

                // Iterasi kolom hari (mulai dari kolom ketiga)
                $colIndex = 2; // Kolom C
                foreach ($hariMapping as $hariLabel => $hariValue) {
                    $jamMulai = trim($row[$colIndex] ?? '-');
                    $jamSelesai = trim($row[$colIndex + 1] ?? '-');

                    // Jika jam mulai dan selesai tidak kosong, simpan ke database
                    if ($jamMulai !== '-' && $jamSelesai !== '-') {
                        JamKerja::updateOrCreate(
                            [
                                'shift_id' => $shift->id,
                                'hari' => $hariValue,
                            ],
                            [
                                'jam_mulai' => \Carbon\Carbon::createFromFormat('H:i', $jamMulai)->format('H:i:s'),
                                'jam_selesai' => \Carbon\Carbon::createFromFormat('H:i', $jamSelesai)->format('H:i:s'),
                            ]
                        );
                    }

                    $colIndex += 2; // Pindah ke kolom berikutnya (2 kolom per hari)
                }
            }


            }

            // exit;
            return redirect()->back()->with('success', 'Data jam kerja berhasil diimpor.');
        } catch (\Exception $e) {
            print_r($e->getMessage());
            // return redirect()->back()->withErrors(['file' => 'Gagal mengimpor file: ' . $e->getMessage()]);
        }
    }
    public function destroy($id){
        $divisiShift = DivisiShift::where('uuid',$id);
        if ($divisiShift->delete()) {
            # code...
            return ResponseFormatter::success($divisiShift, 'Berhasil Menghapus Jam Kerja');
        }
        return ResponseFormatter::error([],'Gagal Menghapus Jam Kerja');
    }
}
