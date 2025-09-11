<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Models\VaccineSchedule;
use App\Models\BabyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class VaccineSchedulesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = VaccineSchedule::query()->with('baby');

            return DataTables::eloquent($query)
                ->addColumn('action', function (VaccineSchedule $log) {
                    return '
                        <a href="#" data-url="' . route('admin.vaccines.edit', $log->id) . '" class="btn btn-warning btn-sm btnn-create"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btnn-delete" data-url="' . route('admin.vaccines.destroy', $log->id) . '"><i class="ti ti-trash"></i></button>';
                })
                ->addColumn('baby_name', function (VaccineSchedule $log) {
                    return optional($log->baby)->name;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $title = 'Vaccine Schedules';
        $slug = 'vaccines';
        return view('admin.vaccines.index', compact('slug', 'title'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $babies = BabyProfile::orderBy('name')->get(['id','name']);
            return view('admin.vaccines.create', compact('babies'));
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'baby_id' => ['required','string','size:36'],
            'vaccine_name' => ['required','string','max:150'],
            'schedule_date' => ['required','date'],
            'status' => ['required','in:scheduled,done'],
            'notes' => ['nullable','string'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Data: ' . $validator->errors()->first(), 422);
        }

        $data = $validator->validated();
        $data['id'] = (string) Str::uuid();
        $log = VaccineSchedule::create($data);
        if (!$log) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Data', 500);
        }

        return ResponseFormatter::success($log, 'Berhasil Menyimpan Data');
    }

    public function edit(VaccineSchedule $log, Request $request)
    {
        if ($request->ajax()) {
            $babies = BabyProfile::orderBy('name')->get(['id','name']);
            return view('admin.vaccines.edit', compact('log','babies'));
        }
        return abort(404);
    }

    public function update(Request $request, VaccineSchedule $log)
    {
        $validator = Validator::make($request->all(), [
            'baby_id' => ['required','string','size:36'],
            'vaccine_name' => ['required','string','max:150'],
            'schedule_date' => ['required','date'],
            'status' => ['required','in:scheduled,done'],
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

    public function destroy(VaccineSchedule $log)
    {
        if (!$log->delete()) {
            return ResponseFormatter::error([], 'Data gagal dihapus', 500);
        }

        return ResponseFormatter::success([], 'Data berhasil dihapus');
    }
}


