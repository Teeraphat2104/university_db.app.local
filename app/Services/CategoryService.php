<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function getAll()
    {
        return Category::latest()->get();
    }

    public function create(array $data): Category
    {
        return Category::create([
            'name'   => $data['name'],
            'slug'   => Str::slug($data['name']),
            'status' => $data['status'] ?? 1,
        ]);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update([
            'name'   => $data['name'],
            'slug'   => Str::slug($data['name']),
            'status' => $data['status'] ?? $category->status,
        ]);

        return $category->fresh();
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }

    public function hasActivities(Category $category): bool
    {
        return $category->activities()->exists();
    }
}
