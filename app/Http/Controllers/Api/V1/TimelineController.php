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
use App\Models\NutritionEntry;
use App\Models\Milestone;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['baby_id' => ['required','string','size:36']]);
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);

        $feeding = FeedingLog::where('baby_id', $request->baby_id)->get()->map(function ($i) {
            return [
                'id' => $i->id,
                'type' => 'feeding',
                'time' => optional($i->start_time)->toIso8601String(),
                'notes' => "type: " . $i->type,
            ];
        });
        $diapers = DiaperLog::where('baby_id', $request->baby_id)->get()->map(function ($i) {
            return [
                'id' => $i->id,
                'type' => 'diaper',
                'time' => optional($i->time)->toIso8601String(),
                'notes' => "type: " . $i->type,
            ];
        });
        $sleep = SleepLog::where('baby_id', $request->baby_id)->get()->map(function ($i) {
            return [
                'id' => $i->id,
                'type' => 'sleep',
                'time' => optional($i->start_time)->toIso8601String(),
                'notes' => "duration: " . $i->duration_minutes . " minutes",
            ];
        });
        $growth = GrowthLog::where('baby_id', $request->baby_id)->get()->map(function ($i) {
            return [
                'id' => $i->id,
                'type' => 'growth',
                'time' => optional($i->date)->toIso8601String(),
                'notes' => "weight: " . $i->weight . " kg, height: " . $i->height . " cm",
            ];
        });
        $nutrition = NutritionEntry::where('baby_id', $request->baby_id)->get()->map(function ($i) {
            return [
                'id' => $i->id,
                'type' => 'nutrition',
                'time' => optional($i->time)->toIso8601String(),
                'notes' => "title: " . $i->title ." , notes: " . $i->notes,
            ];
        });
        $milestones = Milestone::where('baby_id', $request->baby_id)->get()->map(function ($i) {
            return [
                'id' => $i->id,
                'type' => 'milestone',
                'time' => optional($i->achieved_at)->toIso8601String(),
                'notes' => $i->description."",
            ];
        });
        $vaccines = VaccineSchedule::where('baby_id', $request->baby_id)->get()->map(function ($i) {
            return [
                'id' => $i->id,
                'type' => 'vaccine',
                'time' => optional($i->schedule_date)->toIso8601String(),
                'notes' => "" . $i->vaccine_name,
            ];
        });
      
        $timeline = $feeding
            ->concat($diapers)
            ->concat($sleep)
            ->concat($growth)
            ->concat($vaccines)
            ->concat($milestones)
            ->concat($nutrition)
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


