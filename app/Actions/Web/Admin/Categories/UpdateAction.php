<?php

namespace App\Actions\Web\Admin\Categories;

use App\Models\Category;
use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateAction
{
    use ApiResponse;

    public function __invoke(Request $request, int $category): JsonResponse|RedirectResponse
    {
        $validated = validator($request->all(), [
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category_name')->ignore($category),
            ],
        ])->validate();

        $model = Category::query()->findOrFail($category);
        $model->update($validated);

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([
                'category' => $model->fresh()->toArray(),
                'redirect_url' => route('admin.categories.index'),
            ], 'Category updated successfully.');
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'อัปเดตหมวดหมู่เรียบร้อยแล้ว');
    }
}
