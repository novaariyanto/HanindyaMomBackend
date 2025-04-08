<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Divisi;
use App\Models\JamKerja;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Log;
use Yajra\DataTables\Facades\DataTables;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
    if ($request->ajax()) {
        // Query awal untuk mengambil semua shift
        $query = Shift::with('divisis'); // Load relasi divisies

        // Filter berdasarkan divisi_id jika ada
        if ($request->has('divisi_id') && !empty($request->divisi_id)) {
            $query->whereHas('divisis', function ($q) use ($request) {
                $q->where('divisis.id', $request->divisi_id); // Spesifikkan tabel divisis.id
            });
        }

        return DataTables::eloquent($query)
            ->addColumn('divisi', function (Shift $shift) {
                // Mengambil nama divisi yang terkait dengan shift
                return $shift->divisis->map(function ($divisi) {
                    return $divisi->nama;
                })->implode(', '); // Gabungkan nama divisi dengan koma jika ada lebih dari satu
            })
            ->addColumn('status_raw', function (Shift $shift) {
                // Menampilkan teks: "Aktif" atau "Nonaktif"
                return $shift->status === '1' 
                    ? '<span class="badge bg-success">Aktif</span>' 
                    : '<span class="badge bg-danger">Nonaktif</span>';
            })
            ->addColumn('action', function (Shift $shift) {
                // Tombol aksi (edit, delete, dll.)
                return '
                    <a data-modal="large" data-url="' . route('shift.show', $shift->uuid) . '" class="btn btn-info btn-sm btn-create"><i class="ti ti-clock"></i></a>
                    <a href="#" data-url="' . route('shift.edit', $shift->uuid) . '" class="btn btn-warning btn-sm btn-create"><i class="ti ti-pencil"></i></a>
                    <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('shift.destroy', $shift->uuid) . '"><i class="ti ti-trash"></i></button>';
            })
            ->rawColumns(['status_raw', 'action']) // Kolom yang mengandung HTML harus di-escape secara manual
            ->toJson();
    }

    // Ambil semua divisi untuk dropdown filter
    $divisis = Divisi::all();

    $title = 'Shift';
    $slug = 'shift';
    return view('pages.shift.index', compact('slug', 'title', 'divisis'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('pages.shift.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_shift' => 'required|string|max:191', // Nama shift wajib diisi
            'kode_shift' => 'nullable|string|max:50|unique:shifts,kode_shift', // Kode shift opsional, harus unik
            'toleransi_terlambat' => 'nullable|integer|min:0', // Toleransi terlambat dalam menit, minimal 0
            'status' => 'required|in:1,2', // Status wajib diisi, hanya boleh "aktif" atau "nonaktif"
            'keterangan' => 'nullable|string', // Keterangan opsional
            'divisi' => 'nullable|exists:divisis,id', // Pastikan divisi ada di tabel divisis
            'waktu_mulai_masuk'=>'nullable',
            'waktu_akhir_masuk'=>'nullable',
            'waktu_mulai_keluar'=>'nullable',
            'waktu_akhir_keluar'=>'nullable'
        ]);
    

        // <div class="input-group mb-3">
        //         <input type="text" class="form-control" placeholder="Waktu Awal dalam menit" name="waktu_mulai_masuk">
        //         <span class="input-group-text">-</span>
        //         <input type="text" class="form-control" placeholder="Waktu Akhir dalam menit" name="waktu_akhir_masuk">
        //       </div>




        // </div>
        // <!-- Mulai Absen Keluar & Akhir Keluar Absen -->
        // <div class="mb-3">
        //     <label class="form-label">Waktu Absen Keluar</label>

        //     <div class="input-group mb-3">
        //         <input type="text" class="form-control" placeholder="Waktu Awal dalam menit" name="waktu_mulai_keluar">
        //         <span class="input-group-text">-</span>
        //         <input type="text" class="form-control" placeholder="Waktu Akhir dalam menit" name="waktu_akhir_keluar">
        //       </div>




        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Shift: ' . $validator->errors()->first(), 422);
        }
    
        // Buat instance baru untuk shift
        $shift = new Shift();
        $shift->nama_shift = $request->nama_shift;
    
        // Generate kode shift jika tidak diisi
        if (empty($request->kode_shift)) {
            $shift->kode_shift = $this->generateUniqueKodeShift($request->nama_shift);
        } else {
            $shift->kode_shift = $request->kode_shift;
        }
    
        // Set toleransi terlambat (default 0 jika tidak diisi)
        $shift->toleransi_terlambat = $request->filled('toleransi_terlambat') ? $request->toleransi_terlambat : 0;
    
        // Set status
        $shift->status = $request->status;
    
        // Set keterangan
        $shift->keterangan = $request->keterangan;

        $shift->waktu_mulai_masuk = $request->waktu_mulai_masuk;
        $shift->waktu_akhir_masuk = $request->waktu_akhir_masuk;
        $shift->waktu_mulai_keluar = $request->waktu_mulai_keluar;
        $shift->waktu_akhir_keluar = $request->waktu_akhir_keluar;
    
        // Simpan data ke database
        if (!$shift->save()) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Shift', 500);
        }
    
        // Simpan relasi divisi (jika ada)
        if ($request->filled('divisi')) {
            $shift->divisis()->attach($request->divisi); // Simpan relasi ke tabel pivot
        }
    
        return ResponseFormatter::success($shift, 'Berhasil Menyimpan Shift');
    }
    /**
     * Generate kode shift otomatis berdasarkan nama shift dan pastikan unik.
     *
     * @param string $namaShift
     * @return string
     */
    private function generateUniqueKodeShift($namaShift)
    {
        // Hilangkan spasi dan ubah ke uppercase
        $words = explode(' ', strtoupper($namaShift));
    
        // Ambil huruf pertama dari setiap kata
        $kode = '';
        foreach ($words as $word) {
            $kode .= substr($word, 0, 1);
        }
    
        // Batasi panjang kode menjadi maksimal 3 karakter
        $kode = substr($kode, 0, 3);
    
        // Periksa apakah kode sudah ada di database
        $existingShift = Shift::where('kode_shift', $kode)->first();
        if ($existingShift) {
            // Tambahkan angka acak jika kode sudah ada
            do {
                $randomNumber = rand(1, 99); // Angka acak antara 1 dan 99
                $newKode = $kode . $randomNumber; // Gabungkan kode dengan angka acak
                $existingShift = Shift::where('kode_shift', $newKode)->first();
            } while ($existingShift); // Ulangi sampai ditemukan kode unik
    
            $kode = $newKode; // Gunakan kode baru yang unik
        }
    
        return $kode;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift, Request $request)
    {
        if ($request->ajax()) {
            return view('pages.shift.edit', compact('shift'));
        }
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_shift' => 'required|string|max:191', // Nama shift wajib diisi
            'kode_shift' => [
                'nullable', // Kode shift opsional
                'string',
                'max:50',
                Rule::unique('shifts', 'kode_shift')->ignore($id, 'uuid'), // Pastikan kode shift unik, kecuali untuk shift yang sedang diedit
            ],
            'toleransi_terlambat' => 'nullable|integer|min:0', // Toleransi terlambat dalam menit, minimal 0
            'status' => 'required|in:1,2', // Status wajib diisi, hanya boleh "aktif" atau "nonaktif"
            'keterangan' => 'nullable|string', // Keterangan opsional
        ]);
    
        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Mengubah Shift: ' . $validator->errors()->first(), 422);
        }
    
        // Temukan shift berdasarkan UUID
        $shift = Shift::where('uuid', $id)->first();
    
        if (!$shift) {
            return ResponseFormatter::error(null, 'Shift tidak ditemukan', 404);
        }
    
        // Update nama shift
        $shift->nama_shift = $request->nama_shift;
    
        // Update kode shift jika diisi, jika tidak tetap gunakan nilai lama
        if (!empty($request->kode_shift)) {
            $shift->kode_shift = $request->kode_shift;
        }
    
        // Update toleransi terlambat (default tetap jika tidak diisi)
        $shift->toleransi_terlambat = $request->filled('toleransi_terlambat') ? $request->toleransi_terlambat : $shift->toleransi_terlambat;
    
        // Update status
        $shift->status = $request->status;
    
        // Update keterangan
        $shift->keterangan = $request->keterangan;


        $shift->waktu_mulai_masuk = $request->waktu_mulai_masuk;
        $shift->waktu_akhir_masuk = $request->waktu_akhir_masuk;
        $shift->waktu_mulai_keluar = $request->waktu_mulai_keluar;
        $shift->waktu_akhir_keluar = $request->waktu_akhir_keluar;
    
        // Simpan perubahan ke database
        if (!$shift->save()) {
            return ResponseFormatter::error(null, 'Gagal Mengubah Shift', 500);
        }
    
        return ResponseFormatter::success($shift, 'Berhasil Mengubah Shift');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Temukan shift berdasarkan UUID
        $shift = Shift::where('uuid', $id)->firstOrFail();
        $title = 'Shift ' . $shift->nama;
    
        // Ambil data jam kerja untuk shift ini
        $jamKerja = JamKerja::where('shift_id', $shift->id)->first();
    
        // Mapping nama hari ke kolom database
        $hariMapping = [
            1 => ['masuk' => 'senin_masuk', 'pulang' => 'senin_pulang'],
            2 => ['masuk' => 'selasa_masuk', 'pulang' => 'selasa_pulang'],
            3 => ['masuk' => 'rabu_masuk', 'pulang' => 'rabu_pulang'],
            4 => ['masuk' => 'kamis_masuk', 'pulang' => 'kamis_pulang'],
            5 => ['masuk' => 'jumat_masuk', 'pulang' => 'jumat_pulang'],
            6 => ['masuk' => 'sabtu_masuk', 'pulang' => 'sabtu_pulang'],
            7 => ['masuk' => 'minggu_masuk', 'pulang' => 'minggu_pulang'],
        ];
    
        // Format data jam kerja untuk frontend
        $formattedJamKerja = [];
        foreach ($hariMapping as $hariValue => $kolom) {
            $formattedJamKerja[$hariValue] = [
                'jam_mulai' => $jamKerja->{$kolom['masuk']} ?? null,
                'jam_selesai' => $jamKerja->{$kolom['pulang']} ?? null,
            ];
        }
    
        return view('pages.shift.show', compact('shift', 'title', 'formattedJamKerja'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shift $shift)
    {
        if (!$shift->delete()) {
            return ResponseFormatter::error([], 'Shift gagal dihapus', 500);
        }
        return ResponseFormatter::success([], 'Shift berhasil dihapus');
    }

  
        // Ambil data shift
        public function updateJamKerja(Request $request, $id)
        {
            // Validasi input
            $validated = $request->validate([
                'jam_mulai' => 'nullable|array',
                'jam_mulai.*' => 'nullable',
                'jam_selesai' => 'nullable|array',
                'jam_selesai.*' => 'nullable'
            ]);
        

        $validated = $request->all();

            // Temukan shift berdasarkan UUID
            $shift = Shift::where('uuid', $id)->firstOrFail();
        
            // Mapping hari ke kolom database
            $hariMapping = [
                1 => ['masuk' => 'senin_masuk', 'pulang' => 'senin_pulang'],
                2 => ['masuk' => 'selasa_masuk', 'pulang' => 'selasa_pulang'],
                3 => ['masuk' => 'rabu_masuk', 'pulang' => 'rabu_pulang'],
                4 => ['masuk' => 'kamis_masuk', 'pulang' => 'kamis_pulang'],
                5 => ['masuk' => 'jumat_masuk', 'pulang' => 'jumat_pulang'],
                6 => ['masuk' => 'sabtu_masuk', 'pulang' => 'sabtu_pulang'],
                7 => ['masuk' => 'minggu_masuk', 'pulang' => 'minggu_pulang'],
            ];
        
            // Simpan atau update jam kerja
            foreach ($validated['jam_mulai'] as $hari => $jamMulai) {
                if (!empty($jamMulai) || !empty($validated['jam_selesai'][$hari])) {
                    // Ambil kolom untuk hari tertentu
                    $kolomMasuk = $hariMapping[$hari]['masuk'];
                    $kolomPulang = $hariMapping[$hari]['pulang'];
        
                    // Cari atau buat entri jam_kerja untuk shift ini
                    $jamKerja = JamKerja::updateOrCreate(
                        ['shift_id' => $shift->id], // Kunci unik berdasarkan shift_id
                        [
                            $kolomMasuk => $jamMulai,
                            $kolomPulang => $validated['jam_selesai'][$hari],
                        ]
                    );
                } else {
                    // Jika jam_mulai dan jam_selesai kosong, hapus data jika ada
                    $jamKerja = JamKerja::where('shift_id', $shift->id)->first();
                    if ($jamKerja) {
                        $kolomMasuk = $hariMapping[$hari]['masuk'];
                        $kolomPulang = $hariMapping[$hari]['pulang'];
        
                        // Set nilai kolom menjadi null
                        $jamKerja->$kolomMasuk = null;
                        $jamKerja->$kolomPulang = null;
                        $jamKerja->save();
                    }
                }
            }
        
        return ResponseFormatter::success([], 'Berhasil mengatur jam kerja');

            // Set session flash message untuk notifikasi sukses
            // return redirect()->route('shift.show', $shift->uuid)->with('success', 'Jam kerja berhasil diperbarui.');
        }

        


    // return redirect()->route('shift.show', $shift->uuid)->with('success', 'Jam kerja berhasil diperbarui.');

    
    


    public function export()
    {
        // Ambil data shift beserta jam kerja
        $shifts = Shift::with('jamKerja')->get();
    
        // Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Header Baris 1 (KODE - KETERANGAN)
        $sheet->setCellValue('A1', 'KODE');
        $sheet->setCellValue('B1', 'NAMA SHIFT');
        $sheet->setCellValue('C1', 'TOLERANSI (dlm Menit)');
        $sheet->setCellValue('D1', 'STATUS');
        $sheet->setCellValue('E1', 'KETERANGAN');
    
        // Merge KODE - KETERANGAN (2 Baris)
        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:D2');
        $sheet->mergeCells('E1:E2');
    
        // Header Hari (Merge SENIN - MINGGU)
        $hariMapping = [
            'F' => 'SENIN', 'H' => 'SELASA', 'J' => 'RABU', 
            'L' => 'KAMIS', 'N' => 'JUMAT', 'P' => 'SABTU', 'R' => 'MINGGU'
        ];
    
        foreach ($hariMapping as $col => $hari) {
            $sheet->setCellValue($col . '1', $hari);
            $sheet->mergeCells($col . '1:' . chr(ord($col) + 1) . '1'); // Merge 2 kolom (misal F-G)
            $sheet->setCellValue($col . '2', 'JAM MASUK');
            $sheet->setCellValue(chr(ord($col) + 1) . '2', 'JAM PULANG'); // Kolom sebelahnya untuk jam pulang
        }
    
        // Style Header
        $styleHeader = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '28A745'], // Warna hijau header
            ],
        ];
        $sheet->getStyle('A1:S2')->applyFromArray($styleHeader); // Sesuaikan sampai kolom terakhir
    
        // Isi data mulai baris ke-3
        $row = 3;
        foreach ($shifts as $shift) {
            $jamKerja = $shift->jamKerja->first(); // Ambil satu objek, bukan collection
        
            $sheet->setCellValue('A' . $row, $shift->kode_shift);
            $sheet->setCellValue('B' . $row, $shift->nama_shift);
            $sheet->setCellValue('C' . $row, $shift->toleransi_terlambat ?? 0);
            $sheet->setCellValue('D' . $row, $shift->status == 1 ? 'Aktif' : 'Nonaktif');
            $sheet->setCellValue('E' . $row, $shift->keterangan);
    
            foreach ($hariMapping as $col => $hari) {
                $masukField = strtolower($hari) . '_masuk';
                $pulangField = strtolower($hari) . '_pulang';
    
                $jamMasuk = $jamKerja ? ($jamKerja->$masukField ?? '') : '';
                $jamPulang = $jamKerja ? ($jamKerja->$pulangField ?? '') : '';
    
                // Jika ada jam, format ke H:i
                $jamMasukFormatted = $jamMasuk ? date('H:i', strtotime($jamMasuk)) : '';
                $jamPulangFormatted = $jamPulang ? date('H:i', strtotime($jamPulang)) : '';
    
                $sheet->setCellValue($col . $row, $jamMasukFormatted);
                $sheet->setCellValue(chr(ord($col) + 1) . $row, $jamPulangFormatted);
            }
    
            $row++;
        }
    
        // Set auto width untuk semua kolom
        foreach (range('A', 'S') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    
        // Style Border untuk Data
        $styleData = [
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ];
        $sheet->getStyle('A3:S' . ($row - 1))->applyFromArray($styleData); // Border seluruh data
    
        // Download file
        $writer = new Xlsx($spreadsheet);
        $filename = 'shift_data_' . date('YmdHis') . '.xlsx';
    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
    }
    
    
public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    $file = $request->file('file');
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray(null, true, true, true);

    $errorMessages = []; // Buat nampung error

    for ($i = 3; $i <= count($data); $i++) {
        try {
            if (!isset($data[$i]['A']) || empty($data[$i]['A'])) {
                continue; // Skip kalau kode shift kosong
            }

            // Validasi data
            $validator = Validator::make($data[$i], [
                'A' => 'required|string', // Kode Shift
                'B' => 'required|string', // Nama Shift
                'C' => 'nullable|integer', // Toleransi
                'D' => 'required|in:Aktif,Nonaktif', // Status
            ]);

            if ($validator->fails()) {
                $errorMessages[] = "Baris $i: Data tidak valid";
                continue;
            }

            // Simpan Shift
            $shift = Shift::updateOrCreate(
                ['kode_shift' => $data[$i]['A']],
                [
                    'nama_shift' => $data[$i]['B'],
                    'toleransi_terlambat' => $data[$i]['C'] ?? 0,
                    'status' => ($data[$i]['D'] == 'Aktif') ? 1 : 0,
                    'keterangan' => $data[$i]['E'] ?? '',
                ]
            );

            // Simpan Jam Kerja
            $hariMapping = ['F' => 'senin', 'H' => 'selasa', 'J' => 'rabu', 'L' => 'kamis', 'N' => 'jumat', 'P' => 'sabtu', 'R' => 'minggu'];

            foreach ($hariMapping as $col => $hari) {
                try {
                    $jamMasuk = isset($data[$i][$col]) ? date('H:i', strtotime($data[$i][$col])) : null;
                    $jamPulang = isset($data[$i][chr(ord($col) + 1)]) ? date('H:i', strtotime($data[$i][chr(ord($col) + 1)])) : null;

                    // return $jamMasuk;
                    if ($jamMasuk && $jamPulang) {
                        JamKerja::updateOrCreate(
                            ['shift_id' => $shift->id],
                            [
                                "{$hari}_masuk" => $jamMasuk,
                                "{$hari}_pulang" => $jamPulang,
                            ]
                        );
                        // echo "x";
                    }
                } catch (\Exception $e) {
                    $errorMessages[] = "Baris $i (Hari $hari): Format jam salah";
                    Log::error("Error di baris $i (Hari $hari): " . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            $errorMessages[] = "Baris $i: " . $e->getMessage();
            Log::error("Error di baris $i: " . $e->getMessage());
        }
    }

    print_r($errorMessages);
    if (!empty($errorMessages)) {
        // return $errorMessages;
        // return back()->with('errors', $errorMessages);
    }

    // return back()->with('success', 'Data shift berhasil diimport!');
}

}