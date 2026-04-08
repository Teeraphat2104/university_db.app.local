<?php

namespace App\Actions\Web\Admin\Dashboard;

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
        $stats = [
            'total_activities' => Activity::query()->count(),
            'published_activities' => Activity::query()->published()->count(),
            'upcoming_activities' => Activity::query()->whereDate('activity_date', '>=', now()->toDateString())->count(),
            'categories' => Category::query()->count(),
        ];

        $recentActivities = Activity::query()
            ->withPublicRelations()
            ->latest('id')
            ->take(5)
            ->get();

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([
                'stats' => $stats,
                'recent_activities' => $recentActivities->map->toArray()->values(),
            ], 'Dashboard fetched successfully.');
        }

        return view('admin.dashboard.index', [
            'stats' => $stats,
            'recentActivities' => $recentActivities,
        ]);
    }
}
