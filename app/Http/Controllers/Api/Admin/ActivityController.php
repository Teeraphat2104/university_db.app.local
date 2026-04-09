<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Services\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __construct(private ActivityService $activityService) {}

    /**
     * GET /api/admin/activities
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);

        $paginator = $this->activityService->paginate($request->only([
            'keyword',
            'category_id',
        ]), $perPage);

        return ApiResponse::paginated(
            'Activities fetched successfully',
            $paginator->through(fn ($a) => new ActivityResource($a))
        );
    }

    /**
     * POST /api/admin/activities
     */
    public function store(StoreActivityRequest $request)
    {
        $data = $request->validated();

        // Pass uploaded files separately so the service can handle them
        if ($request->hasFile('cover_image')) {
            $data['cover_image_file'] = $request->file('cover_image');
        }
        if ($request->hasFile('pdf_file')) {
            $data['pdf_file_upload'] = $request->file('pdf_file');
        }

        $activity = $this->activityService->create($data);
        $activity->load('category');

        return ApiResponse::success(
            'Activity created successfully',
            new ActivityResource($activity),
            201
        );
    }

    /**
     * GET /api/admin/activities/{id}
     */
    public function show(string $id)
    {
        $activity = Activity::with('category')->findOrFail($id);

        return ApiResponse::success(
            'Activity fetched successfully',
            new ActivityResource($activity)
        );
    }

    /**
     * PUT /api/admin/activities/{id}
     * Also handles POST with _method=PUT (multipart form-data)
     */
    public function update(UpdateActivityRequest $request, string $id)
    {
        $activity = Activity::findOrFail($id);
        $data     = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image_file'] = $request->file('cover_image');
        }
        if ($request->hasFile('pdf_file')) {
            $data['pdf_file_upload'] = $request->file('pdf_file');
        }

        $activity = $this->activityService->update($activity, $data);

        return ApiResponse::success(
            'Activity updated successfully',
            new ActivityResource($activity)
        );
    }

    /**
     * DELETE /api/admin/activities/{id}
     */
    public function destroy(string $id)
    {
        $activity = Activity::findOrFail($id);
        $this->activityService->delete($activity);

        return ApiResponse::success('Activity deleted successfully');
    }
}
