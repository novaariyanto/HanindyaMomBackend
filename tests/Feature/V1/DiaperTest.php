<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('can crud diaper logs', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    $baby = $this->postJson('/api/v1/babies', [
        'name' => 'Baby A',
        'birth_date' => '2025-01-01',
    ])->json('data');

    $create = $this->postJson('/api/v1/diapers', [
        'baby_id' => $baby['id'],
        'type' => 'pup',
        'time' => now()->toIso8601String(),
        'color' => 'kuning',
        'texture' => 'lembek',
    ]);
    $create->assertStatus(200)->assertJson(['success' => true]);
    $id = $create->json('data.id');

    $this->getJson('/api/v1/diapers?baby_id='.$baby['id'])->assertStatus(200);
    $this->getJson('/api/v1/diapers/'.$id)->assertStatus(200);
    $this->putJson('/api/v1/diapers/'.$id, [ 'notes' => 'ok' ])->assertStatus(200);
    $this->deleteJson('/api/v1/diapers/'.$id)->assertStatus(200);
});


