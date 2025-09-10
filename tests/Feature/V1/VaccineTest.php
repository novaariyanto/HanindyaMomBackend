<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('can crud vaccine schedules', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    $baby = $this->postJson('/api/v1/babies', [
        'name' => 'Baby A',
        'birth_date' => '2025-01-01',
    ])->json('data');

    $create = $this->postJson('/api/v1/vaccines', [
        'baby_id' => $baby['id'],
        'vaccine_name' => 'Hepatitis B',
        'schedule_date' => '2025-09-15',
        'status' => 'scheduled',
    ]);
    $create->assertStatus(200)->assertJson(['success' => true]);
    $id = $create->json('data.id');

    $this->getJson('/api/v1/vaccines?baby_id='.$baby['id'])->assertStatus(200);
    $this->getJson('/api/v1/vaccines/'.$id)->assertStatus(200);
    $this->putJson('/api/v1/vaccines/'.$id, [ 'status' => 'done' ])->assertStatus(200);
    $this->deleteJson('/api/v1/vaccines/'.$id)->assertStatus(200);
});


