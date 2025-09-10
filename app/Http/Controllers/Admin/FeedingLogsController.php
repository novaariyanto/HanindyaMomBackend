<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeedingLog;
use App\Models\BabyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FeedingLogsController extends Controller
{
    public function index()
    {
        $logs = FeedingLog::orderByDesc('start_time')->paginate(20);
        return view('admin.feeding.index', compact('logs'));
    }

    public function create()
    {
        $babies = BabyProfile::orderBy('name')->get(['id','name']);
        return view('admin.feeding.create', compact('babies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'baby_id' => ['required','string','size:36'],
            'type' => ['required','in:asi_left,asi_right,formula,pump'],
            'start_time' => ['required','date'],
            'duration_minutes' => ['required','integer','min:1'],
            'notes' => ['nullable','string'],
        ]);
        $data['id'] = (string) Str::uuid();
        FeedingLog::create($data);
        return redirect()->route('admin.feeding.index')->with('success','Feeding dibuat');
    }

    public function edit(FeedingLog $log)
    {
        $babies = BabyProfile::orderBy('name')->get(['id','name']);
        return view('admin.feeding.edit', compact('log','babies'));
    }

    public function update(Request $request, FeedingLog $log)
    {
        $data = $request->validate([
            'baby_id' => ['required','string','size:36'],
            'type' => ['required','in:asi_left,asi_right,formula,pump'],
            'start_time' => ['required','date'],
            'duration_minutes' => ['required','integer','min:1'],
            'notes' => ['nullable','string'],
        ]);
        $log->update($data);
        return redirect()->route('admin.feeding.index')->with('success','Feeding diperbarui');
    }

    public function destroy(FeedingLog $log)
    {
        $log->delete();
        return redirect()->route('admin.feeding.index')->with('success','Feeding dihapus');
    }
}


