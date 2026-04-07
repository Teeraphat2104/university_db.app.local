<?php

namespace App\Actions\Web\Public;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Contracts\View\View;

class HomeAction
{
    public function __invoke(): View
    {
        $latestActivities = Activity::query()
            ->with(['category', 'creator', 'document'])
            ->where('status', 'published')
            ->orderBy('activity_date')
            ->paginate(6);

        return view('public.home', [
            'latestActivities' => collect($latestActivities->items()),
            'categories' => Category::query()->orderBy('category_name')->get(),
            'activityCount' => $latestActivities->total(),
        ]);
    }
}
