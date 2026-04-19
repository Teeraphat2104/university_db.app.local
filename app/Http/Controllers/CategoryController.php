<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * GET /api/admin/categories
     */
    public function index()
    {
        $categories = Category::latest()->get();

        return ApiResponse::success(
            'Categories fetched successfully',
            $categories->map(fn ($cat) => $this->formatCategory($cat))
        );
    }

    /**
     * POST /api/admin/categories
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        $payload = [
            'name'   => $data['name'],
            'status' => $data['status'] ?? 1,
        ];

        if ($request->hasFile('cover_image')) {
            $payload['cover_image'] = $request->file('cover_image')->store('categories', 'public');
        }

        $category = Category::create($payload);

        return ApiResponse::success('Category created successfully', $this->formatCategory($category), 201);
    }

    /**
     * GET /api/admin/categories/{id}
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return ApiResponse::success('Category fetched successfully', $this->formatCategory($category));
    }

    /**
     * PUT /api/admin/categories/{id}
     * Also handles POST with _method=PUT (multipart form-data)
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validated();

        $payload = [
            'name'   => $data['name'],
            'status' => $data['status'] ?? $category->status,
        ];

        // Handle cover image upload (delete old file if exists)
        if ($request->hasFile('cover_image')) {
            if ($category->cover_image) {
                Storage::disk('public')->delete($category->cover_image);
            }
            $payload['cover_image'] = $request->file('cover_image')->store('categories', 'public');
        }

        $category->update($payload);
        $category->refresh();

        return ApiResponse::success('Category updated successfully', $this->formatCategory($category));
    }

    /**
     * DELETE /api/admin/categories/{id}
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category->activities()->exists()) {
            return ApiResponse::error(
                'Cannot delete category because it has associated activities. Please reassign or delete the activities first.',
                null,
                409
            );
        }

        // Delete cover image from storage
        if ($category->cover_image) {
            Storage::disk('public')->delete($category->cover_image);
        }

        $category->delete();

        return ApiResponse::success('Category deleted successfully');
    }

    /**
     * Format category data for JSON response.
     */
    private function formatCategory(Category $category): array
    {
        return [
            'id'              => $category->id,
            'name'            => $category->name,
            'cover_image_url' => $category->cover_image_url,
            'status'          => (int) $category->status,
            'created_at'      => $category->created_at?->format('Y-m-d H:i:s'),
            'updated_at'      => $category->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
