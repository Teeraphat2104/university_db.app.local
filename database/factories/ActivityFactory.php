<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'category_id'   => Category::factory(),
            'title'         => fake()->sentence(4),
            'description'   => fake()->paragraph(),
            'cover_image'   => null,
            'pdf_file'      => null,
            'activity_date' => fake()->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
            'location'      => fake()->city(),
            'status'        => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['status' => false]);
    }

    public function withPdf(): static
    {
        return $this->state(['pdf_file' => 'pdfs/test.pdf']);
    }
}
