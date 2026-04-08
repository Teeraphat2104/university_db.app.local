<?php

namespace App\Actions\Web\Admin\Activities;

use App\Models\Activity;
use App\Models\Category;
use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateAction
{
    use ApiResponse;

    public function __invoke(Request $request): View|JsonResponse
    {
        $payload = [
            'categories' => Category::query()->orderBy('category_name')->get()->map->toArray()->values(),
            'statuses' => Activity::STATUSES,
        ];

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse($payload, 'Activity form data fetched successfully.');
        }

        return view('admin.activities.create', [
            'categories' => Category::query()->orderBy('category_name')->get(),
            'statuses' => Activity::STATUSES,
        ]);
    }
}
