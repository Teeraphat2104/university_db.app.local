<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ActivityStoreJsonResponseTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_activity_and_receive_json_response(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::query()->create([
            'category_name' => 'Workshop',
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.activities.store'), [
                'title' => 'JSON Response Activity',
                'description' => 'Created through admin web form JSON flow.',
                'category_id' => $category->id,
                'activity_date' => now()->addDay()->toDateString(),
                'location' => 'Room A101',
                'organizer' => 'Student Affairs',
                'status' => 'published',
            ], [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response
            ->assertCreated()
            ->assertJsonPath('status', 201)
            ->assertJsonPath('message', 'Activity created successfully.')
            ->assertJsonPath('data.activity.title', 'JSON Response Activity')
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'activity',
                    'redirect_url',
                ],
            ]);

        $this->assertDatabaseHas('activities', [
            'title' => 'JSON Response Activity',
            'created_by' => $admin->id,
        ]);
    }

    public function test_admin_can_create_activity_through_web_flow(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::query()->create([
            'category_name' => 'Workshop',
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.activities.store'), [
                'title' => 'Web Response Activity',
                'description' => 'Created through standard web flow.',
                'category_id' => $category->id,
                'activity_date' => now()->addDay()->toDateString(),
                'location' => 'Room B202',
                'organizer' => 'Student Affairs',
                'status' => 'published',
            ]);

        $activity = Activity::query()->where('title', 'Web Response Activity')->firstOrFail();

        $response
            ->assertRedirect(route('admin.activities.show', $activity->id))
            ->assertSessionHas('success', 'สร้างกิจกรรมเรียบร้อยแล้ว');
    }

    public function test_admin_create_activity_returns_validation_error_as_json(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.activities.store'), [], [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response
            ->assertStatus(422)
            ->assertJsonPath('status', 422)
            ->assertJsonPath('message', 'The given data was invalid.')
            ->assertJsonStructure([
                'status',
                'message',
                'errors' => [
                    'title',
                    'description',
                    'category_id',
                    'activity_date',
                    'location',
                    'organizer',
                    'status',
                ],
            ]);
    }

    public function test_admin_can_update_activity_and_receive_json_response(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::query()->create([
            'category_name' => 'Volunteer',
        ]);

        $activity = Activity::query()->create([
            'title' => 'Old Title',
            'description' => 'Old description',
            'category_id' => $category->id,
            'activity_date' => now()->addDay()->toDateString(),
            'location' => 'Old location',
            'organizer' => 'Old organizer',
            'status' => 'draft',
            'created_by' => $admin->id,
        ]);

        $response = $this
            ->actingAs($admin)
            ->put(route('admin.activities.update', $activity->id), [
                'title' => 'Updated Title',
                'description' => 'Updated description',
                'category_id' => $category->id,
                'activity_date' => now()->addDays(2)->toDateString(),
                'location' => 'Updated location',
                'organizer' => 'Updated organizer',
                'status' => 'published',
                'document' => UploadedFile::fake()->create('activity.pdf', 100, 'application/pdf'),
            ], [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('status', 200)
            ->assertJsonPath('message', 'Activity updated successfully.')
            ->assertJsonPath('data.activity.title', 'Updated Title')
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'activity',
                    'redirect_url',
                ],
            ]);

        $this->assertDatabaseHas('activities', [
            'id' => $activity->id,
            'title' => 'Updated Title',
            'status' => 'published',
        ]);
    }

    public function test_admin_can_update_activity_through_web_flow(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::query()->create([
            'category_name' => 'Volunteer',
        ]);

        $activity = Activity::query()->create([
            'title' => 'Original Title',
            'description' => 'Original description',
            'category_id' => $category->id,
            'activity_date' => now()->addDay()->toDateString(),
            'location' => 'Original location',
            'organizer' => 'Original organizer',
            'status' => 'draft',
            'created_by' => $admin->id,
        ]);

        $response = $this
            ->actingAs($admin)
            ->put(route('admin.activities.update', $activity->id), [
                'title' => 'Updated Through Web',
                'description' => 'Updated description',
                'category_id' => $category->id,
                'activity_date' => now()->addDays(3)->toDateString(),
                'location' => 'Updated location',
                'organizer' => 'Updated organizer',
                'status' => 'published',
            ]);

        $response
            ->assertRedirect(route('admin.activities.show', $activity->id))
            ->assertSessionHas('success', 'อัปเดตกิจกรรมเรียบร้อยแล้ว');

        $this->assertDatabaseHas('activities', [
            'id' => $activity->id,
            'title' => 'Updated Through Web',
            'status' => 'published',
        ]);
    }

    public function test_admin_can_delete_activity_and_receive_json_response(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::query()->create([
            'category_name' => 'Sports',
        ]);

        $activity = Activity::query()->create([
            'title' => 'Delete Me',
            'description' => 'Delete description',
            'category_id' => $category->id,
            'activity_date' => now()->addDay()->toDateString(),
            'location' => 'Gym',
            'organizer' => 'Sports Club',
            'status' => 'published',
            'created_by' => $admin->id,
        ]);

        $response = $this
            ->actingAs($admin)
            ->delete(route('admin.activities.destroy', $activity->id), [], [
                'Accept' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('status', 200)
            ->assertJsonPath('message', 'Activity deleted successfully.')
            ->assertJsonPath('data.deleted_activity_id', $activity->id)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'deleted_activity_id',
                    'redirect_url',
                ],
            ]);

        $this->assertDatabaseMissing('activities', [
            'id' => $activity->id,
        ]);
    }

    public function test_admin_can_delete_activity_through_web_flow(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $category = Category::query()->create([
            'category_name' => 'Sports',
        ]);

        $activity = Activity::query()->create([
            'title' => 'Delete Through Web',
            'description' => 'Delete description',
            'category_id' => $category->id,
            'activity_date' => now()->addDay()->toDateString(),
            'location' => 'Gym',
            'organizer' => 'Sports Club',
            'status' => 'published',
            'created_by' => $admin->id,
        ]);

        $response = $this
            ->actingAs($admin)
            ->delete(route('admin.activities.destroy', $activity->id));

        $response
            ->assertRedirect(route('admin.activities.index'))
            ->assertSessionHas('success', 'ลบกิจกรรมเรียบร้อยแล้ว');

        $this->assertDatabaseMissing('activities', [
            'id' => $activity->id,
        ]);
    }
}
