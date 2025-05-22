<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Pegawai;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AbsensiController extends Controller
{


    public function count(Request $request)
{
    if ($request->ajax()) {
        // Query awal untuk mengambil semua data presensi
        $query = Presensi::select('presensis.*')->with(['pegawai.divisi', 'pegawaiShift.shift.jamKerja']);

        // Filter berdasarkan divisi_id jika ada parameter `divisi_id`
        if ($request->has('divisi_id') && !empty($request->divisi_id)) {
            $query->whereHas('pegawai', function ($q) use ($request) {
                $q->where('divisi_id', $request->divisi_id);
            });
        }

        // Filter berdasarkan pegawai_id jika ada parameter `pegawai_id`
        if ($request->has('pegawai_id') && !empty($request->pegawai_id)) {
            $query->where('pegawai_id', $request->pegawai_id);
        }

        // Filter berdasarkan rentang tanggal
        $startDate = $request->input('start_date') ? $request->input('start_date') : date('Y-m-d'); // Default: Hari ini
        $endDate = $request->input('end_date') ? $request->input('end_date') : date('Y-m-d');     // Default: Hari ini

        $query->whereBetween('tanggal', [$startDate, $endDate]);

        // Eksekusi query untuk mendapatkan data presensi
        $presensiData = $query->get();

        // Hitung jumlah status presensi
        $countStatus = [
            'hadir' => $presensiData->where('status', 'hadir')->count(),
            'terlambat' => $presensiData->where('status', 'terlambat')->count(),
            'alpha' => $presensiData->where('status', 'alpha')->count(),
            'izin' => $presensiData->where('status', 'izin')->count(),
        ];

        // Kembalikan hanya countStatus sebagai respons JSON
        return response()->json($countStatus);
    }

    // Ambil semua divisi untuk dropdown filter

}


    //
   /**
     * Menampilkan data absensi dalam format DataTable.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Query awal untuk mengambil semua data presensi
            $query = Presensi::select('presensis.*')->with(['pegawai.divisi', 'pegawaiShift.shift.jamKerja']);
    
            // Filter berdasarkan divisi_id jika ada parameter `divisi_id`
            if ($request->has('divisi_id') && !empty($request->divisi_id)) {
                $query->whereHas('pegawai', function ($q) use ($request) {
                    $q->where('divisi_id', $request->divisi_id);
                });
            }
    
            // Filter berdasarkan pegawai_id jika ada parameter `pegawai_id`
            if ($request->has('pegawai_id') && !empty($request->pegawai_id)) {
                $query->where('pegawai_id', $request->pegawai_id);
            }
    
            // Filter berdasarkan tanggal jika ada parameter `tanggal`

        // Filter berdasarkan rentang tanggal (menggunakan ternary)
        $startDate = $request->input('start_date') ? $request->input('start_date') : date('Y-m-d'); // Default: Hari ini
        $endDate = $request->input('end_date') ? $request->input('end_date') : date('Y-m-d');     // Default: Hari ini

        $query->whereBetween('tanggal', [$startDate, $endDate]);

        // exit;

        $query->whereBetween('tanggal', [$startDate, $endDate]);
    
            return DataTables::eloquent($query)
                ->addColumn('uuids', function (Presensi $presensi) {
                    return $presensi->getAttribute('uuid') ?? '-'; // Pastikan mengambil dari Presensi
                })
                ->addColumn('nik', function (Presensi $presensi) {
                    return $presensi->pegawai?->nik ?? '-';
                })
                ->addColumn('nama', function (Presensi $presensi) {
                    return $presensi->pegawai?->nama ?? '-';
                })
                
                ->addColumn('jam_masuk', function (Presensi $presensi) {
                    return $presensi->jam_masuk ?? '-';
                })
                ->addColumn('jam_keluar', function (Presensi $presensi) {
                    return $presensi->jam_keluar ?? '-';
                })
                ->addColumn('status', function (Presensi $presensi) {
                    return $presensi->status ?? '-';
                })
                ->addColumn('keterangan', function (Presensi $presensi) {
                    return $presensi->keterangan ?? '-';
                })
                ->addColumn('action', function (Presensi $presensi) {
                    // Tombol aksi (edit, delete, dll.)
                    return '
                        <a href="' . route('absensi.show', $presensi->uuid) . '" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('absensi.destroy', $presensi->uuid) . '"><i class="ti ti-trash"></i></button>';
                })
                ->filter(function ($query) use ($request) {
                    // Custom filter untuk pencarian global
                    if ($request->has('search') && !empty($request->search['value'])) {
                        $search = $request->search['value'];
                        $query->whereHas('pegawai', function ($q) use ($search) {
                            $q->where('nik', 'like', '%' . $search . '%')
                              ->orWhere('nama', 'like', '%' . $search . '%');
                        });
                    }
                })
                ->rawColumns(['action']) // Kolom yang mengandung HTML harus di-escape secara manual
                ->toJson();
        }
    
        // Ambil semua divisi untuk dropdown filter
        $divisis = \App\Models\Divisi::all();
    
        // Ambil semua pegawai untuk dropdown filter
        $title = 'Absensi';
        $slug = 'absensi';
    
        return view('pages.absensi.index', compact('slug', 'title', 'divisis'));
    }
    public function destroy($uuid)
    
    {
        $presensi = Presensi::where('uuid',$uuid);
        if (!$presensi->delete()) {
            return ResponseFormatter::error([], 'Data Absensi gagal dihapus', 500);
        }
        return ResponseFormatter::success([], 'Data Absensi berhasil dihapus');
    }

    public function show($uuid)
    {
        // Cari data presensi berdasarkan UUID
        $presensi = Presensi::with(['pegawai', 'pegawaiShift.shift.jamKerja'])
            ->where('uuid', $uuid)
            ->firstOrFail();
            
    
        // Format data untuk ditampilkan di view
        $data = [
            'uuid'=>$presensi->uuid,
            'nik' => $presensi->pegawai?->nik ?? '-',
            'nama' => $presensi->pegawai?->nama ?? '-',
            'tanggal' => $presensi->tanggal ? date('d-m-Y', strtotime($presensi->tanggal)) : '-',
            'jam_masuk_jadwal' => $presensi->jam_masuk_jadwal ?? '-',
            'jam_masuk' => $presensi->jam_masuk ?? '-',
            'jam_keluar_jadwal' => $presensi->jam_keluar_jadwal ?? '-',
            'jam_keluar' => $presensi->jam_keluar ?? '-',
            'status' => $presensi->status ?? '-',
            'keterangan' => $presensi->keterangan ?? '-',
            'longitude_masuk' => $presensi->longitude_masuk ?? '-',
            'latitude_masuk' => $presensi->latitude_masuk ?? '-',
            'longitude_keluar' => $presensi->longitude_keluar ?? '-',
            'latitude_keluar' => $presensi->latitude_keluar ?? '-',
            'face_landmarks_in' => $presensi->face_landmarks_in ?? '-',
            'face_landmarks_out' => $presensi->face_landmarks_out ?? '-',
        ];
        // return $data;
    
        return view('pages.absensi.show', compact('data'));
    }


    public function detail(Request $request){
          // Cari data presensi berdasarkan UUID
          $uuid = $request->uuid;
          $presensi = Presensi::with(['pegawai.divisi', 'pegawaiShift.shift.jamKerja'])
          ->where('uuid', $uuid)
          ->firstOrFail();

          return $presensi;
          

        return;
    }

}
