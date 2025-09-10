<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Baby\StoreBabyRequest;
use App\Http\Requests\V1\Baby\UpdateBabyRequest;
use App\Http\Resources\V1\BabyResource;
use App\Models\BabyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BabyController extends Controller
{
    public function index(Request $request)
    {
        $babies = BabyProfile::where('user_uuid', $request->user()->uuid)
            ->latest('created_at')
            ->get();

        return ApiResponse::success(BabyResource::collection($babies), 'Daftar bayi');
    }

    public function store(StoreBabyRequest $request)
    {
        $data = $request->validated();

        $baby = BabyProfile::create(array_merge($data, [
            'id' => (string) Str::uuid(),
            'user_uuid' => $request->user()->uuid,
        ]));

        return ApiResponse::success(new BabyResource($baby), 'Bayi ditambahkan');
    }

    public function show(Request $request, string $id)
    {
        $baby = BabyProfile::where('user_uuid', $request->user()->uuid)->findOrFail($id);
        return ApiResponse::success(new BabyResource($baby), 'Detail bayi');
    }

    public function update(UpdateBabyRequest $request, string $id)
    {
        $baby = BabyProfile::where('user_uuid', $request->user()->uuid)->findOrFail($id);
        $baby->update($request->validated());
        return ApiResponse::success(new BabyResource($baby), 'Bayi diperbarui');
    }

    public function destroy(Request $request, string $id)
    {
        $baby = BabyProfile::where('user_uuid', $request->user()->uuid)->findOrFail($id);
        $baby->delete();
        return ApiResponse::success(null, 'Bayi dihapus');
    }
}


