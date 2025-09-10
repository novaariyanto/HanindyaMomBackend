<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sleep\StoreSleepRequest;
use App\Http\Requests\V1\Sleep\UpdateSleepRequest;
use App\Http\Resources\V1\SleepLogResource;
use App\Models\BabyProfile;
use App\Models\SleepLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SleepController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['baby_id' => ['required','string','size:36']]);
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);

        $logs = SleepLog::where('baby_id', $request->baby_id)
            ->latest('start_time')
            ->get();
        return ApiResponse::success(SleepLogResource::collection($logs), 'Daftar tidur');
    }

    public function store(StoreSleepRequest $request)
    {
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);
        $data = $request->validated();
        $duration = (int) round((strtotime($data['end_time']) - strtotime($data['start_time'])) / 60);
        $log = SleepLog::create(array_merge($data, [
            'id' => (string) Str::uuid(),
            'duration_minutes' => max($duration, 0),
        ]));
        return ApiResponse::success(new SleepLogResource($log), 'Tidur ditambahkan');
    }

    public function show(Request $request, string $id)
    {
        $log = SleepLog::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        return ApiResponse::success(new SleepLogResource($log), 'Detail tidur');
    }

    public function update(UpdateSleepRequest $request, string $id)
    {
        $log = SleepLog::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        $data = $request->validated();
        if (isset($data['start_time']) || isset($data['end_time'])) {
            $start = $data['start_time'] ?? $log->start_time;
            $end = $data['end_time'] ?? $log->end_time;
            $data['duration_minutes'] = (int) round((strtotime($end) - strtotime($start)) / 60);
            if ($data['duration_minutes'] < 0) {
                $data['duration_minutes'] = 0;
            }
        }
        $log->update($data);
        return ApiResponse::success(new SleepLogResource($log), 'Tidur diperbarui');
    }

    public function destroy(Request $request, string $id)
    {
        $log = SleepLog::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        $log->delete();
        return ApiResponse::success(null, 'Tidur dihapus');
    }

    private function authorizeBaby(string $userUuid, string $babyId): void
    {
        $baby = BabyProfile::where('user_uuid', $userUuid)->where('id', $babyId)->first();
        abort_unless($baby, 404, 'Bayi tidak ditemukan');
    }
}


