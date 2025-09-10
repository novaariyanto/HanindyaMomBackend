<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('can get and update settings', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    $this->getJson('/api/v1/settings')->assertStatus(200)->assertJson(['success' => true]);
    $this->putJson('/api/v1/settings', [
        'timezone' => 'Asia/Jakarta',
        'unit' => 'oz',
        'notifications' => false,
    ])->assertStatus(200)->assertJsonPath('data.unit', 'oz');
});

it('can get timeline and dashboard', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    $baby = $this->postJson('/api/v1/babies', [
        'name' => 'Baby A',
        'birth_date' => '2025-01-01',
    ])->json('data');

    $this->getJson('/api/v1/timeline?baby_id='.$baby['id'])->assertStatus(200)->assertJson(['success' => true]);
    $this->getJson('/api/v1/dashboard?baby_id='.$baby['id'].'&range=daily')->assertStatus(200)->assertJson(['success' => true]);
});


