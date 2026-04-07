<?php

namespace App\Actions\Api\V1\Categories;

use App\Models\Category;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateAction
{
    use ApiResponse;

    public function __invoke(Request $request, int $id): JsonResponse
    {
        $validated = validator($request->all(), [
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category_name')->ignore($id),
            ],
        ])->validate();

        $category = Category::query()->findOrFail($id);
        $category->update($validated);

        return $this->successResponse($category->fresh()->toArray(), 'Category updated successfully.');
    }
}
