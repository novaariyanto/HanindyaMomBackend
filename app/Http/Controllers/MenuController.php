<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    // Menampilkan daftar menu
    public function index()
    {
        // Ambil semua menu utama beserta submenu-nya, diurutkan berdasarkan kolom `order`
        $menuss = Menu::with('children')->mainMenus()->orderBy('order')->get();

        // return $menus;
        return view('pages.menu.index', compact('menuss'));
    }
    // Menampilkan form tambah menu
    public function create()
    {
        $menuss = Menu::get(); // Ambil menu utama untuk dropdown parent
        return view('pages.menu.create', compact('menuss'));
    }

    // Simpan data menu baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
        ]);
    
        // Cek apakah route ada di daftar route yang terdaftar di Laravel
        if (!empty($validated['route']) && $validated['route'] !== '#' && !Route::has($validated['route'])) {
            return redirect()->back()->withErrors(['route' => 'Route yang dimasukkan tidak valid.']);
        }
    
        Menu::create($validated);
    
        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }
    
    // Menampilkan form edit menu
    public function edit(Menu $menu)
    {
        $menuss = Menu::get();
        return view('pages.menu.edit', compact('menu', 'menuss'));
    }

    // Update data menu
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'route' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && $value !== '#' && !Route::has($value)) {
                        $fail('Route yang dimasukkan tidak valid.');
                    }
                },
            ],
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
        ]);
    
        $menu->update($validated);
    
        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }
    // Hapus menu
    public function destroy($id)
    {


        
        $menu = Menu::where('uuid',$id);
        $menu->delete();
        return ResponseFormatter::success([], 'Berhasil Memperbarui Urutan Menu');

    }

    // Endpoint untuk memperbarui urutan menu
    public function updateOrder(Request $request)
    {
        $orderData = $request->input('order');

        foreach ($orderData as $index => $uuid) {
            $menu = Menu::where('uuid', $uuid)->firstOrFail();
            $menu->update(['order' => $index + 1]); // Simpan urutan baru
        }

        return ResponseFormatter::success($orderData, 'Berhasil Memperbarui Urutan Menu');
    }

    public function reorder(Request $request)
    {
        try {
            $menuOrder = $request->input('order', []);
            
            foreach ($menuOrder as $index => $uuid) {
                Menu::where('uuid', $uuid)->update(['order' => $index + 1]);
            }
            
            return ResponseFormatter::success([], 'Urutan menu berhasil diperbarui');
        } catch (\Exception $e) {
            return ResponseFormatter::error(null, 'Gagal memperbarui urutan menu: ' . $e->getMessage());
        }
    }
    
}