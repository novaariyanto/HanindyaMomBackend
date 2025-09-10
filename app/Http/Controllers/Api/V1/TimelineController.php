<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\BabyProfile;
use App\Models\DiaperLog;
use App\Models\FeedingLog;
use App\Models\GrowthLog;
use App\Models\SleepLog;
use App\Models\VaccineSchedule;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['baby_id' => ['required','string','size:36']]);
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);

        $feeding = FeedingLog::where('baby_id', $request->baby_id)->get()->map(function ($i) {
            return [
                'type' => 'feeding',
                'time' => optional($i->start_time)->toIso8601String(),
                'notes' => $i->notes,
            ];
        });
        $diapers = DiaperLog::where('baby_id', $request->baby_id)->get()->map(function ($i) {
            return [
                'type' => 'diaper',
                'time' => optional($i->time)->toIso8601String(),
                'notes' => $i->notes,
            ];
        });
        $sleep = SleepLog::where('baby_id', $request->baby_id)->get()->map(function ($i) {
            return [
                'type' => 'sleep',
                'time' => optional($i->start_time)->toIso8601String(),
                'notes' => $i->notes,
            ];
        });
        $growth = GrowthLog::where('baby_id', $request->baby_id)->get()->map(function ($i) {
            return [
                'type' => 'growth',
                'time' => optional($i->date)->toDateString(),
                'notes' => null,
            ];
        });
        $vaccines = VaccineSchedule::where('baby_id', $request->baby_id)->get()->map(function ($i) {
            return [
                'type' => 'vaccine',
                'time' => optional($i->schedule_date)->toDateString(),
                'notes' => $i->notes,
            ];
        });

        $timeline = $feeding
            ->concat($diapers)
            ->concat($sleep)
            ->concat($growth)
            ->concat($vaccines)
            ->sortByDesc('time')
            ->values()
            ->all();

        return ApiResponse::success($timeline, 'Timeline');
    }

    private function authorizeBaby(string $userUuid, string $babyId): void
    {
        $baby = BabyProfile::where('user_uuid', $userUuid)->where('id', $babyId)->first();
        abort_unless($baby, 404, 'Bayi tidak ditemukan');
    }
}


