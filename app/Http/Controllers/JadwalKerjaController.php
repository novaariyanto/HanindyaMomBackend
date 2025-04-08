<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Divisi;
use App\Models\JamKerja;
use App\Models\PegawaiMaster;
use App\Models\PegawaiShift;
use App\Models\Shift;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Log;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Validator;

class JadwalKerjaController extends Controller
{
    //
    public function index(Request $request)
{   
    // exit;
    if ($request->ajax()) {
        // Ambil parameter dari request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
            @$divisiId = Auth::user()->pegawai->divisi_id;

        if (empty($divisiId)) {
            # code...
        $divisiId = $request->input('divisi_id');

        }

        // Tentukan bulan dan tahun default jika tidak ada input
        $bulan = $bulan ?? now()->month;
        $tahun = $tahun ?? now()->year;

        // Query data pegawai dan urutkan berdasarkan nama
        $query = PegawaiMaster::with(['pegawaiShifts' => function ($q) use ($bulan, $tahun) {
            if ($bulan && $tahun) {
                $q->whereMonth('tanggal', $bulan)
                  ->whereYear('tanggal', $tahun);
            } elseif ($bulan) {
                $q->whereMonth('tanggal', $bulan);
            } elseif ($tahun) {
                $q->whereYear('tanggal', $tahun);
            }
        }])->orderBy('nama', 'asc'); // Urutkan berdasarkan nama secara ascending

        if ($divisiId) {
            $query->where('divisi_id', $divisiId);
        }

        $pegawaiList = $query->get();

        // Ambil semua shift yang terkait dengan divisi
        $shiftsInDivisi = [];
        if ($divisiId) {
            $shiftsInDivisi = DB::table('divisi_shifts')
                ->join('shifts', 'divisi_shifts.shift_id', '=', 'shifts.id')
                ->where('divisi_shifts.divisi_id', $divisiId)
                ->pluck('shifts.nama_shift', 'shifts.kode_shift') // Mengambil kode_shift sebagai nilai
                ->toArray();
        }

        // Proses data untuk menghasilkan format yang diinginkan
        $result = $pegawaiList->map(function ($pegawai) use ($bulan, $tahun) {
            $jadwalPerTanggal = [];

            // Loop melalui shift pegawai
            foreach ($pegawai->pegawaiShifts as $shift) {
                $tanggal = !empty($shift->tanggal) ? (int) Carbon::parse($shift->tanggal)->format('d') : '-';
                $jadwalPerTanggal[$tanggal] = $shift->shift->kode_shift ?? '-'; // Nama shift atau default
            }

            // Hitung jumlah hari dalam bulan yang dipilih
            $jumlahHari = Carbon::createFromDate($tahun, $bulan)->daysInMonth;

            // Tambahkan tanggal kosong untuk tanggal yang tidak ada shift
            for ($i = 1; $i <= $jumlahHari; $i++) {
                if (!isset($jadwalPerTanggal[$i])) {
                    $jadwalPerTanggal[$i] = '-';
                }
            }

            // Urutkan jadwal berdasarkan tanggal
            ksort($jadwalPerTanggal);

            return [
                'id' => $pegawai->id,
                'nama_pegawai' => $pegawai->nama,
                'jadwal' => $jadwalPerTanggal,
            ];
        });

        // Sertakan informasi shift yang ada di divisi
        $response = [
            'pegawai' => $result,
            'shifts_in_divisi' => $shiftsInDivisi, // Informasi shift di divisi
        ];

        return response()->json($response);
    }

    return view('pages.jadwal_kerja.index');
}


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal' => 'required|string',
            'pegawai_id' => 'required|string',
            'shift' => 'nullable|exists:shifts,id', // Pastikan shift valid
        ]);
    
        // Pisahkan tanggal dan pegawai menjadi array
        $tanggalArray = explode(',', $request->tanggal);
        $pegawaiArray = explode(',', $request->pegawai_id);
    
        if ($request->type == "delete") {
            // Proses Hapus
            PegawaiShift::whereIn('pegawai_id', $pegawaiArray)
                ->whereIn('tanggal', $tanggalArray)
                ->delete();
    
            return ResponseFormatter::success([], 'Berhasil Menghapus Jadwal Kerja');
        }
    
        // Ambil ID shift dari request
        $shiftId = $request->shift;
    
        // Ambil data jam kerja untuk shift yang dipilih
        $jamKerja = JamKerja::where('shift_id', $shiftId)->first();
    
        if (!$jamKerja) {
            return ResponseFormatter::error([], 'Jam kerja untuk shift ini tidak ditemukan', 404);
        }
    
        // Mapping nama hari dalam bahasa Indonesia
        $hariMapping = [
            1 => 'senin',
            2 => 'selasa',
            3 => 'rabu',
            4 => 'kamis',
            5 => 'jumat',
            6 => 'sabtu',
            7 => 'minggu',
        ];
    
        // Proses Simpan (Update atau Create)
        foreach ($tanggalArray as $tanggal) {
            // Dapatkan nomor hari berdasarkan tanggal
            $currentDate = Carbon::parse($tanggal);
            $nomorHari = $currentDate->dayOfWeek; // 1 = Senin, 7 = Minggu
            $hari = @$hariMapping[$nomorHari]; // Contoh: "senin", "selasa"
    

            // Periksa apakah jam masuk dan jam pulang untuk hari ini ada
            $hariMasuk =   @$jamKerja->{$hari . '_masuk'};
            $hariPulang = $jamKerja->{$hari . '_pulang'};
    
            if (empty($hariMasuk) || empty($hariPulang)) {
                // Lewati jika jam masuk atau jam pulang kosong
                continue;
            }
    
            foreach ($pegawaiArray as $pegawaiId) {
                // UpdateOrCreate data di tabel pegawai_shift
                PegawaiShift::updateOrCreate(
                    [
                        'pegawai_id' => $pegawaiId,
                        'tanggal' => $tanggal,
                    ],
                    [
                        'shift_id' => $shiftId,
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                    ]
                );
            }
        }
    
        return ResponseFormatter::success([], 'Berhasil Menyimpan Jadwal Kerja');
    }

    public function create(Request $request){
        return view('pages.jadwal_kerja.create');
    }
    
    public function set(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'divisi' => 'required|exists:divisis,id',
            'semua_pegawai' => 'required|in:ya,tidak',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'shift' => 'required|exists:shifts,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Ambil data dari request
        $divisiId = $request->divisi;
        $semuaPegawai = $request->semua_pegawai;
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;
        $shiftId = $request->shift;
    
        // Tentukan daftar pegawai yang akan diproses
        if ($semuaPegawai === 'ya') {
            // Ambil semua pegawai yang termasuk dalam divisi
            $pegawaiList = PegawaiMaster::where('divisi_id', $divisiId)->pluck('id');
        } else {
            // Jika tidak, gunakan pegawai yang dipilih (jika ada)
            $pegawaiList = $request->pegawai_ids ?? [];
        }
    
        // Ambil data jam kerja untuk shift yang dipilih
        $jamKerja = JamKerja::where('shift_id', $shiftId)->first();
    
        if (!$jamKerja) {
            return response()->json(['message' => 'Jam kerja untuk shift ini tidak ditemukan'], 404);
        }
    
        // Mapping nama hari dalam bahasa Indonesia
        $hariMapping = [
            1 => 'senin',
            2 => 'selasa',
            3 => 'rabu',
            4 => 'kamis',
            5 => 'jumat',
            6 => 'sabtu',
            7 => 'minggu',
        ];
    
        // Loop melalui setiap tanggal dalam rentang
        $currentDate = Carbon::parse($tanggalAwal);
        $endDate = Carbon::parse($tanggalAkhir);
    
        while ($currentDate->lte($endDate)) {
            // Dapatkan nama hari berdasarkan nomor hari (1-7)
            $nomorHari = $currentDate->dayOfWeek; // 1 = Senin, 7 = Minggu

            $hari = @$hariMapping[$nomorHari]; // Contoh: "senin", "selasa"
            
            if ($hari) {
                # code...
            // Periksa apakah jam masuk dan jam pulang untuk hari ini ada
            $hariMasuk = $jamKerja->{$hari . '_masuk'};
            $hariPulang = $jamKerja->{$hari . '_pulang'};
    
            if (empty($hariMasuk) || empty($hariPulang)) {
                // Lewati jika jam masuk atau jam pulang kosong
                $currentDate->addDay();
                continue;
            }
    
            // return $pegawaiList;
            foreach ($pegawaiList as $pegawaiId) {
                // Cek apakah sudah ada data untuk pegawai ini pada tanggal tertentu
                $existingRecord = PegawaiShift::where('pegawai_id', $pegawaiId)
                    ->where('tanggal', $currentDate->format('Y-m-d'))
                    ->first();
    
                if ($existingRecord) {
                    // Update data jika sudah ada
                    $existingRecord->update([
                        'shift_id' => $shiftId,
                        'updated_by' => auth()->id(),
                    ]);
                } else {
                    // Buat data baru jika belum ada
                    PegawaiShift::create([
                        'pegawai_id' => $pegawaiId,
                        'shift_id' => $shiftId,
                        'tanggal' => $currentDate->format('Y-m-d'),
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                    ]);
                }
            }
        }

    
            // Pindah ke tanggal berikutnya
            $currentDate->addDay();
        }
    
        // Berikan respons sukses
        return response()->json(['message' => 'Data berhasil disimpan'], 200);
    }

   
    
    public function exportExcel(Request $request)
    {
        // Ambil parameter dari request
        $bulan = $request->input('bulan') ?? now()->month;
        $tahun = $request->input('tahun') ?? now()->year;
        $divisiId = $request->input('divisi_id');

        // Query data pegawai
        $query = PegawaiMaster::with(['pegawaiShifts' => function ($q) use ($bulan, $tahun) {
            if ($bulan && $tahun) {
                $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            } elseif ($bulan) {
                $q->whereMonth('tanggal', $bulan);
            } elseif ($tahun) {
                $q->whereYear('tanggal', $tahun);
            }
        }]);

        if ($divisiId) {
            $query->where('divisi_id', $divisiId);
        }

        $pegawaiList = $query->get();

        // Hitung jumlah hari dalam bulan yang dipilih
        $jumlahHari = Carbon::createFromDate($tahun, $bulan)->daysInMonth;

        // Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Jadwal Absensi'); // Nama sheet utama

        // Judul utama: Merge cell sepanjang NIK, Nama, dan semua tanggal
        $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($jumlahHari + 2); // Kolom terakhir
        $sheet->mergeCells("A1:{$lastColumn}2"); // Merge sel dari A1 sampai kolom terakhir baris ke-2
        $sheet->setCellValue('A1', "Jadwal Absensi Bulan " . Carbon::createFromDate($tahun, $bulan)->translatedFormat('F') . " Tahun {$tahun}");

        // Styling untuk judul utama
        $styleJudul = [
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle("A1:{$lastColumn}2")->applyFromArray($styleJudul);

        // Jika ada divisi, tambahkan nama divisi di bawah judul utama
        if ($divisiId) {
            $divisi = Divisi::find($divisiId); // Ambil data divisi berdasarkan ID
            if ($divisi) {
                $sheet->mergeCells("A3:{$lastColumn}3"); // Merge cell untuk nama divisi
                $sheet->setCellValue('A3', "Divisi: {$divisi->nama}");
                $sheet->getStyle("A3:{$lastColumn}3")->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER], // Align text center
                ]);
            }
        }

        // Merge kolom NIK dan Nama
        $sheet->mergeCells('A4:A5'); // Merge NIK
        $sheet->mergeCells('B4:B5'); // Merge Nama

        // Set header kolom NIK dan Nama
        $sheet->setCellValue('A4', 'NIK');
        $sheet->setCellValue('B4', 'Nama');

        // Styling untuk judul kolom
        $styleHeader = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT], // Ubah alignment menjadi left-aligned
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']], // Warna kuning
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]], // Border untuk header
        ];

        // Apply style ke NIK dan Nama
        $sheet->getStyle('A4:B5')->applyFromArray($styleHeader);

        // Set header tanggal dan hari
        for ($i = 1; $i <= $jumlahHari; $i++) {
            $hariLengkap = Carbon::createFromDate($tahun, $bulan, $i)->translatedFormat('l'); // Nama hari lengkap (e.g., Senin)
            $hariSingkatan = match ($hariLengkap) {
                'Senin' => 'SN',
                'Selasa' => 'SL',
                'Rabu' => 'RB',
                'Kamis' => 'KM',
                'Jumat' => 'JM',
                'Sabtu' => 'SB',
                'Minggu' => 'MG',
            };

            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 2); // Kolom untuk tanggal dan hari
            $sheet->setCellValue($col . '4', str_pad($i, 2, '0', STR_PAD_LEFT)); // Tanggal (01, 02, ...)
            $sheet->setCellValue($col . '5', $hariSingkatan); // Hari (SN, SL, etc.)

            // Apply style ke tanggal dan hari
            $sheet->getStyle($col . '4:' . $col . '5')->applyFromArray($styleHeader);

            // Jika hari Minggu, tambahkan background merah
            if ($hariLengkap === 'Sunday') {
                $styleMinggu = [
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8D7DA']], // Background merah muda
                    'font' => ['color' => ['rgb' => '721C24']], // Warna teks merah gelap
                ];
                $sheet->getStyle($col . '4:' . $col . '5')->applyFromArray($styleMinggu);
            }
        }

        // Isi data pegawai
        $row = 6; // Mulai dari baris keenam
        foreach ($pegawaiList as $pegawai) {
            $sheet->setCellValueExplicit('A' . $row, $pegawai->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING); // NIK sebagai string
            $sheet->setCellValue('B' . $row, $pegawai->nama); // Nama

            // Styling untuk NIK dan Nama (border dan left-aligned)
            $sheet->getStyle("A{$row}:B{$row}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT], // Ubah alignment menjadi left-aligned
            ]);

            // Loop melalui shift pegawai
            $jadwalPerTanggal = [];
            foreach ($pegawai->pegawaiShifts as $shift) {
                $tanggal = !empty($shift->tanggal) ? (int) Carbon::parse($shift->tanggal)->format('d') : '-';
                $jadwalPerTanggal[$tanggal] = $shift->shift->kode_shift ?? '-'; // Kode shift atau default
            }

            // Tambahkan tanggal kosong untuk tanggal yang tidak ada shift
            for ($i = 1; $i <= $jumlahHari; $i++) {
                $jadwalPerTanggal[$i] = $jadwalPerTanggal[$i] ?? '-';
            }

            // Isi kode shift ke kolom tanggal
            $col = 3; // Kolom pertama tanggal
            foreach ($jadwalPerTanggal as $tanggal => $shift) {
                $currentCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++);
                $sheet->setCellValue($currentCol . $row, $shift);

                // Styling untuk kode shift (border, center, dan warna untuk Minggu)
                $sheet->getStyle($currentCol . $row)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Jika hari Minggu, tambahkan background merah pada isi tabel
                $tanggalObj = Carbon::createFromDate($tahun, $bulan, $tanggal);
                if ($tanggalObj->translatedFormat('l') === 'Sunday') {
                    $styleMingguData = [
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8D7DA']], // Background merah muda
                        'font' => ['color' => ['rgb' => '721C24']], // Warna teks merah gelap
                    ];
                    $sheet->getStyle($currentCol . $row)->applyFromArray($styleMingguData);
                }
            }

            $row++; // Pindah ke baris berikutnya
        }

        // Auto width kolom
        foreach (range('A', \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($jumlahHari + 2)) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Sheet Shift
        $sheetShift = $spreadsheet->createSheet(); // Membuat sheet baru
        $sheetShift->setTitle('Shift'); // Nama sheet

        // Ambil semua shift beserta jam kerjanya
        $shifts = Shift::with('jamKerja')->get();

        // Mapping nama hari ke angka
        $hariMapping = [
            'Senin' => ['masuk' => 'senin_masuk', 'pulang' => 'senin_pulang'],
            'Selasa' => ['masuk' => 'selasa_masuk', 'pulang' => 'selasa_pulang'],
            'Rabu' => ['masuk' => 'rabu_masuk', 'pulang' => 'rabu_pulang'],
            'Kamis' => ['masuk' => 'kamis_masuk', 'pulang' => 'kamis_pulang'],
            'Jumat' => ['masuk' => 'jumat_masuk', 'pulang' => 'jumat_pulang'],
            'Sabtu' => ['masuk' => 'sabtu_masuk', 'pulang' => 'sabtu_pulang'],
            'Minggu' => ['masuk' => 'minggu_masuk', 'pulang' => 'minggu_pulang'],
        ];

        // Set header kolom utama
        $sheetShift->setCellValue('A1', 'Kode');
        $sheetShift->setCellValue('B1', 'Nama Shift');

        // Merge cells untuk judul "Kode" dan "Nama Shift" hanya 2 baris
        $sheetShift->mergeCells("A1:A2"); // Merge Kode
        $sheetShift->mergeCells("B1:B2"); // Merge Nama Shift

        // Center alignment untuk judul "Kode" dan "Nama Shift"
        $sheetShift->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheetShift->getStyle('B1:B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Merge cells untuk nama hari
        $col = 'C'; // Mulai dari kolom C
        foreach ($hariMapping as $hariLabel => $hariData) {
            $sheetShift->mergeCells($col . '1:' . chr(ord($col) + 1) . '1'); // Gabungkan 2 kolom
            $sheetShift->setCellValue($col . '1', $hariLabel); // Nama hari
            $sheetShift->setCellValue($col . '2', 'Jam Mulai'); // Sub-header Jam Mulai
            $sheetShift->setCellValue(chr(ord($col) + 1) . '2', 'Jam Selesai'); // Sub-header Jam Selesai

            // Center alignment untuk nama hari dan sub-header
            $sheetShift->getStyle($col . '1:' . chr(ord($col) + 1) . '2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $col = chr(ord($col) + 2); // Pindah ke kolom berikutnya
        }

        // Styling: Border Hitam untuk Semua Sel
        $lastColumn = $sheetShift->getHighestDataColumn();
        $lastRow = $sheetShift->getHighestDataRow();
        $sheetShift->getStyle("A1:$lastColumn$lastRow")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Warna hitam
                ],
            ],
        ]);

        // Styling: Background Hijau untuk Header
        $headerRange = "A1:$lastColumn" . '2'; // Range header (baris pertama dan kedua)
        $sheetShift->getStyle($headerRange)->applyFromArray([
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
            $sheetShift->setCellValue('A' . $row, $shift->kode_shift); // Kode
            $sheetShift->setCellValue('B' . $row, $shift->nama_shift); // Nama Shift

            // Isi jam kerja untuk setiap hari
            $col = 'C'; // Mulai dari kolom C
            foreach ($hariMapping as $hariLabel => $hariData) {
                $jamMasuk = $shift->jamKerja->first()->{$hariData['masuk']} ?? null;
                $jamPulang = $shift->jamKerja->first()->{$hariData['pulang']} ?? null;

                if ($jamMasuk && $jamPulang) {
                    // Format waktu ke H:i
                    $sheetShift->setCellValue($col . $row, \Carbon\Carbon::createFromFormat('H:i:s', $jamMasuk)->format('H:i')); // Jam Mulai
                    $sheetShift->setCellValue(chr(ord($col) + 1) . $row, \Carbon\Carbon::createFromFormat('H:i:s', $jamPulang)->format('H:i')); // Jam Selesai
                } else {
                    $sheetShift->setCellValue($col . $row, '-'); // Kosong jika tidak ada data
                    $sheetShift->setCellValue(chr(ord($col) + 1) . $row, '-'); // Kosong jika tidak ada data
                }

                $col = chr(ord($col) + 2); // Pindah ke kolom berikutnya
            }

            $row++;
        }

        // Auto width untuk semua kolom
        foreach (range('A', $sheetShift->getHighestDataColumn()) as $column) {
            $sheetShift->getColumnDimension($column)->setAutoSize(true);
        }

        // Tambahkan Dropdown untuk Kode Shift di Sheet Jadwal Absensi
        $dataValidation = new DataValidation();
        $dataValidation->setType(DataValidation::TYPE_LIST);
        $dataValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $dataValidation->setAllowBlank(true); // Izinkan sel kosong
        $dataValidation->setShowInputMessage(true);
        $dataValidation->setShowErrorMessage(true);
        $dataValidation->setShowDropDown(true);

        // Ambil semua kode shift dari database
        $kodeShiftList = Shift::pluck('kode_shift')->toArray();

        // Tambahkan "-" ke daftar kode shift
        array_unshift($kodeShiftList, "-");

        // Gabungkan kode shift menjadi string yang dipisahkan koma
        $kodeShiftString = implode(",", $kodeShiftList);

        // Set formula1 untuk dropdown
        $dataValidation->setFormula1('"' . $kodeShiftString . '"');

        // Terapkan dropdown ke kolom tanggal di sheet Jadwal Absensi
        $rowAbsensi = 6; // Baris pertama data pegawai
        foreach ($pegawaiList as $pegawai) {
            $col = 3; // Kolom pertama tanggal
            for ($i = 1; $i <= $jumlahHari; $i++) {
                $currentCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col++);
                $sheet->getCell($currentCol . $rowAbsensi)->setDataValidation(clone $dataValidation);
            }
            $rowAbsensi++;
        }

        // Simpan file Excel ke output stream
        $writer = new Xlsx($spreadsheet);
        $fileName = "Jadwal_Absensi_Bulan_" . Carbon::createFromDate($tahun, $bulan)->translatedFormat('F') . "_Tahun_{$tahun}.xlsx";

        // Set header untuk download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Output file ke browser
        $writer->save('php://output');
    }
    


    public function import(Request $request){

        
        return view('pages.jadwal_kerja.import');

    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
    
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();

        // Ambil jumlah baris yang berisi data
        $highestRow = $sheet->getHighestRow();

        // Ambil kolom terakhir
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
    
        // Ambil bulan dan tahun dari judul jika ada
        $judul = $sheet->getCell('A1')->getValue();
        preg_match('/Bulan (.*?) Tahun (\d+)/', $judul, $matches);
        $bulan = isset($matches[1]) ? Carbon::parse($matches[1])->month : now()->month;
        $tahun = isset($matches[2]) ? (int)$matches[2] : now()->year;
    
        
      
        // Loop data pegawai mulai dari baris ke-6 (karena header di baris 4-5)
        for ($row = 6; $row <= $highestRow; $row++) {
            $nik = $sheet->getCell("A{$row}")->getValue();
            $nama = $sheet->getCell("B{$row}")->getValue();
    // echo "A{$row}";
            // echo $nama;
            
            if (!$nik || !$nama) continue; // Lewati jika data kosong
    
            // echo $nik;
            // Cek apakah pegawai sudah ada
            // $pegawai = PegawaiMaster::firstOrCreate([
            //     'nik' => $nik
            // ], [
            //     'nama' => $nama,
            // ]);
            
            $pegawai = PegawaiMaster::where(['nik' => $nik])->first();

            // echo $pegawai;
            if ($pegawai) {
                # code...
                // echo $pegawai;
    
            // Loop melalui tanggal pada kolom berikutnya
            for ($col = 3; $col <= $highestColumnIndex; $col++) {
                $tanggal = Carbon::createFromDate($tahun, $bulan, $col - 2)->format('Y-m-d');
                $shiftKode = $sheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $row)->getValue();
                if ($shiftKode!="-" || !empty($shiftKode)) {
                    # code...
                
                $shift = Shift::where('kode_shift',$shiftKode)->first();

                // echo $shift;
                if ($shift) {
                    # code...

                    // echo $pegawai->id;
                PegawaiShift::updateOrCreate(
                    [
                        'pegawai_id' => $pegawai->id,
                        'tanggal' => $tanggal,
                    ],
                    [
                        'shift_id' => $shift->id,
                        'created_by'=>Auth::user()->id,
                        'updated_by'=>Auth::user()->id,
                    ]
                );
            }

            }

            }
        }


        }
    
        return ResponseFormatter::success([], 'Berhasil Update Jadwal Kerja');

        // return redirect()->back()->with('success', 'Data berhasil diimport!');
    }

    
}
