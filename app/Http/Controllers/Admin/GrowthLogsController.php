<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrowthLog;
use App\Models\BabyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GrowthLogsController extends Controller
{
    public function index()
    {
        $logs = GrowthLog::orderByDesc('date')->paginate(20);
        return view('admin.growth.index', compact('logs'));
    }

    public function create()
    {
        $babies = BabyProfile::orderBy('name')->get(['id','name']);
        return view('admin.growth.create', compact('babies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'baby_id' => ['required','string','size:36'],
            'date' => ['required','date'],
            'weight' => ['required','numeric'],
            'height' => ['required','numeric'],
            'head_circumference' => ['nullable','numeric'],
        ]);
        $data['id'] = (string) Str::uuid();
        GrowthLog::create($data);
        return redirect()->route('admin.growth.index')->with('success','Growth dibuat');
    }

    public function edit(GrowthLog $log)
    {
        $babies = BabyProfile::orderBy('name')->get(['id','name']);
        return view('admin.growth.edit', compact('log','babies'));
    }

    public function update(Request $request, GrowthLog $log)
    {
        $data = $request->validate([
            'baby_id' => ['required','string','size:36'],
            'date' => ['required','date'],
            'weight' => ['required','numeric'],
            'height' => ['required','numeric'],
            'head_circumference' => ['nullable','numeric'],
        ]);
        $log->update($data);
        return redirect()->route('admin.growth.index')->with('success','Growth diperbarui');
    }

    public function destroy(GrowthLog $log)
    {
        $log->delete();
        return redirect()->route('admin.growth.index')->with('success','Growth dihapus');
    }
}


