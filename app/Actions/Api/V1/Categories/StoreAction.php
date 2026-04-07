<?php

namespace App\Actions\Api\V1\Categories;

use App\Models\Category;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreAction
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $validated = validator($request->all(), [
            'category_name' => ['required', 'string', 'max:255', Rule::unique('categories', 'category_name')],
        ])->validate();

        $category = Category::query()->create($validated);

        return $this->successResponse($category->toArray(), 'Category created successfully.', 201);
    }
}
