<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
class PegawaiController extends Controller
{
    //
     /**
     * Tampilkan halaman utama datatable pegawai.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $unitKerjaIds = $request->input('unit_kerja_id');
            $unitKerjaIdsArray = !empty($unitKerjaIds) ? explode(',', $unitKerjaIds) : [];

            // Query awal untuk mengambil semua pegawai
            $query = Pegawai::with(['mutasi.unitKerja', 'mutasiAktif.unitKerja']);

            // Filter berdasarkan unit kerja jika ada parameter `unit_kerja_id`
       // Filter berdasarkan unit kerja jika ada parameter `unit_kerja_id`
       if (!empty($unitKerjaIdsArray)) {
        $query->whereHas('mutasi', function ($q) use ($unitKerjaIdsArray) {
            $q->whereIn('unit_kerja_id', $unitKerjaIdsArray)
              ->where('status', '1'); // Hanya ambil mutasi aktif
        });
    }

            return DataTables::eloquent($query)
                ->addColumn('nik', function (Pegawai $pegawai) {
                    return $pegawai->nik;
                })
                ->addColumn('nama', function (Pegawai $pegawai) {
                    return $pegawai->nama;
                })
                ->addColumn('alamat', function (Pegawai $pegawai) {
                    return $pegawai->alamat ?? '-';
                })
                ->addColumn('profesi', function (Pegawai $pegawai) {
                    return $pegawai->profesi?->nama ?? '-'; // Asumsi ada relasi ke model Profesi
                })
                ->addColumn('unit_kerja', function (Pegawai $pegawai) {
                    // Ambil nama unit kerja aktif dari relasi currentUnitKerja
                    return $pegawai->mutasiAktif?->unitKerja?->nama ?? '-';
                })
                ->addColumn('action', function (Pegawai $pegawai) {
                    // Tombol aksi (edit, delete, dll.)
                    return '
                        <a href="' . route('pegawai.show', $pegawai->id) . '" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>';
                })
                ->filter(function ($query) use ($request) {
                    // Custom filter untuk pencarian global
                    if ($request->has('search') && !empty($request->search['value'])) {
                        $search = $request->search['value'];
                        $query->where(function ($q) use ($search) {
                            $q->where('nik', 'like', '%' . $search . '%')
                              ->orWhere('nama', 'like', '%' . $search . '%')
                              ->orWhere('alamat', 'like', '%' . $search . '%');
                        });
                    }
                })
                ->rawColumns(['action']) // Kolom yang mengandung HTML harus di-escape secara manual
                ->toJson();
        }

        // Ambil semua unit kerja untuk dropdown filter
        $unitKerjas = \App\Models\UnitKerja::all();
        $title = 'Pegawai';
        $slug = 'pegawai';

        return view('pages.pegawai.index', compact('slug', 'title', 'unitKerjas'));
    }


    public function export(Request $request)
    {
        // Ambil nilai parameter `unit_kerja_id` dari request
        $unitKerjaIds = $request->input('unit_kerja_id');
        $unitKerjaIdsArray = !empty($unitKerjaIds) ? explode(',', $unitKerjaIds) : [];
        
        // Query awal untuk mengambil semua pegawai
        $query = Pegawai::with(['mutasi.unitKerja', 'mutasiAktif.unitKerja']);
        
        // Filter berdasarkan unit kerja jika ada parameter `unit_kerja_id`
        if (!empty($unitKerjaIdsArray)) {
            $query->whereHas('mutasi', function ($q) use ($unitKerjaIdsArray) {
                $q->whereIn('unit_kerja_id', $unitKerjaIdsArray)
                  ->where('status', '1'); // Hanya ambil mutasi aktif
            });
        }
        
        // Ambil data pegawai
        $pegawaiList = $query->get();
        
        // Fungsi untuk mengonversi angka romawi ke desimal
        function romanToDecimal($roman) {
            $map = ['I' => 1, 'II' => 2, 'III' => 3, 'IV' => 4, 'V' => 5];
            return $map[$roman] ?? 0;
        }
        
        // Urutkan data berdasarkan:
        // 1. Nama dasar unit kerja (misalnya "ANGGREK")
        // 2. Nomor romawi di akhir nama unit kerja (misalnya "I", "II")
        // 3. Nama pegawai secara ascending
        $pegawaiList = $pegawaiList->sortBy(function ($pegawai) {
            // Ambil nama unit kerja dari relasi mutasiAktif.unitKerja
            $unitKerjaNama = $pegawai->mutasiAktif?->unitKerja?->nama ?? '';
            
            // Pisahkan nama dasar dan nomor romawi menggunakan regex
            if (preg_match('/([A-Z ]+)([IVX]+)/', $unitKerjaNama, $matches)) {
                $baseName = $matches[1]; // Nama dasar (misalnya "ANGGREK")
                $romanNumeral = $matches[2]; // Angka romawi (misalnya "I", "II")
                $romanValue = romanToDecimal($romanNumeral); // Konversi ke desimal
            } else {
                $baseName = $unitKerjaNama; // Default jika tidak cocok
                $romanValue = 0; // Default jika tidak ada nomor romawi
            }
        
            // Kembalikan array dengan urutan prioritas:
            // 1. Nama dasar unit kerja
            // 2. Nilai desimal nomor romawi
            // 3. Nama pegawai
            return [
                $baseName,
                $romanValue,
                $pegawai->nama // Tambahkan nama pegawai sebagai kriteria urutan ketiga
            ];
        })->values(); // Reset indeks array
        
        // Sekarang $pegawaiList sudah diurutkan berdasarkan:
        // 1. Nama unit kerja (dengan nomor romawi)
        // 2. Nama pegawai
        
        // Sekarang $pegawaiList sudah diurutkan berdasarkan nama unit kerja dan nomor romawi
    
        // Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Judul kolom
        $sheet->setCellValue('A1', 'NIK');
        $sheet->setCellValue('B1', 'NAMA');
        $sheet->setCellValue('C1', 'NOMOR HP');
        $sheet->setCellValue('D1', 'UNIT KERJA'); // Kolom baru: Unit Kerja
    
        // Styling header
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']], // Warna kuning
        ];
        $sheet->getStyle('A1:D1')->applyFromArray($headerStyle); // Perbarui range header
    
        // Isi data pegawai
        $row = 2; // Mulai dari baris kedua
        foreach ($pegawaiList as $pegawai) {
            // Set NIK sebagai string dengan tanda kutip (') agar tidak diformat sebagai angka
            $sheet->setCellValueExplicit('A' . $row, $pegawai->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('B' . $row, $pegawai->nama);
            $sheet->setCellValue('C' . $row, $pegawai->nohp ?? '-'); // Jika nomor HP kosong, isi dengan '-'
    
            // Tambahkan nama unit kerja aktif
            $unitKerjaNama = $pegawai->mutasiAktif?->unitKerja?->nama ?? '-';
            $sheet->setCellValue('D' . $row, $unitKerjaNama);
    
            // Styling untuk data (left alignment dan border)
            $dataStyle = [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT], // Align ke kiri
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            ];
            $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($dataStyle); // Perbarui range styling
    
            $row++;
        }
    
        // Auto width kolom
        foreach (range('A', 'D') as $column) { // Perbarui range auto width
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    
        // Simpan file Excel ke output stream
        $writer = new Xlsx($spreadsheet);
        $fileName = "Data_Pegawai_" . now()->format('Y-m-d_H-i-s') . ".xlsx";
    
        // Set header untuk download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
    
        // Output file ke browser
        $writer->save('php://output');
    }




}
