<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BabyProfile;
use App\Models\FeedingLog;
use App\Models\DiaperLog;
use App\Models\SleepLog;
use App\Models\VaccineSchedule;
use App\Models\GrowthLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = [Carbon::today(), Carbon::tomorrow()];

        $summary = [
            'total_users' => User::count(),
            'total_babies' => BabyProfile::count(),
            'feeding_today' => FeedingLog::whereBetween('start_time', $today)->count(),
            'diaper_today' => DiaperLog::whereBetween('time', $today)->count(),
            'sleep_today' => SleepLog::whereBetween('start_time', $today)->count(),
            'next_vaccine' => VaccineSchedule::where('status','scheduled')->whereDate('schedule_date','>=', Carbon::today())->orderBy('schedule_date')->first(),
        ];

        $latestTimeline = collect()
            ->concat(FeedingLog::orderByDesc('start_time')->limit(10)->get()->map(fn($i)=>['type'=>'feeding','time'=>$i->start_time,'notes'=>$i->notes]))
            ->concat(DiaperLog::orderByDesc('time')->limit(10)->get()->map(fn($i)=>['type'=>'diaper','time'=>$i->time,'notes'=>$i->notes]))
            ->concat(SleepLog::orderByDesc('start_time')->limit(10)->get()->map(fn($i)=>['type'=>'sleep','time'=>$i->start_time,'notes'=>$i->notes]))
            ->sortByDesc('time')->values()->take(10);

        // Growth chart data (last 12 points overall)
        $growth = GrowthLog::orderBy('date')->limit(12)->get(['date','weight','height']);

        return view('admin.dashboard', compact('summary','latestTimeline','growth'));
    }
}


