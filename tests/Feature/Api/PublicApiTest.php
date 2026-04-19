<?php

namespace Tests\Feature\Api;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_returns_stats_and_data(): void
    {
        Category::factory()->count(3)->create();
        Activity::factory()->count(5)->create();

        $response = $this->getJson('/api/public/home');

        $response->assertOk()
                 ->assertJsonPath('success', true)
                 ->assertJsonStructure(['data' => ['categories', 'latest_activities', 'stats']]);
    }

    public function test_categories_returns_only_active(): void
    {
        Category::factory()->count(2)->create();
        Category::factory()->inactive()->count(1)->create();

        $response = $this->getJson('/api/public/categories');

        $response->assertOk()->assertJsonCount(2, 'data');
    }

    public function test_activities_are_paginated(): void
    {
        $category = Category::factory()->create();
        Activity::factory()->count(15)->create(['category_id' => $category->id]);

        $response = $this->getJson('/api/public/activities?per_page=5');

        $response->assertOk()
                 ->assertJsonCount(5, 'data')
                 ->assertJsonPath('meta.total', 15);
    }

    public function test_activities_can_filter_by_keyword(): void
    {
        $category = Category::factory()->create();
        Activity::factory()->create(['category_id' => $category->id, 'title' => 'Swimming Competition']);
        Activity::factory()->create(['category_id' => $category->id, 'title' => 'Art Exhibition']);

        $response = $this->getJson('/api/public/activities?keyword=Swimming');

        $response->assertOk()->assertJsonCount(1, 'data');
    }

    public function test_activities_can_filter_by_category(): void
    {
        $cat1 = Category::factory()->create();
        $cat2 = Category::factory()->create();
        Activity::factory()->count(3)->create(['category_id' => $cat1->id]);
        Activity::factory()->count(2)->create(['category_id' => $cat2->id]);

        $response = $this->getJson("/api/public/activities?category_id={$cat1->id}");

        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_activity_detail_returns_active_activity(): void
    {
        $activity = Activity::factory()->create();

        $response = $this->getJson("/api/public/activities/{$activity->id}");

        $response->assertOk()
                 ->assertJsonPath('success', true)
                 ->assertJsonPath('data.id', $activity->id);
    }

    public function test_activity_detail_returns_404_for_inactive(): void
    {
        $activity = Activity::factory()->inactive()->create();

        $this->getJson("/api/public/activities/{$activity->id}")->assertNotFound();
    }
}
