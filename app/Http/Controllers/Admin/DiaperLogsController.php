<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiaperLog;
use App\Models\BabyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiaperLogsController extends Controller
{
    public function index()
    {
        $logs = DiaperLog::orderByDesc('time')->paginate(20);
        return view('admin.diapers.index', compact('logs'));
    }

    public function create()
    {
        $babies = BabyProfile::orderBy('name')->get(['id','name']);
        return view('admin.diapers.create', compact('babies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'baby_id' => ['required','string','size:36'],
            'type' => ['required','in:pipis,pup,campuran'],
            'color' => ['nullable','string','max:50'],
            'texture' => ['nullable','string','max:50'],
            'time' => ['required','date'],
            'notes' => ['nullable','string'],
        ]);
        $data['id'] = (string) Str::uuid();
        DiaperLog::create($data);
        return redirect()->route('admin.diapers.index')->with('success','Diaper dibuat');
    }

    public function edit(DiaperLog $log)
    {
        $babies = BabyProfile::orderBy('name')->get(['id','name']);
        return view('admin.diapers.edit', compact('log','babies'));
    }

    public function update(Request $request, DiaperLog $log)
    {
        $data = $request->validate([
            'baby_id' => ['required','string','size:36'],
            'type' => ['required','in:pipis,pup,campuran'],
            'color' => ['nullable','string','max:50'],
            'texture' => ['nullable','string','max:50'],
            'time' => ['required','date'],
            'notes' => ['nullable','string'],
        ]);
        $log->update($data);
        return redirect()->route('admin.diapers.index')->with('success','Diaper diperbarui');
    }

    public function destroy(DiaperLog $log)
    {
        $log->delete();
        return redirect()->route('admin.diapers.index')->with('success','Diaper dihapus');
    }
}


