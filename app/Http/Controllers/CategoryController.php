<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $response = (object)[];

        try {
            $categories = Category::orderByDesc('id')->get();

            $response->success = true;
            $response->message = 'Categories fetched successfully';
            $response->data = $categories->map(fn ($cat) => $this->formatCategory($cat));

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function store(Request $request)
    {
        $response = (object)[];

        try {
            $data = $request->validate([
                'name'        => 'required|string|max:255',
                'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'status'      => 'nullable|boolean',
            ]);

            $payload = [
                'name'   => $data['name'],
                'status' => $data['status'] ?? 1,
            ];

            if ($request->hasFile('cover_image')) {
                $payload['cover_image'] = $request->file('cover_image')->store('categories', 'public');
            }

            $category = Category::create($payload);

            $response->success = true;
            $response->message = 'Category created successfully';
            $response->data = $this->formatCategory($category);
            $httpCode = 201;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'Validation failed';
            $response->errors = $e->getMessage();
            $httpCode = 422;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function show(string $id)
    {
        $response = (object)[];

        try {
            $category = Category::findOrFail($id);

            $response->success = true;
            $response->message = 'Category fetched successfully';
            $response->data = $this->formatCategory($category);
            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function update(Request $request, string $id)
    {
        $response = (object)[];

        try {
            $data = $request->validate([
                'name'        => 'required|string|max:255',
                'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'status'      => 'nullable|boolean',
            ]);

            $category = Category::findOrFail($id);

            $payload = [
                'name'   => $data['name'],
                'status' => $data['status'] ?? $category->status,
            ];

            if ($request->hasFile('cover_image')) {
                if ($category->cover_image) {
                    Storage::disk('public')->delete($category->cover_image);
                }
                $payload['cover_image'] = $request->file('cover_image')->store('categories', 'public');
            }

            $category->update($payload);
            $category->refresh();

            $response->success = true;
            $response->message = 'Category updated successfully';
            $response->data = $this->formatCategory($category);
            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'Validation failed';
            $response->errors = $e->getMessage();
            $httpCode = 422;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function destroy(string $id)
    {
        $response = (object)[];

        try {
            $category = Category::findOrFail($id);

            if ($category->activities()->exists()) {
                $response->success = false;
                $response->message = 'Cannot delete category because it has associated activities. Please reassign or delete the activities first.';
                $response->errors = null;
                return response()->json($response, 409);
            }

            if ($category->cover_image) {
                Storage::disk('public')->delete($category->cover_image);
            }

            $category->delete();

            $response->success = true;
            $response->message = 'Category deleted successfully';
            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    private function formatCategory(Category $category): array
    {
        return [
            'id'              => $category->id,
            'name'            => $category->name,
            'cover_image_url' => $category->cover_image_url,
            'status'          => (int) $category->status,
        ];
    }
}
