<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_login_refresh_logout_me()
    {
        // Register
        $registerData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $res = $this->postJson('/api/auth/register', $registerData);
        // Simpan respons ke file untuk debugging jika diperlukan
        file_put_contents(storage_path('logs/test_register_response.json'), $res->getContent());
        $res->assertStatus(201);
        $token = $res->json('data.token') ?? $res->json('original.data.token');
        $this->assertNotEmpty($token, 'Register did not return token');

        // Me
        $resMe = $this->withHeader('Authorization', 'Bearer '.$token)->getJson('/api/auth/me');
        $resMe->assertStatus(200);
        $email = $resMe->json('data.email') ?? $resMe->json('original.data.email');
        $this->assertSame('test@example.com', $email);

        // Refresh
        $resRefresh = $this->withHeader('Authorization', 'Bearer '.$token)->postJson('/api/auth/refresh');
        $resRefresh->assertStatus(200);
        $newToken = $resRefresh->json('data.token') ?? $resRefresh->json('original.data.token');
        $this->assertNotEmpty($newToken, 'Refresh did not return token');

        // Logout
        $resLogout = $this->withHeader('Authorization', 'Bearer '.$newToken)->postJson('/api/auth/logout');
        $resLogout->assertStatus(200);
    }

    public function test_login_with_existing_user()
    {
        $user = User::factory()->create(['email' => 'existing@example.com']);

        $res = $this->postJson('/api/auth/login', [
            'email' => 'existing@example.com',
            'password' => 'password',
        ]);

        $res->assertStatus(200);
        $this->assertNotEmpty($res->json('data.token') ?? $res->json('original.data.token'), 'Login did not return token');
    }
}
