<?php

namespace App\Actions\Web\Admin\Activities;

use App\Models\Activity;
use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowAction
{
    use ApiResponse;

    public function __invoke(Request $request, int $activity): View|JsonResponse
    {
        $model = Activity::query()
            ->with(['category', 'creator', 'document.uploader'])
            ->findOrFail($activity);

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse($model->toArray(), 'Activity fetched successfully.');
        }

        return view('admin.activities.show', [
            'activity' => $model,
        ]);
    }
}
