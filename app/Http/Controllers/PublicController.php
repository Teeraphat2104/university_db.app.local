<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Activity;
use App\Models\ActivityParticipant;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * GET /api/public/home
     * Returns active categories + latest 8 active activities + stats.
     */
    public function home()
    {
        $categories = Category::where('status', true)->orderByDesc('id')->get();

        $latestActivities = Activity::with('category')
            ->where('status', true)
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        return ApiResponse::success('Home data fetched successfully', [
            'categories'        => $categories->map(fn ($cat) => [
                'id'              => $cat->id,
                'name'            => $cat->name,
                'cover_image_url' => $cat->cover_image_url,
                'status'          => (int) $cat->status,
            ]),
            'latest_activities' => $latestActivities->map(fn ($a) => $this->formatActivity($a)),
            'stats' => [
                'total_activities'    => Activity::where('status', true)->count(),
                'total_categories'    => Category::where('status', true)->count(),
                'total_documents'     => Activity::where('status', true)->whereNotNull('pdf_file')->count() 
                                       + Activity::where('status', true)->whereNotNull('excel_file')->count(),
                'total_participants'  => ActivityParticipant::count(),
            ],
        ]);
    }

    /**
     * GET /api/public/categories
     * Returns all active categories.
     */
    public function categories()
    {
        $categories = Category::where('status', true)->orderByDesc('id')->get();

        return ApiResponse::success(
            'Categories fetched successfully',
            $categories->map(fn ($cat) => [
                'id'              => $cat->id,
                'name'            => $cat->name,
                'cover_image_url' => $cat->cover_image_url,
                'status'          => (int) $cat->status,
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

        $paginator = $query->orderByDesc('id')->paginate($perPage);

        return ApiResponse::paginated(
            'Activities fetched successfully',
            $paginator->through(fn ($a) => $this->formatActivity($a))
        );
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
     * GET /api/public/search?q=6601234567  (Student ID)
     * GET /api/public/search?q=สมชาย       (Name)
     */
    public function search(Request $request)
    {
        $q = trim($request->input('q', ''));

        if (blank($q)) {
            return ApiResponse::error('กรุณากรอก Student ID หรือชื่อที่ต้องการค้นหา', null, 422);
        }

        $query = ActivityParticipant::with(['activity' => function ($q) {
            $q->with('category')->where('status', true);
        }]);

        // Detect search type: all-digits = Student ID, else = name
        if (ctype_digit($q)) {
            $query->where('student_id', $q);
            $queryType = 'student_id';
        } else {
            $query->where('name', 'LIKE', "%{$q}%");
            $queryType = 'name';
        }

        $participants = $query->get();

        // Filter out participants whose activity was deleted / inactive
        $participants = $participants->filter(fn ($p) => $p->activity !== null);

        // Group by student
        $grouped = $participants->groupBy('student_id')->map(function ($rows) {
            $first = $rows->first();
            return [
                'student_id' => $first->student_id,
                'name'       => $first->name,
                'activities' => $rows->map(fn ($p) => $this->formatActivity($p->activity))->values()->toArray(),
            ];
        })->values()->toArray();

        return response()->json([
            'success'    => true,
            'query'      => $q,
            'query_type' => $queryType,
            'count'      => count($grouped),
            'data'       => $grouped,
        ]);
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
        ];
    }
}
