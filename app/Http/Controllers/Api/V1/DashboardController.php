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
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'baby_id' => ['required','string','size:36'],
            'range' => ['nullable','in:daily,weekly'],
        ]);
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);

        $range = $request->get('range', 'daily');
        $start = $range === 'weekly' ? Carbon::now()->startOfWeek() : Carbon::today();
        $end = Carbon::now();

        // Feeding
        $feedingQuery = FeedingLog::where('baby_id', $request->baby_id)
            ->whereBetween('start_time', [$start, $end]);
        $feedingCount = $feedingQuery->count();
        $feedingDuration = (int) $feedingQuery->sum('duration_minutes');

        // Sleep
        $sleepQuery = SleepLog::where('baby_id', $request->baby_id)
            ->whereBetween('start_time', [$start, $end]);
        $sleepDuration = (int) $sleepQuery->sum('duration_minutes');

        // Diapers
        $diaperQuery = DiaperLog::where('baby_id', $request->baby_id)
            ->whereBetween('time', [$start, $end]);
        $diaperCounts = [
            'pipis' => (int) (clone $diaperQuery)->where('type','pipis')->count(),
            'pup' => (int) (clone $diaperQuery)->where('type','pup')->count(),
            'campuran' => (int) (clone $diaperQuery)->where('type','campuran')->count(),
        ];

        // Growth last
        $lastGrowth = GrowthLog::where('baby_id', $request->baby_id)
            ->orderByDesc('date')
            ->first();

        // Next vaccine
        $nextVaccine = VaccineSchedule::where('baby_id', $request->baby_id)
            ->where('status','scheduled')
            ->whereDate('schedule_date','>=', Carbon::today())
            ->orderBy('schedule_date')
            ->first();

        $data = [
            'feeding' => [
                'count' => (int) $feedingCount,
                'total_duration_minutes' => (int) $feedingDuration,
            ],
            'sleep' => [
                'total_duration_minutes' => (int) $sleepDuration,
            ],
            'diapers' => $diaperCounts,
            'last_growth' => $lastGrowth ? [
                'date' => optional($lastGrowth->date)->toDateString(),
                'weight' => $lastGrowth->weight,
                'height' => $lastGrowth->height,
            ] : null,
            'next_vaccine' => $nextVaccine ? [
                'vaccine_name' => $nextVaccine->vaccine_name,
                'schedule_date' => optional($nextVaccine->schedule_date)->toDateString(),
            ] : null,
        ];

        return ApiResponse::success($data, 'Dashboard');
    }

    private function authorizeBaby(string $userUuid, string $babyId): void
    {
        $baby = BabyProfile::where('user_uuid', $userUuid)->where('id', $babyId)->first();
        abort_unless($baby, 404, 'Bayi tidak ditemukan');
    }
}


