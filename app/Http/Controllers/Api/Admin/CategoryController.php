<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    /**
     * GET /api/admin/categories
     */
    public function index()
    {
        $categories = $this->categoryService->getAll();

        return ApiResponse::success(
            'Categories fetched successfully',
            CategoryResource::collection($categories)
        );
    }

    /**
     * POST /api/admin/categories
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->create($request->validated());

        return ApiResponse::success(
            'Category created successfully',
            new CategoryResource($category),
            201
        );
    }

    /**
     * GET /api/admin/categories/{id}
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return ApiResponse::success(
            'Category fetched successfully',
            new CategoryResource($category)
        );
    }

    /**
     * PUT /api/admin/categories/{id}
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category = $this->categoryService->update($category, $request->validated());

        return ApiResponse::success(
            'Category updated successfully',
            new CategoryResource($category)
        );
    }

    /**
     * DELETE /api/admin/categories/{id}
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if ($this->categoryService->hasActivities($category)) {
            return ApiResponse::error(
                'Cannot delete category because it has associated activities. Please reassign or delete the activities first.',
                null,
                409
            );
        }

        $this->categoryService->delete($category);

        return ApiResponse::success('Category deleted successfully');
    }
}
