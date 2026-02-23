<?php

test('returns a successful response', function () {
    $user = \App\Models\User::factory()->create();

    // Gunakan actingAs karena route '/' sekarang butuh login
    $response = $this->actingAs($user)->get('/');

    $response->assertStatus(200);
});