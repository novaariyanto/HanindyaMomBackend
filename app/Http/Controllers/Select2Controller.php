<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\PegawaiMaster;
use App\Models\Shift;
use Illuminate\Http\Request;

class Select2Controller extends Controller
{
    //
    public function divisi(Request $request)
    {
        $search = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = Divisi::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $results = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $results->items(),
            'current_page' => $results->currentPage(),
            'last_page' => $results->lastPage(),
        ]);
    }

    public function shift(Request $request)
    {
        // Ambil parameter pencarian dan halaman
        $search = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;
    
        // Ambil parameter divisi_id (opsional)
        $divisiId = $request->input('divisi_id');
    
        // Query dasar untuk shift
        $query = Shift::query();
    
        // Filter berdasarkan divisi_id jika ada
        if ($divisiId) {
            $query->whereHas('divisis', function ($q) use ($divisiId) {
                $q->where('divisis.id', $divisiId); // Filter shift berdasarkan divisi
            });
        }
    
        // Filter berdasarkan pencarian jika ada
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_shift', 'like', '%' . $search . '%')
                  ->orWhere('kode_shift', 'like', '%' . $search . '%'); // Opsional: tambahkan filter kode_shift
            });
        }
    
        // Paginate hasil
        $results = $query->paginate($perPage, ['*'], 'page', $page);
    
        // Format hasil untuk Select2
        return response()->json([
            'data' => $results->items(),
            'current_page' => $results->currentPage(),
            'last_page' => $results->lastPage(),
        ]);
    }
    public function pegawai(Request $request)
    {
        $search = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = Pegawai::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $results = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $results->items(),
            'current_page' => $results->currentPage(),
            'last_page' => $results->lastPage(),
        ]);
    }


    public function pegawaiMaster(Request $request)
    {
        $search = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = PegawaiMaster::query();

        if ($request->divisi_id!=null) {
            # code...
            $query->where('divisi_id',$request->divisi_id);
        }

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $results = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $results->items(),
            'current_page' => $results->currentPage(),
            'last_page' => $results->lastPage(),
        ]);
    }



    public function jabatan(Request $request)
    {
        $search = $request->input('q');
        $page = $request->input('page', 1);
        $perPage = 10;

        $query = Jabatan::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $results = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $results->items(),
            'current_page' => $results->currentPage(),
            'last_page' => $results->lastPage(),
        ]);
    }


    // jabatan
}
