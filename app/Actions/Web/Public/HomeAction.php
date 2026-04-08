<?php

namespace App\Actions\Web\Public;

use App\Models\Activity;
use App\Models\Category;
use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeAction
{
    use ApiResponse;

    public function __invoke(Request $request): View|JsonResponse
    {
        $validated = validator($request->all(), Activity::filterRules())->validate();

        $hasActiveFilters = collect($validated)
            ->only(['search', 'category_id', 'activity_date_from', 'activity_date_to'])
            ->filter(fn ($value) => filled($value))
            ->isNotEmpty();

        $activities = null;

        if ($hasActiveFilters) {
            $activities = Activity::query()
                ->withPublicRelations()
                ->published()
                ->orderBy('activity_date')
                ->applyFilters($validated)
                ->paginate((int) ($validated['per_page'] ?? 6))
                ->withQueryString();
        }

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([
                'items' => collect($activities?->items() ?? [])
                    ->map(fn (Activity $activity) => $activity->toArray())
                    ->values(),
                'pagination' => [
                    'current_page' => $activities?->currentPage() ?? 1,
                    'last_page' => $activities?->lastPage() ?? 1,
                    'per_page' => $activities?->perPage() ?? (int) ($validated['per_page'] ?? 6),
                    'total' => $activities?->total() ?? 0,
                    'next_page_url' => $activities?->nextPageUrl(),
                    'previous_page_url' => $activities?->previousPageUrl(),
                ],
                'filters' => $validated,
                'has_active_filters' => $hasActiveFilters,
                'categories' => Category::query()->orderBy('category_name')->get()->map->toArray()->values(),
            ], 'Activities fetched successfully.');
        }

        return view('public.home', [
            'activities' => $activities,
            'categories' => Category::query()->orderBy('category_name')->get(),
            'activityCount' => Activity::query()->published()->count(),
            'filters' => $validated,
            'hasActiveFilters' => $hasActiveFilters,
        ]);
    }
}
