<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Vaccine\StoreVaccineRequest;
use App\Http\Requests\V1\Vaccine\UpdateVaccineRequest;
use App\Http\Resources\V1\VaccineScheduleResource;
use App\Models\BabyProfile;
use App\Models\VaccineSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VaccineController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['baby_id' => ['required','string','size:36']]);
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);

        $logs = VaccineSchedule::where('baby_id', $request->baby_id)
            ->orderByDesc('schedule_date')
            ->get();
        return ApiResponse::success(VaccineScheduleResource::collection($logs), 'Daftar vaksin');
    }

    public function store(StoreVaccineRequest $request)
    {
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);
        $data = $request->validated();
        $log = VaccineSchedule::create(array_merge($data, [
            'id' => (string) Str::uuid(),
        ]));
        return ApiResponse::success(new VaccineScheduleResource($log), 'Vaksin ditambahkan');
    }

    public function show(Request $request, string $id)
    {
        $log = VaccineSchedule::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        return ApiResponse::success(new VaccineScheduleResource($log), 'Detail vaksin');
    }

    public function update(UpdateVaccineRequest $request, string $id)
    {
        $log = VaccineSchedule::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        $log->update($request->validated());
        return ApiResponse::success(new VaccineScheduleResource($log), 'Vaksin diperbarui');
    }

    public function destroy(Request $request, string $id)
    {
        $log = VaccineSchedule::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $log->baby_id);
        $log->delete();
        return ApiResponse::success(null, 'Vaksin dihapus');
    }

    private function authorizeBaby(string $userUuid, string $babyId): void
    {
        $baby = BabyProfile::where('user_uuid', $userUuid)->where('id', $babyId)->first();
        abort_unless($baby, 404, 'Bayi tidak ditemukan');
    }
}


