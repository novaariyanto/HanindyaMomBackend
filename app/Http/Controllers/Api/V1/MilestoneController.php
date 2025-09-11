<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\BabyProfile;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MilestoneController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['baby_id' => ['required','string','size:36']]);
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);

        $items = Milestone::where('baby_id', $request->baby_id)
            ->orderBy('month')
            ->latest('created_at')
            ->get();
        return ApiResponse::success($items, 'Daftar milestones');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'baby_id' => ['required','string','size:36'],
            'month' => ['required','integer','min:0','max:120'],
            'title' => ['required','string','max:255'],
            'description' => ['required','string'],
            'achieved' => ['nullable','boolean'],
            'achieved_at' => ['nullable','date'],
        ]);
        $this->authorizeBaby($request->user()->uuid, $data['baby_id']);
        $item = Milestone::create(array_merge($data, [ 'id' => (string) Str::uuid() ]));
        return ApiResponse::success($item, 'Milestone ditambahkan');
    }

    public function show(Request $request, string $id)
    {
        $item = Milestone::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $item->baby_id);
        return ApiResponse::success($item, 'Detail milestone');
    }

    public function update(Request $request, string $id)
    {
        $item = Milestone::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $item->baby_id);
        $data = $request->validate([
            'month' => ['sometimes','integer','min:0','max:120'],
            'title' => ['sometimes','string','max:255'],
            'description' => ['sometimes','string'],
            'achieved' => ['sometimes','boolean'],
            'achieved_at' => ['sometimes','nullable','date'],
        ]);
        $item->update($data);
        return ApiResponse::success($item, 'Milestone diperbarui');
    }

    public function destroy(Request $request, string $id)
    {
        $item = Milestone::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $item->baby_id);
        $item->delete();
        return ApiResponse::success(null, 'Milestone dihapus');
    }

    private function authorizeBaby(string $userUuid, string $babyId): void
    {
        $baby = BabyProfile::where('user_uuid', $userUuid)->where('id', $babyId)->first();
        abort_unless($baby, 404, 'Bayi tidak ditemukan');
    }
}


