<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

test('a user can register and receives a token', function () {
    Event::fake([Registered::class]);

    $response = $this->postJson(route('api.register'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertCreated()
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'user' => ['id', 'name', 'email', 'role'],
                'token',
                'token_type',
            ],
        ])
        ->assertJsonPath('data.user.role', 'user');

    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com',
        'role' => 'user',
    ]);

    Event::assertDispatched(Registered::class);
});

test('a user can register with moderator or admin role', function () {
    $response = $this->postJson(route('api.register'), [
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'admin',
    ]);

    $response->assertCreated()
        ->assertJsonPath('data.user.role', 'admin');

    $this->assertDatabaseHas('users', [
        'email' => 'admin@example.com',
        'role' => 'admin',
    ]);
});

test('registration validates input', function () {
    $response = $this->postJson(route('api.register'), []);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['name', 'email', 'password']);
});

test('a user can login and receive a token', function () {
    $user = User::factory()->create([
        'email' => 'jane@example.com',
        'password' => 'secret123',
    ]);

    $response = $this->postJson(route('api.login'), [
        'email' => 'jane@example.com',
        'password' => 'secret123',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'user',
                'token',
                'token_type',
            ],
        ])
        ->assertJsonPath('data.user.email', 'jane@example.com');
});

test('login fails with wrong credentials', function () {
    $user = User::factory()->create([
        'email' => 'jane@example.com',
        'password' => 'secret123',
    ]);

    $response = $this->postJson(route('api.login'), [
        'email' => 'jane@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'status' => false,
            'message' => 'Invalid email or password',
        ]);
});

test('authenticated user can view profile with /api/me', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->getJson(route('api.me'));

    $response->assertOk()
        ->assertJsonPath('data.user.id', $user->id)
        ->assertJsonPath('data.user.email', $user->email);
});

test('authenticated user can logout and revoke token', function () {
    $user = User::factory()->create();
    $token = $user->createToken('test_token');

    $response = $this->withHeader('Authorization', 'Bearer '.$token->plainTextToken)
        ->postJson(route('api.logout'));

    $response->assertOk()
        ->assertJson([
            'status' => true,
            'message' => 'Logged out successfully',
        ]);

    $this->assertDatabaseMissing('personal_access_tokens', [
        'id' => $token->accessToken->id,
    ]);
});

test('user can verify email with signed verification link', function () {
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
    );

    $response = $this->getJson($verificationUrl);

    $response->assertOk()
        ->assertJson([
            'status' => true,
            'message' => 'Email verified successfully',
        ]);

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});
