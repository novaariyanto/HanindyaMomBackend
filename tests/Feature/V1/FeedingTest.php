<?php

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;

it('can crud feeding logs', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    // create baby
    $baby = $this->postJson('/api/v1/babies', [
        'name' => 'Baby A',
        'birth_date' => '2025-01-01',
    ])->json('data');

    // create feeding
    $create = $this->postJson('/api/v1/feeding', [
        'baby_id' => $baby['id'],
        'type' => 'formula',
        'start_time' => now()->toIso8601String(),
        'duration_minutes' => 10,
        'notes' => 'ok',
    ]);
    $create->assertStatus(200)->assertJson(['success' => true]);
    $id = $create->json('data.id');

    // index
    $this->getJson('/api/v1/feeding?baby_id='.$baby['id'])
        ->assertStatus(200)
        ->assertJson(['success' => true]);

    // show
    $this->getJson('/api/v1/feeding/'.$id)
        ->assertStatus(200)
        ->assertJson(['success' => true]);

    // update
    $this->putJson('/api/v1/feeding/'.$id, [ 'notes' => 'updated' ])
        ->assertStatus(200)
        ->assertJsonPath('data.notes', 'updated');

    // delete
    $this->deleteJson('/api/v1/feeding/'.$id)
        ->assertStatus(200)
        ->assertJson(['success' => true]);
});


