<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

function authUser(): User {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);
    return $user;
}

it('can crud babies', function () {
    $user = authUser();

    // create
    $create = $this->postJson('/api/v1/babies', [
        'name' => 'Baby A',
        'birth_date' => '2025-01-01',
        'birth_weight' => 3.20,
        'birth_height' => 49.5,
    ]);
    $create->assertStatus(200)->assertJson(['success' => true]);
    $babyId = $create->json('data.id');

    // index
    $this->getJson('/api/v1/babies')
        ->assertStatus(200)
        ->assertJson(['success' => true]);

    // show
    $this->getJson('/api/v1/babies/'.$babyId)
        ->assertStatus(200)
        ->assertJson(['success' => true]);

    // update
    $this->putJson('/api/v1/babies/'.$babyId, [ 'name' => 'Baby B' ])
        ->assertStatus(200)
        ->assertJsonPath('data.name', 'Baby B');

    // delete
    $this->deleteJson('/api/v1/babies/'.$babyId)
        ->assertStatus(200)
        ->assertJson(['success' => true]);
});


