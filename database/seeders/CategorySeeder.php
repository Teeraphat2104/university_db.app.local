<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            'Academic',
            'Volunteer',
            'Sports',
            'Workshop',
            'Career',
        ];

        foreach ($categories as $categoryName) {
            Category::query()->updateOrCreate(
                ['category_name' => $categoryName]
            );
        }
    }
}
