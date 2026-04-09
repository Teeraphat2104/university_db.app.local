<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Activity;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * GET /api/public/home
     * Returns active categories + latest 8 active activities.
     */
    public function home()
    {
        $categories = Category::where('status', true)->latest()->get();

        $latestActivities = Activity::with('category')
            ->where('status', true)
            ->latest()
            ->limit(8)
            ->get();

        return ApiResponse::success('Home data fetched successfully', [
            'categories'        => $categories->map(fn ($cat) => [
                'id'     => $cat->id,
                'name'   => $cat->name,
                'status' => (int) $cat->status,
            ]),
            'latest_activities' => $latestActivities->map(fn ($a) => $this->formatActivity($a)),
        ]);
    }

    /**
     * GET /api/public/categories
     * Returns all active categories.
     */
    public function categories()
    {
        $categories = Category::where('status', true)->latest()->get();

        return ApiResponse::success(
            'Categories fetched successfully',
            $categories->map(fn ($cat) => [
                'id'     => $cat->id,
                'name'   => $cat->name,
                'status' => (int) $cat->status,
            ])
        );
    }

    /**
     * GET /api/public/activities
     * Query: keyword, category_id, page, per_page
     */
    public function activities(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);

        $query = Activity::with('category')->where('status', true);

        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->input('keyword') . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $paginator = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Activities fetched successfully',
            'data'    => $paginator->getCollection()->map(fn ($a) => $this->formatActivity($a)),
            'meta'    => [
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'last_page'    => $paginator->lastPage(),
            ],
        ]);
    }

    /**
     * GET /api/public/activities/{id}
     */
    public function activityDetail(string $id)
    {
        $activity = Activity::with('category')
            ->where('status', true)
            ->findOrFail($id);

        return ApiResponse::success(
            'Activity fetched successfully',
            $this->formatActivity($activity)
        );
    }

    /**
     * Format activity data for JSON response.
     */
    private function formatActivity(Activity $activity): array
    {
        return [
            'id'              => $activity->id,
            'title'           => $activity->title,
            'description'     => $activity->description,
            'cover_image_url' => $activity->cover_image_url,
            'pdf_url'         => $activity->pdf_url,
            'category'        => $activity->relationLoaded('category') && $activity->category ? [
                'id'   => $activity->category->id,
                'name' => $activity->category->name,
            ] : null,
            'category_id'     => $activity->category_id,
            'activity_date'   => $activity->activity_date?->format('Y-m-d'),
            'location'        => $activity->location,
            'status'          => (int) $activity->status,
            'created_at'      => $activity->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
