<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\PegawaiMaster;
use App\Models\Presensi;
use App\Models\User;
use App\Models\UserPhoto;
use Hash;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Storage;
use Yajra\DataTables\Facades\DataTables;

class PegawaiMasterController extends Controller
{

    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Query dengan eager loading untuk relasi jabatan dan divisi
            $query = PegawaiMaster::with(['jabatan', 'divisi', 'user']);

    
            // Tambahkan filter berdasarkan divisi_id jika parameter ada
            if ($request->has('divisi_id') && !empty($request->divisi_id)) {
                $query->where('divisi_id', $request->divisi_id);
            }
    
            return DataTables::eloquent($query)
                ->addColumn('nama_pegawai', function (PegawaiMaster $pegawai) {
                    return $pegawai->nama; // Kolom nama pegawai
                })
                ->addColumn('nip', function (PegawaiMaster $pegawai) {
                    return $pegawai->nip; // Kolom NIP
                })
                ->addColumn('jabatan', function (PegawaiMaster $pegawai) {
                    return $pegawai->jabatan ? $pegawai->jabatan->nama : '-'; // Nama jabatan
                })
                ->addColumn('divisi', function (PegawaiMaster $pegawai) {
                    return $pegawai->divisi ? $pegawai->divisi->nama : '-'; // Nama divisi
                })
                ->addColumn('status', function (PegawaiMaster $pegawai) {
                    return ucfirst($pegawai->status); // Status (aktif/nonaktif)
                })
                ->addColumn('user', function (PegawaiMaster $pegawai) {
                    return $pegawai->user ? $pegawai->user->username : '-'; // Nama user
                })
                

                ->addColumn('foto_url', function (PegawaiMaster $pegawai) {
                    if($pegawai->user){

                        $fotoPath = @$pegawai->user->photo ? $pegawai->user->photo->path : null;
                    
                        $attr = '<a href="#" class="btn-create" data-url="' . route('pegawai_master.face', ['uuid'=>$pegawai->uuid]) . '" >';
                        if ($fotoPath) {
                            $fotoUrl = url("{$fotoPath}"); // Membuat URL lengkap
                            $attr .= '<center><img src="'.$fotoUrl.'" alt="Foto Profil" class="img-thumbnail" width="50"></center>';
                        } else {
                            $attr .= '-';
                        }
                        $attr.= '</a>';
    
                        return $attr;
                    }
                })
                
                

                

                ->addColumn('action', function (PegawaiMaster $pegawai) {

                    $str = '';

                    return $str.'
                       
                        
                         <a href="#" data-url="' . route('pegawai-master.edit', $pegawai->uuid) . '" class="btn btn-warning btn-sm btn-create"><i class="ti ti-pencil"></i></a>
                        <a href="' . route('pegawai-master.show', $pegawai->uuid) . '" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>

                        <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('pegawai-master.destroy', $pegawai->uuid) . '"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['action','foto_url']) // Untuk mengizinkan HTML di kolom action
                ->toJson();
        }
    
        $title = 'Daftar Pegawai';
        $slug = 'pegawai';
    
        // Ambil semua divisi untuk dropdown filter
        $divisis = Divisi::all();
    
        return view('pages.pegawai_master.index', compact('slug', 'title', 'divisis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $divisi_id = $request->divisi_id;
            $divisi = null;
            $divisi_data = Divisi::where('uuid',$divisi_id);

            if ($divisi_data->count()) {
                # code...
                $divisi = $divisi_data->first();
                
            }
            return view('pages.pegawai_master.create',compact('divisi'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $formType = $request->input('form_type');

    if ($formType === 'manual') {
        // Validasi input untuk form manual
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|unique:pegawai_masters,nik',
            'jabatan_id' => 'required|exists:jabatans,id',
            'divisi_id' => 'required|exists:divisis,id',
            'status' => 'required|in:aktif,nonaktif',
            'nomor_hp' => 'nullable|string|max:15', // Validasi nomor HP opsional
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Data Pegawai: ' . $validator->errors()->first(), 422);
        }

        // Cek apakah pegawai dengan NIK tersebut ada di database
        $pegawai = Pegawai::where('nik', $request->nik);
        if (!$pegawai->count()) {
            return ResponseFormatter::error(null, 'Data Pegawai Tidak Ditemukan', 500);
        }

        $data_pegawai = $pegawai->first();

        // Simpan data pegawai ke tabel PegawaiMaster
      

        // Jika nomor HP tidak kosong, buat user baru dengan username berdasarkan nomor HP
        if (!empty($request->nomor_hp)) {
            $user = new User();
            $user->name = $data_pegawai->nama; // Nama user diambil dari nama pegawai
            $user->username = $request->nomor_hp; // Username diisi dengan nomor HP
            $user->password = bcrypt('default_password'); // Password default (bisa diubah nanti)

            if (!$user->save()) {
                return ResponseFormatter::error(null, 'Gagal Membuat User', 500);
            }
        }

        $pegawaiMaster = new PegawaiMaster();
        $pegawaiMaster->nama = $data_pegawai->nama;
        $pegawaiMaster->nik = $request->nik;
        $pegawaiMaster->jabatan_id = $request->jabatan_id;
        $pegawaiMaster->divisi_id = $request->divisi_id;
        $pegawaiMaster->status = $request->status;
        $pegawaiMaster->id_user = $user->id;

        if (!$pegawaiMaster->save()) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Data Pegawai', 500);
        }


        return ResponseFormatter::success($pegawaiMaster, 'Berhasil Menyimpan Data Pegawai');
    } elseif ($formType === 'massal') {
        // Proses untuk form massal
        $nikList = explode("\n", str_replace("\r", "", $request->nik_list));

        
        foreach ($nikList as $nik) {
            $pegawaiData = Pegawai::where('nik', trim($nik));

            if ($pegawaiData->count()) {
                $pegawaiData = $pegawaiData->first();
                $pegawai = new PegawaiMaster();

                $pegawai->nama = $pegawaiData->nama;
                $pegawai->nik = $pegawaiData->nik;
                $pegawai->jabatan_id = $request->jabatan_massal;
                $pegawai->divisi_id = $request->divisi_massal;
                $pegawai->status = $request->status;

                if (!$pegawai->save()) {
                    return ResponseFormatter::error(null, 'Gagal Menyimpan Data Pegawai', 500);
                }

                // Jika nomor HP tidak kosong, buat user baru dengan username berdasarkan nomor HP
                if (!empty($request->nomor_hp)) {
                    $user = new User();
                    $user->name = $pegawaiData->nama; // Nama user diambil dari nama pegawai
                    $user->username = $request->nomor_hp; // Username diisi dengan nomor HP
                    $user->password = bcrypt('default_password'); // Password default (bisa diubah nanti)

                    if (!$user->save()) {
                        return ResponseFormatter::error(null, 'Gagal Membuat User', 500);
                    }
                }
            } else {
                return ResponseFormatter::error(null, 'Data Pegawai Tidak Ditemukan');
            }
        }

        return ResponseFormatter::success(null, 'Data Pegawai Berhasil Disimpan');
    }
    else{
        $request->validate([
            'file_import' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file_import');
        $spreadsheet = IOFactory::load($file->getPathname());
        $pegawaiSheet = $spreadsheet->getSheet(0); // Ambil sheet pertama (Pegawai)

        $highestRow = $pegawaiSheet->getHighestRow(); // Ambil jumlah baris maksimal
        $dataBerhasil = [];
        $dataGagal = "";

        DB::beginTransaction();
        try {
            for ($row = 2; $row <= $highestRow; $row++) {
                $nik = trim($pegawaiSheet->getCell('A' . $row)->getValue());
                $nama = trim($pegawaiSheet->getCell('B' . $row)->getValue());
                $nomor_hp = trim($pegawaiSheet->getCell('C' . $row)->getValue());
                $jabatan_nama = trim($pegawaiSheet->getCell('D' . $row)->getValue());
                $divisi_nama = trim($pegawaiSheet->getCell('E' . $row)->getValue());

                if (!empty($nik)) {
                    # code...
                
                // Validasi data kosong (wajib isi kecuali nomor HP)
                if (empty($nik) || empty($nama) || empty($jabatan_nama) || empty($divisi_nama)) {
                    $dataGagal[] = "Baris $row: Data tidak lengkap";
                    continue;
                }

                // Cari ID Jabatan berdasarkan nama
                $jabatan = Jabatan::where('nama', $jabatan_nama)->first();
                $divisi = Divisi::where('nama', $divisi_nama)->first();

                if (!$jabatan || !$divisi) {
                    $dataGagal[] = "Baris $row: Jabatan atau Divisi tidak ditemukan";
                    continue;
                }

                // Cek apakah nomor HP sudah digunakan di tabel users
                $user = null;
                if (!empty($nomor_hp)) {
                    $user = User::where('username', $nomor_hp)->first();
                    
                    // Jika user belum ada, buat user baru
                    if (!$user) {
                        $user = new User();
                        $user->name = $nama;
                        $user->username = $nomor_hp;
                        $user->password = Hash::make('default_password');

                        if (!$user->save()) {
                            $dataGagal[] = "Baris $row: Gagal membuat user";
                            continue;
                        }
                    }
                }

                // Cek apakah pegawai dengan NIK sudah ada
                $pegawaiExist = PegawaiMaster::where('nik', $nik)->first();
                if (!$pegawaiExist) {
                    // Simpan data PegawaiMaster
                    $pegawaiMaster = new PegawaiMaster();
                    $pegawaiMaster->nik = $nik;
                    $pegawaiMaster->nama = $nama;
                    // $pegawaiMaster->nomor_hp = $nomor_hp;
                    $pegawaiMaster->jabatan_id = $jabatan->id;
                    $pegawaiMaster->divisi_id = $divisi->id;
                    $pegawaiMaster->id_user = $user ? $user->id : null;

                    if (!$pegawaiMaster->save()) {
                        $dataGagal .= "Baris $row: Gagal menyimpan data pegawai";
                        continue;
                    }

                    $dataBerhasil[] = $pegawaiMaster;
                } else {
                    $dataGagal .= "- Baris $row: NIK sudah terdaftar";
                }
            }

        }

            DB::commit();

            if (!empty($dataGagal)) {
                return ResponseFormatter::error($dataGagal, 'Beberapa data gagal diimpor '.$dataGagal, 400);
            }

            return ResponseFormatter::success($dataBerhasil, 'Data pegawai berhasil diimpor');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error(null, 'Gagal mengimpor data pegawai: ' . $e->getMessage(), 500);
        }
        
    }
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($uuid)
    {
        // Cari data pegawai berdasarkan UUID
        $pegawai = PegawaiMaster::with(['jabatan', 'divisi','user'])->where('uuid', $uuid)->firstOrFail();
    
        // return $pegawai
        // Kirim data ke view
        return view('pages.pegawai_master.edit', compact('pegawai'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $pemaster = PegawaiMaster::where('uuid',$id)->firstOrFail();
        $id_user = $pemaster->id_user;
        // return $id_user;

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string',
            'jabatan_id' => 'required|exists:jabatans,id',
            'divisi_id' => 'required|exists:divisis,id',
            'status' => 'required|in:aktif,nonaktif',
            'token'=>'nullable',
            'nomor_hp' => [
                'nullable', 
                'string', 
                'max:15',
                Rule::unique('users', 'username')->ignore($id_user, 'id') // Pastikan username unik
            ],
        ]);
    
        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Data Pegawai: ' . $validator->errors()->first(), 422);
        }
    
        // Cek apakah pegawai dengan NIK tersebut ada di database
        $pegawai = Pegawai::where('nik', $request->nik);
        if (!$pegawai->count()) {
            return ResponseFormatter::error(null, 'Data Pegawai Tidak Ditemukan', 500);
        }
    
        $data_pegawai = $pegawai->first();
    
        // Ambil data pegawai master berdasarkan UUID
        $pegawaiMaster = PegawaiMaster::where('uuid', $id)->firstOrFail();
    
        // Update data pegawai master
        $pegawaiMaster->nama = $data_pegawai->nama;
        $pegawaiMaster->nik = $request->nik;
        $pegawaiMaster->jabatan_id = $request->jabatan_id;
        $pegawaiMaster->divisi_id = $request->divisi_id;
        $pegawaiMaster->status = $request->status;
    
        // Simpan perubahan data pegawai master
        if (!$pegawaiMaster->save()) {
            return ResponseFormatter::error(null, 'Gagal Mengubah Data Pegawai', 500);
        }
    
        // Jika nomor HP tidak kosong, perbarui username user terkait
        if (!empty($request->nomor_hp)) {
            // Cari user berdasarkan id_user di PegawaiMaster
            $user = $pegawaiMaster->user; // Relasi dengan User
    
            if ($user) {
                // Perbarui username dengan nomor HP
                $user->username = $request->nomor_hp;

                if (empty($request->token)) {
                    # code...
                    $user->key =null;
                }
    
                // Simpan perubahan user
                if (!$user->save()) {
                    return ResponseFormatter::error(null, 'Gagal Memperbarui Username User', 500);
                }
            } else {
                // Jika user belum ada, buat user baru
                $user = new User();
                $user->name = $data_pegawai->nama; // Nama user diambil dari nama pegawai
                $user->username = $request->nomor_hp; // Username diisi dengan nomor HP
                $user->password = bcrypt('default_password'); // Password default (bisa diubah nanti)
    
                // Simpan user baru
                if (!$user->save()) {
                    return ResponseFormatter::error(null, 'Gagal Membuat User', 500);
                }
    
                // Hubungkan user dengan PegawaiMaster
                $pegawaiMaster->id_user = $user->id;
                if (!$pegawaiMaster->save()) {
                    return ResponseFormatter::error(null, 'Gagal Menghubungkan User dengan Pegawai', 500);
                }
            }
        }
    
        return ResponseFormatter::success($pegawaiMaster, 'Berhasil Mengubah Data Pegawai');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pegawaiMaster = PegawaiMaster::with(['jabatan', 'divisi'])->where('uuid', $id)->firstOrFail();
        return view('pages.pegawai_master.show', compact('pegawaiMaster'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        DB::beginTransaction();
        try {
            // Cari pegawai berdasarkan UUID
            $pegawai = PegawaiMaster::where('uuid', $uuid)->first();
    
            if (!$pegawai) {
                return ResponseFormatter::error([], 'Data Pegawai tidak ditemukan', 404);
            }
            
            // Cari user berdasarkan nomor HP (username)
            $user = User::where('id', $pegawai->id_user)->first();
    
            // Hapus PegawaiMaster
            if (!$pegawai->delete()) {
                DB::rollBack();
                return ResponseFormatter::error([], 'Data Pegawai gagal dihapus', 500);
            }
    
            // Jika user ditemukan, hapus juga user
            if ($user) {
                $user->delete();
            }
    
            DB::commit();
            return ResponseFormatter::success([], 'Data Pegawai dan User berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error([], 'Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }
    
   
    public function export()
    {
        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();

        // === SHEET 1: Pegawai ===
        $sheet1 = $spreadsheet->setActiveSheetIndex(0);
        $sheet1->setTitle('Pegawai');
        $headerColumns = ['A1' => 'NIK', 'B1' => 'NAMA', 'C1' => 'NOMOR HP', 'D1' => 'JABATAN', 'E1' => 'DIVISI'];

        foreach ($headerColumns as $cell => $value) {
            $sheet1->setCellValue($cell, $value);
        }

        // Tambahkan 1 baris kosong untuk data pegawai
        $sheet1->setCellValue("A2", "") // NIK kosong
               ->setCellValue("B2", "") // Nama kosong
               ->setCellValue("C2", ""); // Nomor HP kosong

        // Auto width untuk kolom di Sheet Pegawai
        foreach (range('A', 'E') as $column) {
            $sheet1->getColumnDimension($column)->setAutoSize(true);
        }

        // Style untuk header (background warna + bold + tengah)
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFD700'] // Warna emas
            ]
        ];
        $sheet1->getStyle('A1:E1')->applyFromArray($headerStyle);

        // Border untuk semua sel di Sheet Pegawai
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $sheet1->getStyle('A1:E2')->applyFromArray($borderStyle);

        // === SHEET 2: Jabatan ===
        $sheet2 = $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1);
        $sheet2->setTitle('Jabatan');
        $sheet2->setCellValue('A1', 'Nama Jabatan');

        // Ambil data Jabatan
        $jabatanData = Jabatan::all();
        $row = 2;
        foreach ($jabatanData as $jabatan) {
            $sheet2->setCellValue("A$row", $jabatan->nama);
            $row++;
        }

        // Auto width untuk kolom Jabatan
        $sheet2->getColumnDimension('A')->setAutoSize(true);

        // Border untuk Sheet Jabatan
        $sheet2->getStyle("A1:A$row")->applyFromArray($borderStyle);

        // Style Header Jabatan
        $sheet2->getStyle('A1')->applyFromArray($headerStyle);

        // === SHEET 3: Divisi ===
        $sheet3 = $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(2);
        $sheet3->setTitle('Divisi');
        $sheet3->setCellValue('A1', 'Nama Divisi');

        // Ambil data Divisi
        $divisiData = Divisi::all();
        $row = 2;
        foreach ($divisiData as $divisi) {
            $sheet3->setCellValue("A$row", $divisi->nama);
            $row++;
        }

        // Auto width untuk kolom Divisi
        $sheet3->getColumnDimension('A')->setAutoSize(true);

        // Border untuk Sheet Divisi
        $sheet3->getStyle("A1:A$row")->applyFromArray($borderStyle);

        // Style Header Divisi
        $sheet3->getStyle('A1')->applyFromArray($headerStyle);

        // Kembali ke Sheet Pegawai
        $spreadsheet->setActiveSheetIndex(0);

        // === Tambahkan Dropdown untuk Kolom Jabatan & Divisi di Baris Pegawai ===
        $lastJabatanRow = $sheet2->getHighestRow();
        $lastDivisiRow = $sheet3->getHighestRow();

        // Data Validation untuk Jabatan (D2)
        $jabatanValidation = $sheet1->getCell("D2")->getDataValidation();
        $jabatanValidation->setType(DataValidation::TYPE_LIST);
        $jabatanValidation->setErrorStyle(DataValidation::STYLE_STOP);
        $jabatanValidation->setAllowBlank(false);
        $jabatanValidation->setShowDropDown(true);
        $jabatanValidation->setFormula1("'Jabatan'!\$A\$2:\$A\$$lastJabatanRow");

        // Data Validation untuk Divisi (E2)
        $divisiValidation = $sheet1->getCell("E2")->getDataValidation();
        $divisiValidation->setType(DataValidation::TYPE_LIST);
        $divisiValidation->setErrorStyle(DataValidation::STYLE_STOP);
        $divisiValidation->setAllowBlank(false);
        $divisiValidation->setShowDropDown(true);
        $divisiValidation->setFormula1("'Divisi'!\$A\$2:\$A\$$lastDivisiRow");

        // Simpan file di storage Laravel
        Storage::makeDirectory('exports');
        $filePath = 'exports/pegawai_export.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/' . $filePath));

        // Download file Excel
        return response()->download(storage_path('app/' . $filePath))->deleteFileAfterSend(true);
    }
    
    public function face(Request $request){
        $uuid = $request->uuid;

        $pegawaiMaster = PegawaiMaster::where('uuid', $uuid)->firstOrFail();
        @$photo= $pegawaiMaster->user->photo;
        return view('pages.pegawai_master.face',compact('photo','uuid'));

    }

 
    

    public function faceSave(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);
    
        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validasi gagal, tidak ada foto yang diupload', 422);
        }
    
        try {
            // Ambil UUID dari request
            $uuid = $request->uuid;
    
            // Cari data PegawaiMaster berdasarkan UUID
            $pegawaiMaster = PegawaiMaster::where('uuid', $uuid)->first();
            if (!$pegawaiMaster) {
                return ResponseFormatter::error(null, 'Data Pegawai Tidak Ditemukan', 404);
            }
    
            $user = $pegawaiMaster->user;
            if (!$user) {
                return ResponseFormatter::error(null, 'Data User Tidak Ditemukan', 404);
            }
    
            $uuid = $user->uuid;
    
            // Simpan file baru ke direktori public/faces
            $file = $request->file('photo');
    
            // Tentukan apakah ini register atau update berdasarkan keberadaan foto sebelumnya
            $existingPhoto = UserPhoto::where('user_id', $user->id)->first();
            $pythonApiUrl = $existingPhoto
                ? 'http://127.0.0.1:8002/update/' . $user->uuid
                : 'http://127.0.0.1:8002/register';
    
            // Simpan file sementara di storage
            $fileName = $uuid . '_' . time() . '.' . $file->getClientOriginalExtension(); // Nama unik untuk file
            $filePath = $file->storeAs('faces', $fileName, 'public'); // Gunakan disk 'public'
    
            // Kirim data ke API Python untuk pendaftaran atau pembaruan wajah
            $response = Http::attach(
                'image', file_get_contents(storage_path('app/public/' . $filePath)), $fileName
            )->post($pythonApiUrl, [
                'name' => $uuid,
            ]);
    
            // Cek respons dari API Python
            if ($response->successful()) {
                // URL file yang diupload
                $userPhoto = UserPhoto::where('user_id', $user->id);

                if ($userPhoto->first()) {
                    # code...
                    $dataUser = $userPhoto->first()->path;    
                    Storage::disk('public')->delete($dataUser);
                    
                }

                $fileUrl = Storage::disk('public')->url($filePath);
                $responsene = json_decode($response->body());
    
                // Simpan atau update data ke tabel user_photos
                $userPhoto = UserPhoto::updateOrCreate(
                    ['user_id' => $user->id], // Kunci pencarian
                    [
                        'path' => $filePath, // Path file baru
                        'created_at' => now(),
                        'updated_at' => now(),
                        'face_landmarks' => json_encode($responsene->landmarks)
                    ]
                );
    
                return ResponseFormatter::success(
                    [
                        'id' => $user->id,
                        'uuid' => $uuid,
                        'file_name' => $fileName,
                        'file_url' => $fileUrl,
                        'python_response' => $response->json(),
                    ],
                    $existingPhoto
                        ? 'Foto berhasil diperbarui dan terdaftar di sistem'
                        : 'Foto berhasil diupload dan terdaftar di sistem'
                );
            } else {
                // Jika gagal, hapus file baru dari storage
                Storage::disk('public')->delete($filePath);
    
                // Decode respons error dari API Python
                $responsene = json_decode($response->body())->error;
                return ResponseFormatter::error(
                    ['api_response' => $response->body()],
                    $existingPhoto
                        ? 'Gagal memperbarui foto: ' . $responsene
                        : 'Gagal mendaftarkan foto: ' . $responsene,
                    $response->status()
                );
            }
        } catch (\Exception $e) {
            // Tangani kesalahan umum
            // Pastikan file dihapus jika ada kesalahan
            if (isset($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
    
            return ResponseFormatter::error(
                ['error_message' => $e->getMessage()],
                'Terjadi kesalahan saat mengupload/memperbarui foto',
                500
            );
        }
    }

public function faceDelete($uuid)
{
    try {
        // Cari data PegawaiMaster berdasarkan UUID
        $pegawaiMaster = PegawaiMaster::where('uuid', $uuid)->first();
        if (!$pegawaiMaster) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Pegawai Tidak Ditemukan'
            ], 404);
        }

        // Cek apakah user terkait ada
        $user = $pegawaiMaster->user;
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data User Tidak Ditemukan'
            ], 404);
        }

        // Ambil UUID dari user
        $uuid = $user->uuid;

        // Hapus data wajah dari API Python
        $pythonDeleteUrl = "http://127.0.0.1:8002/delete/{$uuid}";
        $deleteResponse = Http::delete($pythonDeleteUrl);

        // Cek respons dari API Python
        if (!$deleteResponse->successful()) {
            $errorMsg = json_decode($deleteResponse->body())->error ?? 'Unknown error';
            // return response()->json([
            //     'status' => 'error',
            //     'message' => "Mohon Maaf Gagal Menghapus Foto: {$errorMsg}",
            //     'api_response' => $deleteResponse->body()
            // ], $deleteResponse->status());
        }

        // Cek apakah ada foto terkait di database
        $existingPhoto = UserPhoto::where('user_id', $user->id)->first();
        if ($existingPhoto) {
            // Hapus file gambar dari storage
            Storage::disk('public')->delete($existingPhoto->path);

            // Hapus entri foto dari database
            $existingPhoto->delete();
        }

        // Kembalikan respons sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Foto berhasil dihapus'
        ]);

    } catch (\Exception $e) {
        // Tangani kesalahan umum
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat menghapus foto',
            'error_message' => $e->getMessage()
        ], 500);
    }
}

public function landmarks(Request $request){

    $type = $request->type;
    
    $uuid = $request->uuid;
    $presensi = Presensi::where('uuid',$uuid)->first();
    if ($presensi) {
        # code...
        if ($type=="in") {
            # code...
            $landmark = $presensi->face_landmarks_in;
        }
        else{
            $landmark = $presensi->face_landmarks_out;
            
        }
    }
    // return $landmark;
    // $user = User::where('uuid',$uuid)->first();
    // $userPhoto = $user->photo;
    // $face_landmarks = $userPhoto->face_landmarks;
    // return $userPhoto;
// Ukuran canvas
$width = 640;
$height = 800;

// Buat gambar kosong
$image = imagecreatetruecolor($width, $height);

// Warna
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$red = imagecolorallocate($image, 255, 0, 0);

// Isi latar belakang dengan putih
imagefill($image, 0, 0, $white);

// Data landmark (samakan dengan data yang kamu punya)
$landmarks = json_decode($landmark, true);

// Gambar landmark
foreach ($landmarks as $feature => $points) {
    $prev = null;
    foreach ($points as $point) {
        $x = $point["x"];
        $y = $point["y"];

        // Gambar titik
        imagefilledellipse($image, $x, $y, 5, 5, $red);

        // Gambar garis antar titik
        if ($prev !== null) {
            imageline($image, $prev["x"], $prev["y"], $x, $y, $black);
        }

        $prev = $point;
    }
}

// Output gambar
header("Content-Type: image/png");
imagepng($image);
imagedestroy($image);

}

}