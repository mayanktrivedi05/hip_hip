<?php

use App\Models\User;

test('guest can view the login page', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
    $response->assertSee('Investor Login');
});

test('guest can view the registration page', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
    $response->assertSee('Open Investment Account');
});

test('new investor can register successfully', function () {
    $response = $this->post(route('register'), [
        'name' => 'John Investor',
        'email' => 'investor@test.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('user.dashboard'));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'investor@test.com',
        'role' => 'user',
    ]);
});

test('investor can login with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'alice@test.com',
        'password' => 'secret123',
        'role' => 'user',
        
    ]);

    $response = $this->post(route('login'), [
        'email' => 'alice@test.com',
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('user.dashboard'));
    $this->assertAuthenticatedAs($user);
});

test('admin is redirected to admin dashboard upon login', function () {
    $admin = User::factory()->create([
        'email' => 'admin@test.com',
        'password' => 'adminpass123',
        'role' => 'admin',
    ]);

    $response = $this->post(route('login'), [
        'email' => 'admin@test.com',
       
        'password' => 'adminpass123',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($admin);
});

test('standard user cannot access admin dashboard', function () {
    $user = User::factory()->create([
        
        'role' => 'user',
    ]);

    $response = $this->actingAs($user)->get(route('admin.dashboard'));
    
    $response->assertStatus(403);
});

test('admin user can access admin dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('System Analytics & Overview');
});

test('authenticated user can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));
  

    $response->assertRedirect(route('login'));
    $this->assertGuest();
});
