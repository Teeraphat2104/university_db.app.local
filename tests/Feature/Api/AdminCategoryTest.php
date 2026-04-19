<?php

namespace Tests\Feature\Api;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): self
    {
        $admin = Admin::factory()->create();
        $token = $admin->createToken('test')->plainTextToken;
        return $this->withToken($token);
    }

    public function test_admin_can_list_categories(): void
    {
        Category::factory()->count(3)->create();

        $this->actingAsAdmin()
             ->getJson('/api/admin/categories')
             ->assertOk()
             ->assertJsonCount(3, 'data');
    }

    public function test_admin_can_create_category(): void
    {
        $this->actingAsAdmin()
             ->postJson('/api/admin/categories', ['name' => 'Sports'])
             ->assertCreated()
             ->assertJsonPath('data.name', 'Sports');

        $this->assertDatabaseHas('categories', ['name' => 'Sports']);
    }

    public function test_create_category_requires_name(): void
    {
        $this->actingAsAdmin()
             ->postJson('/api/admin/categories', [])
             ->assertStatus(422)
             ->assertJsonPath('success', false);
    }

    public function test_admin_can_update_category(): void
    {
        $category = Category::factory()->create(['name' => 'Old Name']);

        $this->actingAsAdmin()
             ->putJson("/api/admin/categories/{$category->id}", ['name' => 'New Name'])
             ->assertOk()
             ->assertJsonPath('data.name', 'New Name');
    }

    public function test_admin_can_delete_category(): void
    {
        $category = Category::factory()->create();

        $this->actingAsAdmin()
             ->deleteJson("/api/admin/categories/{$category->id}")
             ->assertOk();

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_cannot_delete_category_with_activities(): void
    {
        $category = Category::factory()->create();
        Activity::factory()->create(['category_id' => $category->id]);

        $this->actingAsAdmin()
             ->deleteJson("/api/admin/categories/{$category->id}")
             ->assertStatus(409);
    }
}
