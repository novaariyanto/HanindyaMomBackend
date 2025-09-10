<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Diaper\StoreDiaperRequest;
use App\Http\Requests\V1\Diaper\UpdateDiaperRequest;
use App\Http\Resources\V1\DiaperLogResource;
use App\Models\BabyProfile;
use App\Models\DiaperLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiaperController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['baby_id' => ['required','string','size:36']]);
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);

        $logs = DiaperLog::where('baby_id', $request->baby_id)
            ->latest('time')
            ->get();
        return ApiResponse::success(DiaperLogResource::collection($logs), 'Daftar diaper');
    }

    public function store(StoreDiaperRequest $request)
    {
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);
        $data = $request->validated();
        $log = DiaperLog::create(array_merge($data, [
            'id' => (string) Str::uuid(),
        ]));
        return ApiResponse::success(new DiaperLogResource($log), 'Diaper ditambahkan');
    }

    public function show(Request $request, string $id)
    {
        $log = DiaperLog::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        return ApiResponse::success(new DiaperLogResource($log), 'Detail diaper');
    }

    public function update(UpdateDiaperRequest $request, string $id)
    {
        $log = DiaperLog::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        $log->update($request->validated());
        return ApiResponse::success(new DiaperLogResource($log), 'Diaper diperbarui');
    }

    public function destroy(Request $request, string $id)
    {
        $log = DiaperLog::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        $log->delete();
        return ApiResponse::success(null, 'Diaper dihapus');
    }

    private function authorizeBaby(string $userUuid, string $babyId): void
    {
        $baby = BabyProfile::where('user_uuid', $userUuid)->where('id', $babyId)->first();
        abort_unless($baby, 404, 'Bayi tidak ditemukan');
    }
}


