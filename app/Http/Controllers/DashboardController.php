<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityParticipant;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $response = (object)[];

        try {
            $stats = [
                'total_activities'   => Activity::count(),
                'total_categories'   => Category::count(),
                'total_participants' => ActivityParticipant::count(),
                'total_documents'    => Activity::whereNotNull('pdf_file')->count(),
                'total_views'        => (int) Activity::sum('view_count'),
                'total_downloads'    => (int) Activity::sum('download_count'),
            ];

            $todayActivities = Activity::whereDate('activity_date', today())->count();

            $recentActivities = Activity::with('category')
                ->latest('id')
                ->limit(5)
                ->get()
                ->map(fn ($a) => [
                    'id'                => $a->id,
                    'title'             => $a->title,
                    'category_name'     => $a->category?->name,
                    'activity_date'     => $a->activity_date?->format('Y-m-d'),
                    'participants_count'=> $a->participants_count ?? 0,
                    'status'            => (int) $a->status,
                ]);

            $categoryStats = Category::withCount('activities')
                ->orderByDesc('activities_count')
                ->get()
                ->map(fn ($c) => [
                    'id'   => $c->id,
                    'name' => $c->name,
                    'count'=> $c->activities_count,
                ]);

            $mostViewed = Activity::where('view_count', '>', 0)
                ->orderByDesc('view_count')
                ->limit(5)
                ->get(['id', 'title', 'view_count'])
                ->toArray();

            $mostDownloaded = Activity::where('download_count', '>', 0)
                ->orderByDesc('download_count')
                ->limit(5)
                ->get(['id', 'title', 'download_count'])
                ->toArray();

            $response->success = true;
            $response->message = 'Dashboard data fetched successfully';
            $response->data = [
                'stats'            => $stats,
                'today_activities' => $todayActivities,
                'recent_activities' => $recentActivities,
                'category_stats'   => $categoryStats,
                'most_viewed'      => $mostViewed,
                'most_downloaded'  => $mostDownloaded,
            ];

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }
}
