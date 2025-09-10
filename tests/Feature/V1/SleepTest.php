<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('can crud sleep logs', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    $baby = $this->postJson('/api/v1/babies', [
        'name' => 'Baby A',
        'birth_date' => '2025-01-01',
    ])->json('data');

    $start = now()->subHours(2)->toIso8601String();
    $end = now()->toIso8601String();
    $create = $this->postJson('/api/v1/sleep', [
        'baby_id' => $baby['id'],
        'start_time' => $start,
        'end_time' => $end,
        'notes' => 'nap',
    ]);
    $create->assertStatus(200)->assertJson(['success' => true]);
    $id = $create->json('data.id');

    $this->getJson('/api/v1/sleep?baby_id='.$baby['id'])->assertStatus(200);
    $this->getJson('/api/v1/sleep/'.$id)->assertStatus(200);
    $this->putJson('/api/v1/sleep/'.$id, [ 'notes' => 'updated' ])->assertStatus(200);
    $this->deleteJson('/api/v1/sleep/'.$id)->assertStatus(200);
});


