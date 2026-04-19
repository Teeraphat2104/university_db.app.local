<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name'        => fake()->words(2, true),
            'cover_image' => null,
            'status'      => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['status' => false]);
    }
}
