<?php

namespace App\Actions\Web\Public\Activities;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IndexAction
{
    public function __invoke(Request $request): View
    {
        $validated = validator($request->all(), [
            'search' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'status' => ['nullable', 'in:'.implode(',', Activity::STATUSES)],
            'activity_date_from' => ['nullable', 'date'],
            'activity_date_to' => ['nullable', 'date', 'after_or_equal:activity_date_from'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ])->validate();

        $query = Activity::query()
            ->with(['category', 'creator', 'document'])
            ->where('status', 'published')
            ->orderBy('activity_date');

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

        if (! empty($validated['activity_date_from'])) {
            $query->whereDate('activity_date', '>=', $validated['activity_date_from']);
        }

        if (! empty($validated['activity_date_to'])) {
            $query->whereDate('activity_date', '<=', $validated['activity_date_to']);
        }

        return view('public.activities.index', [
            'activities' => $query->paginate((int) ($validated['per_page'] ?? 9))->withQueryString(),
            'categories' => Category::query()->orderBy('category_name')->get(),
            'filters' => $validated,
            'pageTitle' => 'กิจกรรมนักศึกษา',
            'pageSubtitle' => 'รวมกิจกรรมที่เปิดรับสมัครและกิจกรรมที่กำลังจะเกิดขึ้น',
            'statuses' => Activity::STATUSES,
        ]);
    }
}
