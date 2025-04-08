<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use Auth;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {

    
        // return $filteredMenus;

        if ($request->ajax()) {
            $query = Role::query();

            return DataTables::eloquent($query)
                ->addColumn('action', function (Role $role) {
                    return '
                        <a href="' . route('role.show', $role->id) . '" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>
                        <a href="#" data-url="' . route('role.edit', $role->id) . '" class="btn btn-warning btn-sm btn-create"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('role.destroy', $role->id) . '"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $title = 'Role ';
        $slug = 'role';
        return view('pages.role.index', compact('slug', 'title'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('pages.role.create');
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191|unique:roles,name',
            // 'guard_name' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Role: ' . $validator->errors()->first(), 422);
        }

        $role = new Role;
        $role->name = $request->name;
        // $role->guard_name = $request->guard_name;

        if (!$role->save()) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Role', 500);
        }

        return ResponseFormatter::success($role, 'Berhasil Menyimpan Role');
    }

    public function edit(Role $role, Request $request)
    {
        if ($request->ajax()) {
            return view('pages.role.edit', compact('role'));
        }
        return abort(404);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:191',
                // Rule::unique('roles', 'name')->ignore($id),
            ],
            // 'guard_name' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Mengubah Role', 422);
        }

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        // $role->guard_name = $request->guard_name;

        if (!$role->save()) {
            return ResponseFormatter::error(null, 'Gagal Mengubah Role', 500);
        }

        return ResponseFormatter::success($role, 'Berhasil Mengubah Role');
    }

    public function show($id)
    {
        $role = Role::with('menus')->findOrFail($id); // Ambil role beserta menu-menu yang terkait

        $menuse= $role->menus->pluck('id')->toArray();
        $menuss = Menu::with('children')->mainMenus()->orderBy('order')->get();

        // return $menus;


        return view('pages.role.show', compact('role','menuss','id','menuse'));
    }

    public function destroy($id)
    {

        // return $role;
        $role = Role::findOrFail($id);
        // return $role->delete();

        if (!$role->delete()) {
            return ResponseFormatter::error([], 'Role gagal dihapus', 500);
        }

        return ResponseFormatter::success([], 'Role berhasil dihapus');
    }

    public function createMenu(Request $request){
        $menuss = Menu::with('children')->mainMenus()->orderBy('order')->get();

        // return $menus;
        $id = $request->id;


        return view('pages.role.create_menu',compact('menuss','id'));
    }


    public function storeMenu(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'menus' => 'required|array',
        'menus.*' => 'exists:menus,uuid', // Pastikan UUID menu valid
    ]);

    // Cari role berdasarkan ID menggunakan Spatie
    $role = Role::findById($id);

    // Ambil route dari menu, lalu filter null
    $routes = Menu::whereIn('uuid', $validated['menus'])
        ->pluck('route')
        ->filter() // Menghapus route yang null
        ->toArray();

        // return $routes;
    // Ambil ID menu berdasarkan UUID
    $menuIds = Menu::whereIn('uuid', $validated['menus'])->pluck('id')->toArray();

    // Sinkronkan menu ke role (jika ada pivot role-menus)
    $role->menus()->sync($menuIds);

    // Sinkronkan permission (mengasumsikan setiap route adalah permission)
    $permissions = Permission::whereIn('name', $routes)->pluck('name')->toArray();
    $role->syncPermissions($permissions);

    // Kunci cache unik berdasarkan role ID
$cacheKey = 'user_menus_' . $role->id;

// Hapus cache untuk kunci ini
Cache::forget($cacheKey);

    return ResponseFormatter::success([], 'Berhasil Menambahkan Menu dan Permissions');
}



}
