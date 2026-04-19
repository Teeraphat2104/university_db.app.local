<?php

namespace Tests\Feature\Api;

use App\Models\Admin;
use App\Models\Activity;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminActivityTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): self
    {
        $admin = Admin::factory()->create();
        $token = $admin->createToken('test')->plainTextToken;
        return $this->withToken($token);
    }

    public function test_admin_can_list_activities(): void
    {
        Activity::factory()->count(4)->create();

        $this->actingAsAdmin()
             ->getJson('/api/admin/activities')
             ->assertOk()
             ->assertJsonPath('meta.total', 4);
    }

    public function test_admin_can_create_activity(): void
    {
        $category = Category::factory()->create();

        $this->actingAsAdmin()
             ->postJson('/api/admin/activities', [
                 'title'       => 'Test Activity',
                 'category_id' => $category->id,
             ])
             ->assertCreated()
             ->assertJsonPath('data.title', 'Test Activity');
    }

    public function test_create_activity_validates_required_fields(): void
    {
        $this->actingAsAdmin()
             ->postJson('/api/admin/activities', [])
             ->assertStatus(422);
    }

    public function test_create_activity_requires_valid_category(): void
    {
        $this->actingAsAdmin()
             ->postJson('/api/admin/activities', [
                 'title'       => 'Test',
                 'category_id' => 99999,
             ])
             ->assertStatus(422);
    }

    public function test_admin_can_update_activity(): void
    {
        $activity = Activity::factory()->create(['title' => 'Old Title']);

        $this->actingAsAdmin()
             ->putJson("/api/admin/activities/{$activity->id}", [
                 'title'       => 'New Title',
                 'category_id' => $activity->category_id,
             ])
             ->assertOk()
             ->assertJsonPath('data.title', 'New Title');
    }

    public function test_admin_can_delete_activity(): void
    {
        $activity = Activity::factory()->create();

        $this->actingAsAdmin()
             ->deleteJson("/api/admin/activities/{$activity->id}")
             ->assertOk();

        $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
    }

    public function test_activities_can_filter_by_keyword(): void
    {
        $cat = Category::factory()->create();
        Activity::factory()->create(['category_id' => $cat->id, 'title' => 'Basketball Tournament']);
        Activity::factory()->create(['category_id' => $cat->id, 'title' => 'Chess Club']);

        $this->actingAsAdmin()
             ->getJson('/api/admin/activities?keyword=Basketball')
             ->assertOk()
             ->assertJsonPath('meta.total', 1);
    }
}
