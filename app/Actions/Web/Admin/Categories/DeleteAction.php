<?php

namespace App\Actions\Web\Admin\Categories;

use App\Models\Category;
use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeleteAction
{
    use ApiResponse;

    public function __invoke(Request $request, int $category): JsonResponse|RedirectResponse
    {
        $model = Category::query()->withCount('activities')->findOrFail($category);

        if ($model->activities_count > 0) {
            if (JsonRequest::wantsJson($request)) {
                return $this->errorResponse(
                    'Category deletion failed.',
                    'Cannot delete a category that still has activities.',
                    409
                );
            }

            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'ไม่สามารถลบหมวดหมู่ที่มีการใช้งานอยู่ได้');
        }

        $model->delete();

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([
                'deleted_category_id' => $category,
                'redirect_url' => route('admin.categories.index'),
            ], 'Category deleted successfully.');
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'ลบหมวดหมู่เรียบร้อยแล้ว');
    }
}
