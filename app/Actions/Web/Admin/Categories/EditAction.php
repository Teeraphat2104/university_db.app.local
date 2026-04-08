<?php

namespace App\Actions\Web\Admin\Categories;

use App\Models\Category;
use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EditAction
{
    use ApiResponse;

    public function __invoke(Request $request, int $category): View|JsonResponse
    {
        $model = Category::query()
            ->withCount('activities')
            ->findOrFail($category);

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse($model->toArray(), 'Category fetched successfully.');
        }

        return view('admin.categories.edit', [
            'category' => $model,
        ]);
    }
}
