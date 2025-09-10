<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SleepLog;
use App\Models\BabyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SleepLogsController extends Controller
{
    public function index()
    {
        $logs = SleepLog::orderByDesc('start_time')->paginate(20);
        return view('admin.sleep.index', compact('logs'));
    }

    public function create()
    {
        $babies = BabyProfile::orderBy('name')->get(['id','name']);
        return view('admin.sleep.create', compact('babies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'baby_id' => ['required','string','size:36'],
            'start_time' => ['required','date'],
            'end_time' => ['required','date','after:start_time'],
            'notes' => ['nullable','string'],
        ]);
        $data['id'] = (string) Str::uuid();
        $data['duration_minutes'] = (int) round((strtotime($data['end_time']) - strtotime($data['start_time']))/60);
        SleepLog::create($data);
        return redirect()->route('admin.sleep.index')->with('success','Sleep dibuat');
    }

    public function edit(SleepLog $log)
    {
        $babies = BabyProfile::orderBy('name')->get(['id','name']);
        return view('admin.sleep.edit', compact('log','babies'));
    }

    public function update(Request $request, SleepLog $log)
    {
        $data = $request->validate([
            'baby_id' => ['required','string','size:36'],
            'start_time' => ['required','date'],
            'end_time' => ['required','date','after:start_time'],
            'notes' => ['nullable','string'],
        ]);
        $data['duration_minutes'] = (int) round((strtotime($data['end_time']) - strtotime($data['start_time']))/60);
        $log->update($data);
        return redirect()->route('admin.sleep.index')->with('success','Sleep diperbarui');
    }

    public function destroy(SleepLog $log)
    {
        $log->delete();
        return redirect()->route('admin.sleep.index')->with('success','Sleep dihapus');
    }
}


