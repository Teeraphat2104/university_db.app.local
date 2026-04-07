<?php

namespace App\Actions\Api\V1\Activities;

use App\Models\Activity;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShowAction
{
    use ApiResponse;

    public function __invoke(Request $request, int $id): JsonResponse
    {
        $query = Activity::query()->with(['category', 'creator', 'document.uploader']);

        if (! ($request->user()?->isAdmin() ?? false)) {
            $query->where('status', 'published');
        }

        $activity = $query->findOrFail($id);

        return $this->successResponse($activity->toArray(), 'Activity fetched successfully.');
    }
}
