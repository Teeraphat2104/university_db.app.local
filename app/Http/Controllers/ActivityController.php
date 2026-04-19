<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /**
     * GET /api/admin/activities
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);

        $query = Activity::with('category');

        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->input('keyword') . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $paginator = $query->latest()->paginate($perPage);

        return ApiResponse::paginated(
            'Activities fetched successfully',
            $paginator->through(fn ($a) => $this->formatActivity($a))
        );
    }

    /**
     * POST /api/admin/activities
     */
    public function store(StoreActivityRequest $request)
    {
        $data = $request->validated();

        $payload = [
            'category_id'   => $data['category_id'],
            'title'         => $data['title'],
            'description'   => $data['description'] ?? null,
            'activity_date' => $data['activity_date'] ?? null,
            'location'      => $data['location'] ?? null,
            'status'        => $data['status'] ?? 1,
        ];

        if ($request->hasFile('cover_image')) {
            $payload['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $payload['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        $activity = Activity::create($payload);
        $activity->load('category');

        return ApiResponse::success(
            'Activity created successfully',
            $this->formatActivity($activity),
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
            $this->formatActivity($activity)
        );
    }

    /**
     * PUT /api/admin/activities/{id}
     * Also handles POST with _method=PUT (multipart form-data)
     */
    public function update(UpdateActivityRequest $request, string $id)
    {
        $activity = Activity::findOrFail($id);

        $data = $request->validated();

        $payload = [
            'category_id'   => $data['category_id'],
            'title'         => $data['title'],
            'description'   => $data['description'] ?? $activity->description,
            'activity_date' => $data['activity_date'] ?? $activity->activity_date,
            'location'      => $data['location'] ?? $activity->location,
            'status'        => $data['status'] ?? $activity->status,
        ];

        // Handle cover image upload (delete old file if exists)
        if ($request->hasFile('cover_image')) {
            if ($activity->cover_image) {
                Storage::disk('public')->delete($activity->cover_image);
            }
            $payload['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        // Handle PDF upload (delete old file if exists)
        if ($request->hasFile('pdf_file')) {
            if ($activity->pdf_file) {
                Storage::disk('public')->delete($activity->pdf_file);
            }
            $payload['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        $activity->update($payload);
        $activity = $activity->fresh(['category']);

        return ApiResponse::success(
            'Activity updated successfully',
            $this->formatActivity($activity)
        );
    }

    /**
     * DELETE /api/admin/activities/{id}
     */
    public function destroy(string $id)
    {
        $activity = Activity::findOrFail($id);

        // Delete associated files from storage
        if ($activity->cover_image) {
            Storage::disk('public')->delete($activity->cover_image);
        }
        if ($activity->pdf_file) {
            Storage::disk('public')->delete($activity->pdf_file);
        }

        $activity->delete();

        return ApiResponse::success('Activity deleted successfully');
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
