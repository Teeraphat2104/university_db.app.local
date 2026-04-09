<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            $categories->map(fn ($cat) => [
                'id'         => $cat->id,
                'name'       => $cat->name,
                'status'     => (int) $cat->status,
                'created_at' => $cat->created_at?->format('Y-m-d H:i:s'),
                'updated_at' => $cat->updated_at?->format('Y-m-d H:i:s'),
            ])
        );
    }

    /**
     * POST /api/admin/categories
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422);
        }

        $data = $validator->validated();

        $category = Category::create([
            'name'   => $data['name'],
            'status' => $data['status'] ?? 1,
        ]);

        return ApiResponse::success('Category created successfully', [
            'id'         => $category->id,
            'name'       => $category->name,
            'status'     => (int) $category->status,
            'created_at' => $category->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $category->updated_at?->format('Y-m-d H:i:s'),
        ], 201);
    }

    /**
     * GET /api/admin/categories/{id}
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return ApiResponse::success('Category fetched successfully', [
            'id'         => $category->id,
            'name'       => $category->name,
            'status'     => (int) $category->status,
            'created_at' => $category->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $category->updated_at?->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * PUT /api/admin/categories/{id}
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422);
        }

        $data = $validator->validated();

        $category->update([
            'name'   => $data['name'],
            'status' => $data['status'] ?? $category->status,
        ]);

        $category->refresh();

        return ApiResponse::success('Category updated successfully', [
            'id'         => $category->id,
            'name'       => $category->name,
            'status'     => (int) $category->status,
            'created_at' => $category->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $category->updated_at?->format('Y-m-d H:i:s'),
        ]);
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

        $category->delete();

        return ApiResponse::success('Category deleted successfully');
    }
}
