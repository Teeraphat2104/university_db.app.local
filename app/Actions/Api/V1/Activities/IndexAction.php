<?php

namespace App\Actions\Api\V1\Activities;

use App\Models\Activity;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IndexAction
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $validated = validator($request->all(), [
            'search' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'status' => ['nullable', Rule::in(Activity::STATUSES)],
            'activity_date_from' => ['nullable', 'date'],
            'activity_date_to' => ['nullable', 'date', 'after_or_equal:activity_date_from'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ])->validate();

        $isAdmin = $request->user()?->isAdmin() ?? false;

        $query = Activity::query()
            ->with(['category', 'creator', 'document.uploader'])
            ->orderBy('activity_date');

        if (! $isAdmin) {
            $query->where('status', 'published');
        }

        if (! empty($validated['search'])) {
            $search = $validated['search'];

            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('organizer', 'like', "%{$search}%");
            });
        }

        if (! empty($validated['category_id'])) {
            $query->where('category_id', $validated['category_id']);
        }

        if ($isAdmin && ! empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (! empty($validated['activity_date_from'])) {
            $query->whereDate('activity_date', '>=', $validated['activity_date_from']);
        }

        if (! empty($validated['activity_date_to'])) {
            $query->whereDate('activity_date', '<=', $validated['activity_date_to']);
        }

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
