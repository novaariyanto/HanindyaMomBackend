<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeController extends Controller
{
    public function show(Request $request)
    {
        $userId = $request->user()->id;
        $user = User::findOrFail($userId);

        $profile = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'photo' => $user->photo,
        ];

        return response()->json(['data' => $profile]);
    }

    public function update(Request $request)
    {
        $userId = $request->user()->id;
        $user = User::findOrFail($userId);

        $validator = Validator::make($request->all(), [
            'name' => ['sometimes','string','max:255'],
            'email' => ['sometimes','nullable','email','max:255','unique:users,email,' . $user->id],
            'photo' => ['sometimes','nullable','string','max:2000'],
            'photo_file' => ['sometimes','nullable','image','max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        if (array_key_exists('name', $data)) {
            $user->name = $data['name'];
        }
        if (array_key_exists('email', $data)) {
            $user->email = $data['email'];
        }
        $user->save();

        // Update foto jika dikirim sebagai URL string
        if ($request->has('photo')) {
            $photo = $request->string('photo')->toString();
            if ($photo === '' || $photo === null) {
                $user->photo = null;
            } else {
                $user->photo = $photo;
            }
            $user->save();
        }

        // Update foto jika dikirim sebagai file upload
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

        $profile = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'photo' => $user->photo
        ];

        return response()->json(['data' => $profile]);
    }
}


