<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JsonContractTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_can_return_json_payload(): void
    {
        $this->getJson(route('admin.login'))
            ->assertOk()
            ->assertJsonPath('status', 200)
            ->assertJsonPath('message', 'Login form data fetched successfully.')
            ->assertJsonPath('data.form.action', route('admin.login.store'))
            ->assertJsonPath('data.form.method', 'POST');
    }

    public function test_non_admin_receives_json_forbidden_response_on_admin_route(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($user)
            ->getJson(route('admin.dashboard'))
            ->assertForbidden()
            ->assertJsonPath('status', 403)
            ->assertJsonPath('message', 'Forbidden.')
            ->assertJsonPath('error', 'Admin access only.');
    }

    public function test_missing_admin_activity_returns_json_not_found_response(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->getJson(route('admin.activities.show', 999999))
            ->assertNotFound()
            ->assertJsonPath('status', 404)
            ->assertJsonPath('message', 'Resource not found.');
    }

    public function test_method_not_allowed_returns_json_response(): void
    {
        $this->getJson(route('admin.logout'))
            ->assertStatus(405)
            ->assertJsonPath('status', 405)
            ->assertJsonPath('message', 'Method not allowed.')
            ->assertJsonPath('error', 'The requested HTTP method is not allowed for this resource.');
    }

    public function test_home_search_returns_json_from_same_route(): void
    {
        $category = Category::query()->create([
            'category_name' => 'Workshop',
        ]);

        Activity::query()->create([
            'title' => 'Orientation Workshop',
            'description' => 'Welcome activity for new students.',
            'category_id' => $category->id,
            'activity_date' => now()->addDay()->toDateString(),
            'location' => 'Auditorium',
            'organizer' => 'Student Affairs',
            'status' => 'published',
            'created_by' => User::factory()->create()->id,
        ]);

        Activity::query()->create([
            'title' => 'Draft Workshop',
            'description' => 'Should not appear in public search.',
            'category_id' => $category->id,
            'activity_date' => now()->addDays(2)->toDateString(),
            'location' => 'Room 201',
            'organizer' => 'Student Affairs',
            'status' => 'draft',
            'created_by' => User::factory()->create()->id,
        ]);

        $this->getJson(route('home', ['search' => 'Orientation']))
            ->assertOk()
            ->assertJsonPath('status', 200)
            ->assertJsonPath('data.has_active_filters', true)
            ->assertJsonPath('data.pagination.total', 1)
            ->assertJsonPath('data.items.0.title', 'Orientation Workshop');
    }

    public function test_web_category_delete_conflict_returns_409_json(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::query()->create([
            'category_name' => 'Volunteer',
        ]);

        Activity::query()->create([
            'title' => 'Volunteer Camp',
            'description' => 'Community activity.',
            'category_id' => $category->id,
            'activity_date' => now()->addDay()->toDateString(),
            'location' => 'Community Hall',
            'organizer' => 'Volunteer Club',
            'status' => 'published',
            'created_by' => $admin->id,
        ]);

        $this->actingAs($admin)
            ->deleteJson(route('admin.categories.destroy', $category->id))
            ->assertStatus(409)
            ->assertJsonPath('status', 409)
            ->assertJsonPath('message', 'Category deletion failed.')
            ->assertJsonPath('error', 'Cannot delete a category that still has activities.');
    }

    public function test_api_category_delete_conflict_returns_409_instead_of_422(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::query()->create([
            'category_name' => 'Academic',
        ]);

        Activity::query()->create([
            'title' => 'Academic Seminar',
            'description' => 'Seminar activity.',
            'category_id' => $category->id,
            'activity_date' => now()->addDay()->toDateString(),
            'location' => 'Conference Room',
            'organizer' => 'Academic Affairs',
            'status' => 'published',
            'created_by' => $admin->id,
        ]);

        $this->actingAs($admin)
            ->deleteJson('/api/v1/categories/'.$category->id)
            ->assertStatus(409)
            ->assertJsonPath('status', 409)
            ->assertJsonPath('message', 'Category deletion failed.')
            ->assertJsonPath('error', 'Cannot delete a category that still has activities.');
    }
}
