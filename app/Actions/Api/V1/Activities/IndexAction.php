<?php

namespace App\Actions\Api\V1\Activities;

use App\Models\Activity;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexAction
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $validated = validator($request->all(), Activity::filterRules(true))->validate();

        $isAdmin = $request->user()?->isAdmin() ?? false;

        $query = Activity::query()
            ->withApiRelations()
            ->orderBy('activity_date');

        if (! $isAdmin) {
            $query->published();
        }

        $query->applyFilters($validated, $isAdmin);

        $activities = $query->paginate((int) ($validated['per_page'] ?? 10))->withQueryString();

        return $this->successResponse([
            'items' => collect($activities->items())
                ->map(fn (Activity $activity) => $activity->toArray())
                ->values(),
            'pagination' => [
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
                'per_page' => $activities->perPage(),
                'total' => $activities->total(),
            ],
        ], 'Activities fetched successfully.');
    }
}
