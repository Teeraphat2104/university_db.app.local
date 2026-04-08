<?php

namespace App\Actions\Web\Public\Activities;

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
            ->withPublicRelations()
            ->published()
            ->findOrFail($activity);

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse($model->toArray(), 'Activity fetched successfully.');
        }

        return view('public.activities.show', [
            'activity' => $model,
        ]);
    }
}
