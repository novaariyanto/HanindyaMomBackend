<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Growth\StoreGrowthRequest;
use App\Http\Requests\V1\Growth\UpdateGrowthRequest;
use App\Http\Resources\V1\GrowthLogResource;
use App\Models\BabyProfile;
use App\Models\GrowthLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GrowthController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['baby_id' => ['required','string','size:36']]);
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);

        $logs = GrowthLog::where('baby_id', $request->baby_id)
            ->orderByDesc('date')
            ->get();
        return ApiResponse::success(GrowthLogResource::collection($logs), 'Daftar pertumbuhan');
    }

    public function store(StoreGrowthRequest $request)
    {
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);
        $data = $request->validated();
        $log = GrowthLog::create(array_merge($data, [
            'id' => (string) Str::uuid(),
        ]));
        return ApiResponse::success(new GrowthLogResource($log), 'Pertumbuhan ditambahkan');
    }

    public function show(Request $request, string $id)
    {
        $log = GrowthLog::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        return ApiResponse::success(new GrowthLogResource($log), 'Detail pertumbuhan');
    }

    public function update(UpdateGrowthRequest $request, string $id)
    {
        $log = GrowthLog::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        $log->update($request->validated());
        return ApiResponse::success(new GrowthLogResource($log), 'Pertumbuhan diperbarui');
    }

    public function destroy(Request $request, string $id)
    {
        $log = GrowthLog::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        $log->delete();
        return ApiResponse::success(null, 'Pertumbuhan dihapus');
    }

    private function authorizeBaby(string $userUuid, string $babyId): void
    {
        $baby = BabyProfile::where('user_uuid', $userUuid)->where('id', $babyId)->first();
        abort_unless($baby, 404, 'Bayi tidak ditemukan');
    }
}


