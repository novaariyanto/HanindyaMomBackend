<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Models\BabyProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BabiesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = BabyProfile::query()->with('user');

            return DataTables::eloquent($query)
                ->addColumn('action', function (BabyProfile $baby) {
                    return '
                        <a href="' . route('admin.babies.show', $baby->id) . '" class="btn btn-info btn-sm"><i class="ti ti-eye"></i></a>
                        <a href="#" data-url="' . route('admin.babies.edit', $baby->id) . '" class="btn btn-warning btn-sm btnn-create"><i class="ti ti-pencil"></i></a>
                        <button class="btn btn-danger btn-sm btnn-delete" data-url="' . route('admin.babies.destroy', $baby->id) . '"><i class="ti ti-trash"></i></button>';
                })
                ->addColumn('parent', function (BabyProfile $baby) {
                    return optional($baby->user)->name;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $title = 'Baby Management';
        $slug = 'babies';
        return view('admin.babies.index', compact('slug', 'title'));
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $users = User::orderBy('name')->get(['uuid','name']);
            return view('admin.babies.create', compact('users'));
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_uuid' => ['required','string','size:36'],
            'name' => ['required','string','max:100'],
            'birth_date' => ['required','date'],
            'photo' => ['nullable','string'],
            'birth_weight' => ['nullable','numeric'],
            'birth_height' => ['nullable','numeric'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Menyimpan Data: ' . $validator->errors()->first(), 422);
        }

        $data = $validator->validated();
        $data['id'] = (string) Str::uuid();

        $baby = BabyProfile::create($data);
        if (!$baby) {
            return ResponseFormatter::error(null, 'Gagal Menyimpan Data', 500);
        }

        return ResponseFormatter::success($baby, 'Berhasil Menyimpan Data');
    }

    public function show(BabyProfile $baby)
    {
        $baby->load(['feedingLogs','diaperLogs','sleepLogs','growthLogs','vaccineSchedules']);
        return view('admin.babies.show', compact('baby'));
    }

    public function edit(BabyProfile $baby, Request $request)
    {
        if ($request->ajax()) {
            $users = User::orderBy('name')->get(['uuid','name']);
            return view('admin.babies.edit', compact('baby','users'));
        }
        return abort(404);
    }

    public function update(Request $request, BabyProfile $baby)
    {
        $validator = Validator::make($request->all(), [
            'user_uuid' => ['required','string','size:36'],
            'name' => ['required','string','max:100'],
            'birth_date' => ['required','date'],
            'photo' => ['nullable','string'],
            'birth_weight' => ['nullable','numeric'],
            'birth_height' => ['nullable','numeric'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Gagal Mengubah Data', 422);
        }

        $data = $validator->validated();
        if (!$baby->update($data)) {
            return ResponseFormatter::error(null, 'Gagal Mengubah Data', 500);
        }

        return ResponseFormatter::success($baby, 'Berhasil Mengubah Data');
    }

    public function destroy(BabyProfile $baby)
    {
        if (!$baby->delete()) {
            return ResponseFormatter::error([], 'Data gagal dihapus', 500);
        }

        return ResponseFormatter::success([], 'Data berhasil dihapus');
    }
}


