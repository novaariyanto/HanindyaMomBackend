<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('can register', function () {
    $payload = [
        'name' => 'Tester',
        'username' => 'tester_'.uniqid(),
        'email' => 'tester'.uniqid().'@mail.test',
        'password' => 'secret123',
    ];

    $response = $this->postJson('/api/v1/auth/register', $payload);
    $response->assertStatus(200)
        ->assertJsonStructure([
            'success', 'message', 'data' => ['token','user' => ['uuid','name','username','email']]
        ]);
});

it('can login and logout', function () {
    $user = User::factory()->create([
        'username' => 'loginuser_'.uniqid(),
        'password' => bcrypt('secret123'),
    ]);

    $login = $this->postJson('/api/v1/auth/login', [
        'username' => $user->email ?? $user->username,
        'password' => 'secret123',
    ]);
    $login->assertStatus(200)
        ->assertJsonStructure(['data' => ['token']]);

    $token = $login->json('data.token');
    $this->withHeader('Authorization', 'Bearer '.$token)
        ->postJson('/api/v1/auth/logout')
        ->assertStatus(200)
        ->assertJson(['success' => true]);
});


