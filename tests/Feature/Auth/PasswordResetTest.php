<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Notification;

test('reset password link screen can be rendered', function () {
    $response = $this->get(route('password.request'));
    $response->assertStatus(200);
});

// Di dalam file PasswordResetTest.php
test('reset password link can be requested', function () {
    Notification::fake();
    $user = User::factory()->create();

    $this->post('/forgot-password', ['email' => $user->email]);

    // Cek class custom milikmu, bukan class bawaan Laravel
    Notification::assertSentTo($user, ResetPasswordNotification::class);
});

test('reset password screen can be rendered', function () {
    Notification::fake();
    $user = User::factory()->create();
    
    $this->post('/forgot-password', ['email' => $user->email]);

    // PERBAIKAN: Ganti ResetPassword::class jadi ResetPasswordNotification::class
    Notification::assertSentTo($user, ResetPasswordNotification::class, function ($notification) {
        $response = $this->get(route('password.reset', ['token' => $notification->token]));
        $response->assertStatus(200);
        return true;
    });
});

test('password can be reset with valid token', function () {
    Notification::fake();
    $user = User::factory()->create();
    
    $this->post('/forgot-password', ['email' => $user->email]);

    // PERBAIKAN: Ganti ResetPassword::class jadi ResetPasswordNotification::class
    Notification::assertSentTo($user, ResetPasswordNotification::class, function ($notification) use ($user) {
        $response = $this->post(route('password.update'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'new-password123',
            'password_confirmation' => 'new-password123',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('login'));
        return true;
    });
});