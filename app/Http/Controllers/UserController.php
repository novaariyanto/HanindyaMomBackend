<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();

            return DataTables::eloquent($query)
                ->addColumn('action', function (User $user) {
                    return '
                        <a href="' . route('user.show', $user->uuid) . '" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>
                        <a href="#" data-url="' . route('user.edit', $user->uuid) . '" class="btn btn-warning btn-sm btn-create"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btn-delete" data-url="' . route('user.destroy', $user->uuid) . '"><i class="ti ti-trash"></i></button>';
                })
                ->addColumn('role', function (User $user) {
                    return $user->roles->pluck('name')->implode(', '); // Ambil role user
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $title = 'User Management';
        $slug = 'user';
        return view('pages.user.index', compact('slug', 'title'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::all(); // Ambil semua role

            return view('pages.user.create',compact('roles'));
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'username' => 'required|string|max:191|unique:users,username',
            'password' => 'required|string|min:8',
            'role' => 'required|string|exists:roles,name'

        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan User: ' . $validator->errors()->first(), 422);
        }

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);

        if (!$user->save()) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan User', 500);
        }

        $user->assignRole($request->role); // Tambahkan role ke user


        return ResponseFormatter::success($user, 'Berhasil Menyimpan User');
    }

    public function edit(User $user, Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::all(); // Ambil semua role

            return view('pages.user.edit', compact('user','roles'));
        }
        return abort(404);
    }

    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'username' => [
                'required',
                'string',
                'max:191',
                Rule::unique('users', 'username')->ignore($uuid, 'uuid'),
            ],
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|exists:roles,name',

        ]);
    
        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Mengubah User', 422);
        }
    
        $user = User::where('uuid', $uuid)->firstOrFail();
    
        $user->name = $request->name;
        $user->username = $request->username;
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        if (!$user->save()) {
            return ResponseFormatter::error(null, 'Gagal Mengubah User', 500);
        }
        $user->syncRoles([$request->role]); // Update role user

        
    
        return ResponseFormatter::success($user, 'Berhasil Mengubah User');
    }

    public function show(User $user)
    {
        return view('pages.user.show', compact('user'));
    }

    public function destroy(User $user)
    {
        if (!$user->delete()) {
            return ResponseFormatter::error([], 'User gagal dihapus', 500);
        }

        return ResponseFormatter::success([], 'User berhasil dihapus');
    }
}
