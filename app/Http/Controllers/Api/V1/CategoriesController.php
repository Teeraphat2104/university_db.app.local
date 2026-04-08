<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Support\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $categories = Category::query()
            ->withCount('activities')
            ->orderBy('category_name')
            ->get()
            ->map(fn (Category $category) => $category->toArray())
            ->values();

        return $this->successResponse($categories, 'Categories fetched successfully.');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = validator($request->all(), [
            'category_name' => ['required', 'string', 'max:255', Rule::unique('categories', 'category_name')],
        ])->validate();

        $category = Category::query()->create($validated);

        return $this->successResponse($category->toArray(), 'Category created successfully.', 201);
    }

    public function update(Request $request, int $id): JsonResponse
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

    public function destroy(int $id): JsonResponse
    {
        $category = Category::query()->findOrFail($id);

        if ($category->activities()->exists()) {
            return $this->errorResponse(
                'Category deletion failed.',
                'Cannot delete a category that still has activities.',
                409
            );
        }

        $category->delete();

        return $this->successResponse(null, 'Category deleted successfully.');
    }
}