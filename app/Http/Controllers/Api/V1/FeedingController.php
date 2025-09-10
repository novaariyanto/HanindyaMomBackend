<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Feeding\StoreFeedingRequest;
use App\Http\Requests\V1\Feeding\UpdateFeedingRequest;
use App\Http\Resources\V1\FeedingLogResource;
use App\Models\BabyProfile;
use App\Models\FeedingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FeedingController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['baby_id' => ['required','string','size:36']]);
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);

        $logs = FeedingLog::where('baby_id', $request->baby_id)
            ->latest('start_time')
            ->get();
        return ApiResponse::success(FeedingLogResource::collection($logs), 'Daftar feeding');
    }

    public function store(StoreFeedingRequest $request)
    {
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);
        $data = $request->validated();
        $log = FeedingLog::create(array_merge($data, [
            'id' => (string) Str::uuid(),
        ]));
        return ApiResponse::success(new FeedingLogResource($log), 'Feeding ditambahkan');
    }

    public function show(Request $request, string $id)
    {
        $log = FeedingLog::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        return ApiResponse::success(new FeedingLogResource($log), 'Detail feeding');
    }

    public function update(UpdateFeedingRequest $request, string $id)
    {
        $log = FeedingLog::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        $log->update($request->validated());
        return ApiResponse::success(new FeedingLogResource($log), 'Feeding diperbarui');
    }

    public function destroy(Request $request, string $id)
    {
        $log = FeedingLog::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        $log->delete();
        return ApiResponse::success(null, 'Feeding dihapus');
    }

    private function authorizeBaby(string $userUuid, string $babyId): void
    {
        $baby = BabyProfile::where('user_uuid', $userUuid)->where('id', $babyId)->first();
        abort_unless($baby, 404, 'Bayi tidak ditemukan');
    }
}


