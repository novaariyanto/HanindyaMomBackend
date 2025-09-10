<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BabyProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BabiesController extends Controller
{
    public function index()
    {
        $babies = BabyProfile::orderByDesc('created_at')->paginate(20);
        return view('admin.babies.index', compact('babies'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get(['uuid','name']);
        return view('admin.babies.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_uuid' => ['required','string','size:36'],
            'name' => ['required','string','max:100'],
            'birth_date' => ['required','date'],
            'photo' => ['nullable','string'],
            'birth_weight' => ['nullable','numeric'],
            'birth_height' => ['nullable','numeric'],
        ]);
        $data['id'] = (string) Str::uuid();
        BabyProfile::create($data);
        return redirect()->route('admin.babies.index')->with('success','Bayi dibuat');
    }

    public function show(BabyProfile $baby)
    {
        $baby->load(['feedingLogs','diaperLogs','sleepLogs','growthLogs','vaccineSchedules']);
        return view('admin.babies.show', compact('baby'));
    }

    public function edit(BabyProfile $baby)
    {
        $users = User::orderBy('name')->get(['uuid','name']);
        return view('admin.babies.edit', compact('baby','users'));
    }

    public function update(Request $request, BabyProfile $baby)
    {
        $data = $request->validate([
            'user_uuid' => ['required','string','size:36'],
            'name' => ['required','string','max:100'],
            'birth_date' => ['required','date'],
            'photo' => ['nullable','string'],
            'birth_weight' => ['nullable','numeric'],
            'birth_height' => ['nullable','numeric'],
        ]);
        $baby->update($data);
        return redirect()->route('admin.babies.index')->with('success','Bayi diperbarui');
    }

    public function destroy(BabyProfile $baby)
    {
        $baby->delete();
        return redirect()->route('admin.babies.index')->with('success','Bayi dihapus');
    }
}


