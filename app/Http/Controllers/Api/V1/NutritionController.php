<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\BabyProfile;
use App\Models\NutritionEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NutritionController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['baby_id' => ['required','string','size:36']]);
        $this->authorizeBaby($request->user()->uuid, $request->baby_id);

        $items = NutritionEntry::where('baby_id', $request->baby_id)
            ->latest('time')
            ->get();
        return ApiResponse::success($items, 'Daftar nutrisi');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'baby_id' => ['required','string','size:36'],
            'time' => ['required','date'],
            'title' => ['required','string','max:255'],
            'notes' => ['nullable','string'],
            'photo' => ['nullable','string','max:255'],
            'photo_file' => ['nullable','image','max:2048'],
        ]);
        $this->authorizeBaby($request->user()->uuid, $data['baby_id']);

        $photoPath = $data['photo'] ?? null;
        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = 'nutrition_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/nutrition');
            if (!is_dir($dest)) { @mkdir($dest, 0775, true); }
            $file->move($dest, $filename);
            $photoPath = 'uploads/nutrition/' . $filename;
        }

        $item = NutritionEntry::create([
            'id' => (string) Str::uuid(),
            'baby_id' => $data['baby_id'],
            'time' => $data['time'],
            'title' => $data['title'],
            'notes' => $data['notes'] ?? null,
            'photo_path' => $photoPath,
        ]);
        return ApiResponse::success($item, 'Entry nutrisi ditambahkan');
    }

    public function show(Request $request, string $id)
    {
        $item = NutritionEntry::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $item->baby_id);
        return ApiResponse::success($item, 'Detail nutrisi');
    }

    public function update(Request $request, string $id)
    {
        $item = NutritionEntry::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $item->baby_id);

        $data = $request->validate([
            'time' => ['sometimes','date'],
            'title' => ['sometimes','string','max:255'],
            'notes' => ['sometimes','nullable','string'],
            'photo' => ['sometimes','nullable','string','max:255'],
            'photo_file' => ['sometimes','nullable','image','max:2048'],
        ]);

        if (array_key_exists('photo', $data)) {
            $item->photo_path = $data['photo'] ?: null;
        }
        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = 'nutrition_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/nutrition');
            if (!is_dir($dest)) { @mkdir($dest, 0775, true); }
            $file->move($dest, $filename);
            $item->photo_path = 'uploads/nutrition/' . $filename;
        }

        $item->fill(collect($data)->except(['photo','photo_file'])->toArray());
        $item->save();

        return ApiResponse::success($item, 'Entry nutrisi diperbarui');
    }

    public function destroy(Request $request, string $id)
    {
        $item = NutritionEntry::findOrFail($id);
        $this->authorizeBaby($request->user()->uuid, $item->baby_id);
        $item->delete();
        return ApiResponse::success(null, 'Entry nutrisi dihapus');
    }

    private function authorizeBaby(string $userUuid, string $babyId): void
    {
        $baby = BabyProfile::where('user_uuid', $userUuid)->where('id', $babyId)->first();
        abort_unless($baby, 404, 'Bayi tidak ditemukan');
    }
}


