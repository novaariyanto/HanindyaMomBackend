<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();

            return DataTables::eloquent($query)
                ->addColumn('photo', function (User $user) {
                    $src = $user->photo ? asset($user->photo) : asset('imgs/user-default.png');
                    return '<img src="' . e($src) . '" alt="photo" class="rounded-circle" width="36" height="36" />';
                })
                ->addColumn('action', function (User $user) {
                    return '
                        <a href="#" data-url="' . route('admin.users.edit', $user->uuid) . '" class="btn btn-warning btn-sm btnn-create"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btnn-delete" data-url="' . route('admin.users.destroy', $user->uuid) . '"><i class="ti ti-trash"></i></button>';
                })
                ->rawColumns(['action','photo'])
                ->toJson();
        }

        $title = 'Users';
        $slug = 'users';
        return view('admin.users.index', compact('slug', 'title'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            return view('admin.users.create');
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','string','max:255'],
            'username' => ['required','string','max:255','unique:users,username'],
            'email' => ['nullable','email','max:255'],
            'password' => ['required','string','min:6'],
            'role' => ['nullable','in:admin'],
            'photo_file' => ['nullable','image','max:2048'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Data: ' . $validator->errors()->first(), 422);
        }

        $data = $validator->validated();
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'] ?? null,
            'password' => Hash::make($data['password'])
        ]);
        if (($data['role'] ?? null) === 'admin') {
            $user->syncRoles(['admin']);
        }

        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/users');
            if (!is_dir($dest)) {
                @mkdir($dest, 0775, true);
            }
            $file->move($dest, $filename);
            $path = 'uploads/users/' . $filename;
            $user->photo = $path;
            $user->save();
        }

        return ResponseFormatter::success($user, 'Berhasil Menyimpan Data');
    }

    public function edit(User $user, Request $request)
    {
        if ($request->ajax()) {
            return view('admin.users.edit', compact('user'));
        }
        return abort(404);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','string','max:255'],
            'username' => ['required','string','max:255','unique:users,username,'.$user->id],
            'email' => ['nullable','email','max:255'],
            'password' => ['nullable','string','min:6'],
            'role' => ['nullable','in:admin'],
            'photo_file' => ['nullable','image','max:2048'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Mengubah Data', 422);
        }

        $data = $validator->validated();
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'] ?? null;
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        if (!$user->save()) {
            return ResponseFormatter::error(null, 'Gagal Mengubah Data', 500);
        }
        $user->syncRoles(($data['role'] ?? null) === 'admin' ? ['admin'] : []);

        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = 'user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/users');
            if (!is_dir($dest)) {
                @mkdir($dest, 0775, true);
            }
            $file->move($dest, $filename);
            $path = 'uploads/users/' . $filename;
            $user->photo = $path;
            $user->save();
        }

        return ResponseFormatter::success($user, 'Berhasil Mengubah Data');
    }

    public function destroy(User $user)
    {
        if (!$user->delete()) {
            return ResponseFormatter::error([], 'Data gagal dihapus', 500);
        }

        return ResponseFormatter::success([], 'Data berhasil dihapus');
    }
}


