<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Models\FeedingLog;
use App\Models\BabyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class FeedingLogsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = FeedingLog::query()->with('baby');

            return DataTables::eloquent($query)
                ->addColumn('action', function (FeedingLog $log) {
                    return '
                        <a href="#" data-url="' . route('admin.feeding.edit', $log->id) . '" class="btn btn-warning btn-sm btnn-create"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btnn-delete" data-url="' . route('admin.feeding.destroy', $log->id) . '"><i class="ti ti-trash"></i></button>';
                })
                ->addColumn('baby_name', function (FeedingLog $log) {
                    return optional($log->baby)->name;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $title = 'Feeding Logs';
        $slug = 'feeding';
        return view('admin.feeding.index', compact('slug', 'title'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $babies = BabyProfile::orderBy('name')->get(['id','name']);
            return view('admin.feeding.create', compact('babies'));
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'baby_id' => ['required','string','size:36'],
            'type' => ['required','in:asi_left,asi_right,formula,pump'],
            'start_time' => ['required','date'],
            'duration_minutes' => ['required','integer','min:1'],
            'notes' => ['nullable','string'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Data: ' . $validator->errors()->first(), 422);
        }

        $data = $validator->validated();
        $data['id'] = (string) Str::uuid();
        $log = FeedingLog::create($data);
        if (!$log) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Data', 500);
        }

        return ResponseFormatter::success($log, 'Berhasil Menyimpan Data');
    }

    public function edit(FeedingLog $log, Request $request)
    {
        if ($request->ajax()) {
            $babies = BabyProfile::orderBy('name')->get(['id','name']);
            return view('admin.feeding.edit', compact('log','babies'));
        }
        return abort(404);
    }

    public function update(Request $request, FeedingLog $log)
    {
        $validator = Validator::make($request->all(), [
            'baby_id' => ['required','string','size:36'],
            'type' => ['required','in:asi_left,asi_right,formula,pump'],
            'start_time' => ['required','date'],
            'duration_minutes' => ['required','integer','min:1'],
            'notes' => ['nullable','string'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Mengubah Data', 422);
        }

        $data = $validator->validated();
        if (!$log->update($data)) {
            return ResponseFormatter::error(null, 'Gagal Mengubah Data', 500);
        }

        return ResponseFormatter::success($log, 'Berhasil Mengubah Data');
    }

    public function destroy(FeedingLog $log)
    {
        if (!$log->delete()) {
            return ResponseFormatter::error([], 'Data gagal dihapus', 500);
        }

        return ResponseFormatter::success([], 'Data berhasil dihapus');
    }
}


