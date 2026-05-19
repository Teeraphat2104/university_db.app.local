<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityParticipant;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $response = (object)[];

        try {
            $categories = Category::where('status', true)->orderByDesc('id')->get();

            $latestActivities = Activity::with('category')
                ->where('status', true)
                ->orderByDesc('id')
                ->limit(8)
                ->get();

            $response->success = true;
            $response->message = 'Home data fetched successfully';
            $response->data = [
                'categories' => $categories->map(fn ($cat) => [
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

    public function categories()
    {
        $response = (object)[];

        try {
            $categories = Category::where('status', true)->orderByDesc('id')->get();

            $response->success = true;
            $response->message = 'Categories fetched successfully';
            $response->data = $categories->map(fn ($cat) => [
                'id'              => $cat->id,
                'name'            => $cat->name,
                'cover_image_url' => $cat->cover_image_url,
                'status'          => (int) $cat->status,
            ]);

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function activities(Request $request)
    {
        $response = (object)[];

        try {
            $perPage = (int) $request->input('per_page', 10);

            $query = Activity::with('category')->where('status', true);

            if ($request->filled('keyword')) {
                $query->where('title', 'like', '%' . $request->input('keyword') . '%');
            }

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->input('category_id'));
            }

            $paginator = $query->orderByDesc('id')->paginate($perPage);

            $response->success = true;
            $response->message = 'Activities fetched successfully';
            $response->data = collect($paginator->items())->map(fn ($a) => $this->formatActivity($a));
            $response->meta = [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
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

    public function activityDetail(string $id)
    {
        $response = (object)[];

        try {
            $activity = Activity::with('category')
                ->where('status', true)
                ->findOrFail($id);

            $response->success = true;
            $response->message = 'Activity fetched successfully';
            $response->data = $this->formatActivity($activity);

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 404;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function search(Request $request)
    {
        $response = (object)[];

        try {
            $q = trim($request->input('q', ''));

            if (blank($q)) {
                $response->success = false;
                $response->message = 'กรุณากรอก Student ID หรือชื่อที่ต้องการค้นหา';
                $response->errors = null;
                return response()->json($response, 422);
            }

            $query = ActivityParticipant::with(['activity' => function ($q) {
                $q->with('category')->where('status', true);
            }]);

            if (ctype_digit($q)) {
                $query->where('student_id', $q);
                $queryType = 'student_id';
            } else {
                $query->where('name', 'LIKE', "%{$q}%");
                $queryType = 'name';
            }

            $participants = $query->get();

            $participants = $participants->filter(fn ($p) => $p->activity !== null);

            $grouped = $participants->groupBy('student_id')->map(function ($rows) {
                $first = $rows->first();
                return [
                    'student_id' => $first->student_id,
                    'name'       => $first->name,
                    'activities' => $rows->map(fn ($p) => $this->formatActivity($p->activity))->values()->toArray(),
                ];
            })->values()->toArray();

            $response->success = true;
            $response->message = 'Search results fetched successfully';
            $response->query = $q;
            $response->query_type = $queryType;
            $response->count = count($grouped);
            $response->data = $grouped;

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

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
