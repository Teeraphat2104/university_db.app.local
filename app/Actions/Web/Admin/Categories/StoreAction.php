<?php

namespace App\Actions\Web\Admin\Categories;

use App\Models\Category;
use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreAction
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse|RedirectResponse
    {
        $validated = validator($request->all(), [
            'category_name' => ['required', 'string', 'max:255', Rule::unique('categories', 'category_name')],
        ])->validate();

        $category = Category::query()->create($validated);

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([
                'category' => $category->toArray(),
                'redirect_url' => route('admin.categories.index'),
            ], 'Category created successfully.', 201);
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'สร้างหมวดหมู่เรียบร้อยแล้ว');
    }
}
