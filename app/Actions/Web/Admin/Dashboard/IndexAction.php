<?php

namespace App\Actions\Web\Admin\Dashboard;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Contracts\View\View;

class IndexAction
{
    public function __invoke(): View
    {
        return view('admin.dashboard.index', [
            'stats' => [
                'total_activities' => Activity::query()->count(),
                'published_activities' => Activity::query()->where('status', 'published')->count(),
                'upcoming_activities' => Activity::query()->whereDate('activity_date', '>=', now()->toDateString())->count(),
                'categories' => Category::query()->count(),
            ],
            'recentActivities' => Activity::query()
                ->with(['category', 'creator'])
                ->latest('id')
                ->take(5)
                ->get(),
        ]);
    }
}
