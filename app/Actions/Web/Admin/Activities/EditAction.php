<?php

namespace App\Actions\Web\Admin\Activities;

use App\Models\Activity;
use App\Models\Category;
use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EditAction
{
    use ApiResponse;

    public function __invoke(Request $request, int $activity): View|JsonResponse
    {
        $model = Activity::query()
            ->with(['category', 'creator', 'document.uploader'])
            ->findOrFail($activity);

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([
                'activity' => $model->toArray(),
                'categories' => Category::query()->orderBy('category_name')->get()->map->toArray()->values(),
                'statuses' => Activity::STATUSES,
            ], 'Activity form data fetched successfully.');
        }

        return view('admin.activities.edit', [
            'activity' => $model,
            'categories' => Category::query()->orderBy('category_name')->get(),
            'statuses' => Activity::STATUSES,
        ]);
    }
}
