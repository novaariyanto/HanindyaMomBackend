<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VaccineSchedule;
use App\Models\BabyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VaccineSchedulesController extends Controller
{
    public function index()
    {
        $logs = VaccineSchedule::orderByDesc('schedule_date')->paginate(20);
        return view('admin.vaccines.index', compact('logs'));
    }

    public function create()
    {
        $babies = BabyProfile::orderBy('name')->get(['id','name']);
        return view('admin.vaccines.create', compact('babies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'baby_id' => ['required','string','size:36'],
            'vaccine_name' => ['required','string','max:150'],
            'schedule_date' => ['required','date'],
            'status' => ['required','in:scheduled,done'],
            'notes' => ['nullable','string'],
        ]);
        $data['id'] = (string) Str::uuid();
        VaccineSchedule::create($data);
        return redirect()->route('admin.vaccines.index')->with('success','Vaksin dibuat');
    }

    public function edit(VaccineSchedule $log)
    {
        $babies = BabyProfile::orderBy('name')->get(['id','name']);
        return view('admin.vaccines.edit', compact('log','babies'));
    }

    public function update(Request $request, VaccineSchedule $log)
    {
        $data = $request->validate([
            'baby_id' => ['required','string','size:36'],
            'vaccine_name' => ['required','string','max:150'],
            'schedule_date' => ['required','date'],
            'status' => ['required','in:scheduled,done'],
            'notes' => ['nullable','string'],
        ]);
        $log->update($data);
        return redirect()->route('admin.vaccines.index')->with('success','Vaksin diperbarui');
    }

    public function destroy(VaccineSchedule $log)
    {
        $log->delete();
        return redirect()->route('admin.vaccines.index')->with('success','Vaksin dihapus');
    }
}


