<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    // Karena '/' sekarang adalah dashboard yang butuh auth
    $this->get('/')->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $this->actingAs($user = User::factory()->create());

    // Panggil '/' bukan '/dashboard'
    $this->get('/')->assertStatus(200);
});