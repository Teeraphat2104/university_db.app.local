<?php

namespace App\Http\Controllers\Api\Public;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Services\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct(private ActivityService $activityService) {}

    /**
     * GET /api/public/activities
     * Query: keyword, category_id, page, per_page
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);

        $filters = array_merge($request->only(['keyword', 'category_id']), [
            'status_filter' => true, // only active activities for public
        ]);

        $paginator = $this->activityService->paginate($filters, $perPage);

        return ApiResponse::paginated(
            'Activities fetched successfully',
            $paginator->through(fn ($a) => new ActivityResource($a))
        );
    }

    /**
     * GET /api/public/activities/{id}
     */
    public function show(string $id)
    {
        $activity = Activity::with('category')
            ->where('status', true)
            ->findOrFail($id);

        return ApiResponse::success(
            'Activity fetched successfully',
            new ActivityResource($activity)
        );
    }
}
