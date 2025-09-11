<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Models\GrowthLog;
use App\Models\BabyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class GrowthLogsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = GrowthLog::query()->with('baby');

            return DataTables::eloquent($query)
                ->addColumn('action', function (GrowthLog $log) {
                    return '
                        <a href="#" data-url="' . route('admin.growth.edit', $log->id) . '" class="btn btn-warning btn-sm btnn-create"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btnn-delete" data-url="' . route('admin.growth.destroy', $log->id) . '"><i class="ti ti-trash"></i></button>';
                })
                ->addColumn('baby_name', function (GrowthLog $log) {
                    return optional($log->baby)->name;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $title = 'Growth Logs';
        $slug = 'growth';
        return view('admin.growth.index', compact('slug', 'title'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $babies = BabyProfile::orderBy('name')->get(['id','name']);
            return view('admin.growth.create', compact('babies'));
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'baby_id' => ['required','string','size:36'],
            'date' => ['required','date'],
            'weight' => ['required','numeric'],
            'height' => ['required','numeric'],
            'head_circumference' => ['nullable','numeric'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Data: ' . $validator->errors()->first(), 422);
        }

        $data = $validator->validated();
        $data['id'] = (string) Str::uuid();
        $log = GrowthLog::create($data);
        if (!$log) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Data', 500);
        }

        return ResponseFormatter::success($log, 'Berhasil Menyimpan Data');
    }

    public function edit(GrowthLog $log, Request $request)
    {
        if ($request->ajax()) {
            $babies = BabyProfile::orderBy('name')->get(['id','name']);
            return view('admin.growth.edit', compact('log','babies'));
        }
        return abort(404);
    }

    public function update(Request $request, GrowthLog $log)
    {
        $validator = Validator::make($request->all(), [
            'baby_id' => ['required','string','size:36'],
            'date' => ['required','date'],
            'weight' => ['required','numeric'],
            'height' => ['required','numeric'],
            'head_circumference' => ['nullable','numeric'],
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

    public function destroy(GrowthLog $log)
    {
        if (!$log->delete()) {
            return ResponseFormatter::error([], 'Data gagal dihapus', 500);
        }

        return ResponseFormatter::success([], 'Data berhasil dihapus');
    }
}


