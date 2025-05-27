<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\IndeksStruktural;
use App\Models\IndeksJasaTidakLangsung;
use App\Models\IndeksJasaLangsungNonMedis;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ResponseFormatter;

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
    public function index()
    {
        if (request()->ajax()) {
            $data = Pegawai::with(['jabatanStruktural', 'indeksJTL', 'indeksJLNonMedis']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="#" data-url="' . route('pegawai.show', $row->id) . '" class="btn btn-info btn-sm btn-edit"><i class="ti ti-pencil"></i></a>
                        <a href="#" data-url="' . route('pegawai.destroy', $row->id) . '" class="btn btn-danger btn-sm btn-delete"><i class="ti ti-trash"></i></a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $jabatanStruktural = IndeksStruktural::all();
        $indeksJTL = IndeksJasaTidakLangsung::all();
        $indeksJLNonMedis = IndeksJasaLangsungNonMedis::all();

        return view('pegawai.index', compact('jabatanStruktural', 'indeksJTL', 'indeksJLNonMedis'));
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:18|unique:pegawai',
            'id_jabatan_struktural' => 'required|exists:indeks_struktural,id',
            'nilai_indeks_struktural' => 'required|numeric|min:0',
            'id_indeks_jtl' => 'required|exists:indeks_jasa_tidak_langsung,id',
            'nilai_indeks_jtl' => 'required|numeric|min:0',
            'id_indeks_jl_non_medis' => 'required|exists:indeks_jasa_langsung_non_medis,id',
            'nilai_indeks_jl_non_medis' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            Pegawai::create($request->all());
            return ResponseFormatter::success(null, 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal disimpan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = Pegawai::with(['jabatanStruktural', 'indeksJTL', 'indeksJLNonMedis'])->findOrFail($id);
            return ResponseFormatter::success($data, 'Data berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:18|unique:pegawai,nip,' . $id,
            'id_jabatan_struktural' => 'required|exists:indeks_struktural,id',
            'nilai_indeks_struktural' => 'required|numeric|min:0',
            'id_indeks_jtl' => 'required|exists:indeks_jasa_tidak_langsung,id',
            'nilai_indeks_jtl' => 'required|numeric|min:0',
            'id_indeks_jl_non_medis' => 'required|exists:indeks_jasa_langsung_non_medis,id',
            'nilai_indeks_jl_non_medis' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal', 422);
        }

        try {
            $pegawai = Pegawai::findOrFail($id);
            $pegawai->update($request->all());
            return ResponseFormatter::success(null, 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal diupdate: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);
            $pegawai->delete();
            return ResponseFormatter::success(null, 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Data gagal dihapus: ' . $e->getMessage());
        }
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
