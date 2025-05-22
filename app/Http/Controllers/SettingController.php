<?php
namespace App\Http\Controllers;



use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ResponseFormatter;

class SettingController extends Controller
{

    public function edit()
{
    $setting = Setting::first(); // Ambil data setting
    return view('pages.setting.create', compact('setting'));
}

    /**
     * Simpan atau update profil website.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveOrUpdateWebsiteProfile(Request $request)
    {
        // Validasi input
        $request->validate([
            'website_name' => 'nullable|string|max:255',
            'website_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);
    
        // Cari data setting yang sudah ada
        $setting = Setting::first();
    
        if (!$setting) {
            $setting = new Setting();
        }
    
        // Update data
        $setting->website_name = $request->website_name;
        $setting->website_description = $request->website_description;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->address = $request->address;
    
        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($setting->logo && file_exists(public_path($setting->logo))) {
                unlink(public_path($setting->logo));
            }
    
            $logoFile = $request->file('logo');
            $logoName = time().'_logo.'.$logoFile->getClientOriginalExtension();
            $logoFile->move(public_path('logos'), $logoName);
            $setting->logo = 'logos/'.$logoName;
        }
    
        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            if ($setting->favicon && file_exists(public_path($setting->favicon))) {
                unlink(public_path($setting->favicon));
            }
    
            $faviconFile = $request->file('favicon');
            $faviconName = time().'_favicon.'.$faviconFile->getClientOriginalExtension();
            $faviconFile->move(public_path('favicons'), $faviconName);
            $setting->favicon = 'favicons/'.$faviconName;
        }
    
        if (!$setting->save()) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Profil Website', 500);
        }
    
        return ResponseFormatter::success($setting, 'Berhasil Menyimpan Profil Website');
    }

    public function saveOrUpdateStruk(Request $request)
{
    // Validasi input
    $request->validate([
        'logo_struk' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'tagline_struk' => 'nullable|string|max:255',
    ]);

    // Cari data setting yang sudah ada
    $setting = Setting::first();

    if (!$setting) {
        $setting = new Setting();
    }

    // Handle logo struk upload
    if ($request->hasFile('logo_struk')) {
        if ($setting->logo_struk && file_exists(public_path($setting->logo_struk))) {
            unlink(public_path($setting->logo_struk));
        }

        $logoStrukFile = $request->file('logo_struk');
        $logoStrukName = time().'_logo_struk.'.$logoStrukFile->getClientOriginalExtension();
        $logoStrukFile->move(public_path('logos'), $logoStrukName);
        $setting->logo_struk = 'logos/'.$logoStrukName;
    }

    // Simpan tagline struk
    $setting->tagline_struk = $request->tagline_struk;

    if (!$setting->save()) {
        return ResponseFormatter::error(null, 'Gagal Menyimpan Pengaturan Struk', 500);
    }

    return ResponseFormatter::success($setting, 'Berhasil Menyimpan Pengaturan Struk');
}

public function saveNominal(Request $request){
    // Validasi input
    $request->validate([
        'nominal' => 'nullable',
    ]);

    // Cari data setting yang sudah ada
    $setting = Setting::first();

    if (!$setting) {
        $setting = new Setting();
    }

    // Simpan nominal
    $setting->nominal = $request->nominal;

    if (!$setting->save()) {
        return ResponseFormatter::error(null, 'Gagal Menyimpan Nominal', 500);
    }

    return ResponseFormatter::success($setting, 'Berhasil Menyimpan Nominal');
}

public function generateKode()
{
    // Generate kode acak 6 digit
    $kode = rand(100000, 999999);

    // Simpan ke database (misalnya ke tabel settings)
    $setting = Setting::first();
    if (!$setting) {
        $setting = new Setting();
    }
    $setting->kode_keamanan = $kode;
    $setting->save();

    return response()->json([
        'success' => true,
        'kode' => $kode
    ]);
}

}
