<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Radius;
use Illuminate\Http\Request;
use Validator;

class SettingRadiusController extends Controller
{
    public function index()
    {
        // Ambil data radius terbaru dari database
        $radius = Radius::latest()->first(); // Ambil data terbaru

        $slug = 'setting-radius';
        $title = 'Setting Radius';

        return view('pages.setting-radius.index', compact('slug', 'title', 'radius'));
    }

 /**
     * Simpan data radius ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'coordinates' => 'required|array', // Koordinat harus berupa array
            'width' => 'required|numeric',    // Lebar harus berupa angka
            'height' => 'required|numeric',  // Tinggi harus berupa angka
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Radius: ' . $validator->errors()->first(), 422);
        }

        $coordinates = $request->input('coordinates');

        
        // Balikkan urutan koordinat menjadi [longitude, latitude]
        $adjustedCoordinates = array_map(function ($coord) {
            return [$coord[1], $coord[0]]; // Balik urutan [lat, lng] -> [lng, lat]
        }, $coordinates);


        // Simpan data ke database
        $radius = new Radius;
        $radius->coordinates = json_encode($request->coordinates); // Simpan koordinat sebagai JSON
        $radius->width = $request->width;
        $radius->height = $request->height;

        if (!$radius->save()) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Radius', 500);
        }

        return ResponseFormatter::success($radius, 'Berhasil Menyimpan Radius');
    }

    /**
     * Hapus data radius dari database.
     */
    public function destroy()
    {
        $radius = Radius::latest()->first(); // Ambil data radius terbaru

        if (!$radius) {
            return ResponseFormatter::error(null, 'Data Radius tidak ditemukan', 404);
        }

        if (!$radius->delete()) {
            return ResponseFormatter::error(null, 'Gagal Menghapus Radius', 500);
        }

        return ResponseFormatter::success(null, 'Radius berhasil dihapus');
    }
     /**
     * Cek apakah lokasi pengguna berada di dalam radius.
     */
    public function checkLocation(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memvalidasi input: ' . $validator->errors()->first(),
            ], 422);
        }
    
        // Ambil lokasi pengguna dari request
        $userLng = $request->input('latitude');
        $userLat = $request->input('longitude');
    
        // Debugging: Cek apakah koordinat input valid
        \Log::debug("Titik Pengguna: Latitude: $userLat, Longitude: $userLng");
    
        // Ambil data radius terbaru dari database
        $radius = Radius::latest()->first();
    
        if (!$radius) {
            return response()->json([
                'success' => false,
                'message' => 'Data radius tidak ditemukan.',
            ], 404);
        }
    
        // Konversi koordinat radius ke format array
        $coordinates = json_decode($radius->coordinates, true);
    
        // Pastikan koordinat adalah array valid
        if (!is_array($coordinates) || empty($coordinates)) {
            return response()->json([
                'success' => false,
                'message' => 'Koordinat radius tidak valid.',
            ], 500);
        }
    
        // Debugging: Cek apakah koordinat poligon valid
        \Log::debug("Koordinat Poligon: " . json_encode($coordinates));
    
        // Ubah urutan koordinat menjadi [longitude, latitude]
        $adjustedCoordinates = array_map(function ($coord) {
            return [$coord[1], $coord[0]]; // Balik urutan [lat, lng] -> [lng, lat]
        }, $coordinates);
    
        // Debugging: Cek koordinat yang sudah dibalik
        \Log::debug("Koordinat Poligon Setelah Dibalik: " . json_encode($adjustedCoordinates));
    
        // Implementasi Ray-Casting untuk mengecek apakah titik berada dalam poligon
        $isInside = $this->isPointInPolygon([$userLat, $userLng], $adjustedCoordinates);
    
        return response()->json([
            'success' => true,
            'inside' => $isInside,
            'message' => $isInside ? 'Anda berada di dalam radius.' : 'Anda berada di luar radius.',
        ]);
    }
    
    private function isPointInPolygon($point, $polygon)
    {
        $x = $point[0];
        $y = $point[1];
        $inside = false;
    
        // Loop melalui sisi-sisi poligon
        for ($i = 0, $j = count($polygon) - 1; $i < count($polygon); $j = $i++) {
            $xi = $polygon[$i][0];
            $yi = $polygon[$i][1];
            $xj = $polygon[$j][0];
            $yj = $polygon[$j][1];
    
            // Periksa apakah titik berada pada sisi horizontal poligon
            $intersect = (($yi > $y) != ($yj > $y)) &&
                         ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
            if ($intersect) {
                $inside = !$inside;
            }
        }
    
        return $inside;
    }
    
}
