<?php

namespace App\Actions\Api\V1\Categories;

use App\Models\Category;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class IndexAction
{
    use ApiResponse;

    public function __invoke(): JsonResponse
    {
        $categories = Category::query()
            ->withCount('activities')
            ->orderBy('category_name')
            ->get()
            ->map(fn (Category $category) => $category->toArray())
            ->values();

        return $this->successResponse($categories, 'Categories fetched successfully.');
    }
}
