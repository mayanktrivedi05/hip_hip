<?php

use App\Models\User;

test('admin can access admin dashboard', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin, 'sanctum')->getJson('/api/admin/dashboard');

    $response->assertOk()
        ->assertJson([
            'status' => true,
            'message' => 'Welcome Admin!',
            'data' => [
                'role' => 'admin',
                'scope' => 'admin-access',
            ],
        ]);
});

test('moderator and normal user cannot access admin dashboard', function () {
    $moderator = User::factory()->moderator()->create();
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($moderator, 'sanctum')->getJson('/api/admin/dashboard')
        ->assertForbidden()
        ->assertJson([
            'status' => false,
            'message' => 'Forbidden. You do not have permission to access this resource.',
        ]);

    $this->actingAs($user, 'sanctum')->getJson('/api/admin/dashboard')
        ->assertForbidden()
        ->assertJson([
            'status' => false,
            'message' => 'Forbidden. You do not have permission to access this resource.',
        ]);
});

test('moderator can access moderator dashboard', function () {
    $moderator = User::factory()->moderator()->create();

    $response = $this->actingAs($moderator, 'sanctum')->getJson('/api/moderator/dashboard');

    $response->assertOk()
        ->assertJson([
            'status' => true,
            'message' => 'Welcome Moderator!',
            'data' => [
                'role' => 'moderator',
                'scope' => 'moderator-access',
            ],
        ]);
});

test('normal user cannot access moderator dashboard', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/moderator/dashboard');

    $response->assertForbidden()
        ->assertJson([
            'status' => false,
            'message' => 'Forbidden. You do not have permission to access this resource.',
        ]);
});

test('both admin and moderator can access staff overview', function () {
    $admin = User::factory()->admin()->create();
    $moderator = User::factory()->moderator()->create();
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($admin, 'sanctum')->getJson('/api/staff/overview')->assertOk();
    $this->actingAs($moderator, 'sanctum')->getJson('/api/staff/overview')->assertOk();
    $this->actingAs($user, 'sanctum')->getJson('/api/staff/overview')->assertForbidden();
});

test('normal user can access user dashboard', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/user/dashboard');

    $response->assertOk()
        ->assertJson([
            'status' => true,
            'message' => 'Welcome User!',
            'data' => [
                'role' => 'user',
                'scope' => 'user-access',
            ],
        ]);
});

test('unverified user cannot access verified routes', function () {
    $unverifiedAdmin = User::factory()->admin()->unverified()->create();

    $response = $this->actingAs($unverifiedAdmin, 'sanctum')->getJson('/api/admin/dashboard');

    $response->assertForbidden();
});

test('unauthenticated guest cannot access protected routes', function () {
    $response = $this->getJson('/api/admin/dashboard');

    $response->assertUnauthorized();
});
