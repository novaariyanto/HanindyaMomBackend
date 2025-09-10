<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('can crud growth logs', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    $baby = $this->postJson('/api/v1/babies', [
        'name' => 'Baby A',
        'birth_date' => '2025-01-01',
    ])->json('data');

    $create = $this->postJson('/api/v1/growth', [
        'baby_id' => $baby['id'],
        'date' => '2025-09-10',
        'weight' => 6.8,
        'height' => 65.2,
        'head_circumference' => 42.5,
    ]);
    $create->assertStatus(200)->assertJson(['success' => true]);
    $id = $create->json('data.id');

    $this->getJson('/api/v1/growth?baby_id='.$baby['id'])->assertStatus(200);
    $this->getJson('/api/v1/growth/'.$id)->assertStatus(200);
    $this->putJson('/api/v1/growth/'.$id, [ 'weight' => 7.0 ])->assertStatus(200);
    $this->deleteJson('/api/v1/growth/'.$id)->assertStatus(200);
});


