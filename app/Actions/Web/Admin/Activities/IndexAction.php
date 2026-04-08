<?php

namespace App\Actions\Web\Admin\Activities;

use App\Models\Activity;
use App\Models\Category;
use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexAction
{
    use ApiResponse;

    public function __invoke(Request $request): View|JsonResponse
    {
        $validated = validator($request->all(), Activity::filterRules(true))->validate();

        $activities = Activity::query()
            ->withPublicRelations()
            ->latest('id')
            ->applyFilters($validated, true)
            ->paginate((int) ($validated['per_page'] ?? 10))
            ->withQueryString();

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([
                'items' => collect($activities->items())
                    ->map(fn (Activity $activity) => $activity->toArray())
                    ->values(),
                'pagination' => [
                    'current_page' => $activities->currentPage(),
                    'last_page' => $activities->lastPage(),
                    'per_page' => $activities->perPage(),
                    'total' => $activities->total(),
                    'next_page_url' => $activities->nextPageUrl(),
                    'previous_page_url' => $activities->previousPageUrl(),
                ],
                'filters' => $validated,
            ], 'Activities fetched successfully.');
        }

        return view('admin.activities.index', [
            'activities' => $activities,
            'categories' => Category::query()->orderBy('category_name')->get(),
            'filters' => $validated,
            'statuses' => Activity::STATUSES,
        ]);
    }
}
