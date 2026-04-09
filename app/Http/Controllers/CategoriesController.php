<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $response = (object) [];

        try {
            $query = Category::query();

            if (!empty($request->search)) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $categories = $query->latest()->paginate(10);

            $data = $categories->map(function ($cat) {
                return $this->formatCategory($cat);
            });

            $response->status = 200;
            $response->message = 'Categories retrieved successfully';
            $response->data = $data;
            $response->pagination = [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'total' => $categories->total(),
            ];
        } catch (\Exception $e) {
            $response->status = 500;
            $response->message = 'Failed to retrieve categories';
            $response->error = $e->getMessage();
        }

        return response()->json($response, $response->status);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'กรุณากรอกชื่อหมวดหมู่',
            'name.unique' => 'ชื่อหมวดหมู่นี้มีอยู่แล้ว',
        ]);

        $response = (object) [];

        try {
            $category = Category::create([
                'name' => $validated['name'],
            ]);

            $response->status = 200;
            $response->message = 'Category created successfully';
            $response->data = $this->formatCategory($category);
        } catch (\Exception $e) {
            $response->status = 500;
            $response->message = 'Failed to create category';
            $response->error = $e->getMessage();
        }

        return response()->json($response, $response->status);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ], [
            'name.required' => 'กรุณากรอกชื่อหมวดหมู่',
            'name.unique' => 'ชื่อหมวดหมู่นี้มีอยู่แล้ว',
        ]);

        $response = (object) [];

        try {
            $category = Category::findOrFail($id);
            $category->update([
                'name' => $validated['name'],
            ]);

            $response->status = 200;
            $response->message = 'Category updated successfully';
            $response->data = $this->formatCategory($category);
        } catch (\Exception $e) {
            $response->status = 500;
            $response->message = 'Failed to update category';
            $response->error = $e->getMessage();
        }

        return response()->json($response, $response->status);
    }

    public function destroy($id)
    {
        $response = (object) [];

        try {
            $category = Category::findOrFail($id);

            if ($category->documents()->count() > 0) {
                $response->status = 400;
                $response->message = 'Cannot delete category with documents';
                return response()->json($response, $response->status);
            }

            $category->delete();

            $response->status = 200;
            $response->message = 'Category deleted successfully';
        } catch (\Exception $e) {
            $response->status = 500;
            $response->message = 'Failed to delete category';
            $response->error = $e->getMessage();
        }

        return response()->json($response, $response->status);
    }

    private function formatCategory($cat)
    {
        return [
            'id' => $cat->id,
            'name' => $cat->name,
            'documents_count' => $cat->documents()->count(),
            'created_at' => $cat->created_at->format('Y-m-d H:i:s'),
        ];
    }
}