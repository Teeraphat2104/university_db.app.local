<?php

namespace Tests\Feature\Api;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login(): void
    {
        $admin = Admin::factory()->create(['password' => bcrypt('secret123')]);

        $response = $this->postJson('/api/admin/login', [
            'email'    => $admin->email,
            'password' => 'secret123',
        ]);

        $response->assertOk()->assertJsonStructure(['data' => ['token', 'admin']]);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $admin = Admin::factory()->create(['password' => bcrypt('secret123')]);

        $this->postJson('/api/admin/login', [
            'email'    => $admin->email,
            'password' => 'wrongpass',
        ])->assertUnauthorized();
    }

    public function test_protected_routes_require_auth(): void
    {
        $this->getJson('/api/admin/categories')->assertUnauthorized();
        $this->getJson('/api/admin/activities')->assertUnauthorized();
        $this->getJson('/api/admin/profile')->assertUnauthorized();
    }

    public function test_admin_can_get_profile(): void
    {
        $admin = Admin::factory()->create();
        $token = $admin->createToken('test')->plainTextToken;

        $this->withToken($token)
             ->getJson('/api/admin/profile')
             ->assertOk()
             ->assertJsonPath('data.email', $admin->email);
    }

    public function test_admin_can_logout(): void
    {
        $admin = Admin::factory()->create();
        $result = $admin->createToken('test');
        $tokenId = $result->accessToken->id;

        $this->withToken($result->plainTextToken)
             ->postJson('/api/admin/logout')
             ->assertOk();

        $this->assertDatabaseMissing('personal_access_tokens', ['id' => $tokenId]);
    }
}
