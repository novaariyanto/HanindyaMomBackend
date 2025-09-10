<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'username' => ['required','string','max:255','unique:users,username'],
            'email' => ['nullable','email','max:255'],
            'password' => ['required','string','min:6'],
            'role' => ['nullable','in:admin'],
        ]);
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'] ?? null,
            'password' => Hash::make($data['password'])
        ]);
        if (($data['role'] ?? null) === 'admin') {
            $user->syncRoles(['admin']);
        }
        return redirect()->route('admin.users.index')->with('success','User dibuat');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'username' => ['required','string','max:255','unique:users,username,'.$user->id],
            'email' => ['nullable','email','max:255'],
            'password' => ['nullable','string','min:6'],
            'role' => ['nullable','in:admin'],
        ]);

        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'] ?? null;
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();
        $user->syncRoles(($data['role'] ?? null) === 'admin' ? ['admin'] : []);

        return redirect()->route('admin.users.index')->with('success','User diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User dihapus');
    }
}


