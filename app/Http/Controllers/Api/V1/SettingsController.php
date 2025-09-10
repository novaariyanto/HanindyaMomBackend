<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Settings\UpdateSettingsRequest;
use App\Http\Resources\V1\SettingsResource;
use App\Models\SettingsApp;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $settings = SettingsApp::firstOrCreate(
            ['user_uuid' => $user->uuid],
            [
                'id' => (string) Str::uuid(),
                'timezone' => 'Asia/Jakarta',
                'unit' => 'ml',
                'notifications' => true,
            ]
        );

        return ApiResponse::success(new SettingsResource($settings), 'Settings');
    }

    public function update(UpdateSettingsRequest $request)
    {
        $user = auth()->user();
        $settings = SettingsApp::firstOrCreate(
            ['user_uuid' => $user->uuid],
            [
                'id' => (string) Str::uuid(),
                'timezone' => 'Asia/Jakarta',
                'unit' => 'ml',
                'notifications' => true,
            ]
        );

        $settings->update($request->validated());
        return ApiResponse::success(new SettingsResource($settings), 'Settings diperbarui');
    }
}


