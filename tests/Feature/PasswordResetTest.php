<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

test('forgot password screen can be rendered', function () {
    $response = $this->get(route('password.request'));

    $response->assertStatus(200);
    $response->assertSee('Reset Password');
});

test('login page contains link to forgot password', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
    $response->assertSee(route('password.request'));
    $response->assertSee('Forgot password?');
});

test('password reset link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create([
        'email' => 'investor@test.com',
    ]);

    $response = $this->post(route('password.email'), [
        'email' => 'investor@test.com',
    ]);

    Notification::assertSentTo($user, ResetPasswordNotification::class);
    $response->assertSessionHas('success');
});

test('reset password screen can be rendered with token', function () {
    $user = User::factory()->create();
    $token = Password::createToken($user);

    $response = $this->get(route('password.reset', [
        'token' => $token,
        'email' => $user->email,
    ]));

    $response->assertStatus(200);
    $response->assertSee('Create New Password');
    $response->assertSee($token);
});

test('password can be reset with valid token', function () {
    $user = User::factory()->create([
        'password' => Hash::make('old-password'),
    ]);

    $token = Password::createToken($user);

    $response = $this->post(route('password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'new-password-123',
        'password_confirmation' => 'new-password-123',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHas('success');

    $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
});
