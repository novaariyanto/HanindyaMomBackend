<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Models\SleepLog;
use App\Models\BabyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SleepLogsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = SleepLog::query()->with('baby');

            return DataTables::eloquent($query)
                ->addColumn('action', function (SleepLog $log) {
                    return '
                        <a href="#" data-url="' . route('admin.sleep.edit', $log->id) . '" class="btn btn-warning btn-sm btnn-create"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btnn-delete" data-url="' . route('admin.sleep.destroy', $log->id) . '"><i class="ti ti-trash"></i></button>';
                })
                ->addColumn('baby_name', function (SleepLog $log) {
                    return optional($log->baby)->name;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $title = 'Sleep Logs';
        $slug = 'sleep';
        return view('admin.sleep.index', compact('slug', 'title'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $babies = BabyProfile::orderBy('name')->get(['id','name']);
            return view('admin.sleep.create', compact('babies'));
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'baby_id' => ['required','string','size:36'],
            'start_time' => ['required','date'],
            'end_time' => ['required','date','after:start_time'],
            'notes' => ['nullable','string'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Data: ' . $validator->errors()->first(), 422);
        }

        $data = $validator->validated();
        $data['id'] = (string) Str::uuid();
        $data['duration_minutes'] = (int) round((strtotime($data['end_time']) - strtotime($data['start_time']))/60);
        $log = SleepLog::create($data);
        if (!$log) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Data', 500);
        }

        return ResponseFormatter::success($log, 'Berhasil Menyimpan Data');
    }

    public function edit(SleepLog $log, Request $request)
    {
        if ($request->ajax()) {
            $babies = BabyProfile::orderBy('name')->get(['id','name']);
            return view('admin.sleep.edit', compact('log','babies'));
        }
        return abort(404);
    }

    public function update(Request $request, SleepLog $log)
    {
        $validator = Validator::make($request->all(), [
            'baby_id' => ['required','string','size:36'],
            'start_time' => ['required','date'],
            'end_time' => ['required','date','after:start_time'],
            'notes' => ['nullable','string'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Mengubah Data', 422);
        }

        $data = $validator->validated();
        $data['duration_minutes'] = (int) round((strtotime($data['end_time']) - strtotime($data['start_time']))/60);
        if (!$log->update($data)) {
            return ResponseFormatter::error(null, 'Gagal Mengubah Data', 500);
        }

        return ResponseFormatter::success($log, 'Berhasil Mengubah Data');
    }

    public function destroy(SleepLog $log)
    {
        if (!$log->delete()) {
            return ResponseFormatter::error([], 'Data gagal dihapus', 500);
        }

        return ResponseFormatter::success([], 'Data berhasil dihapus');
    }
}


