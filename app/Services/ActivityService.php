<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityService
{
    public function __construct(private FileUploadService $fileUploadService) {}

    public function paginate(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = Activity::with('category');

        if (! empty($filters['keyword'])) {
            $query->where('title', 'like', '%' . $filters['keyword'] . '%');
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['status_filter']) && $filters['status_filter'] !== null) {
            $query->where('status', $filters['status_filter']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data): Activity
    {
        $payload = [
            'category_id'   => $data['category_id'],
            'title'         => $data['title'],
            'description'   => $data['description'] ?? null,
            'activity_date' => $data['activity_date'] ?? null,
            'location'      => $data['location'] ?? null,
            'status'        => $data['status'] ?? 1,
        ];

        if (isset($data['cover_image_file'])) {
            $payload['cover_image'] = $this->fileUploadService->uploadCover($data['cover_image_file']);
        }

        if (isset($data['pdf_file_upload'])) {
            $payload['pdf_file'] = $this->fileUploadService->uploadPdf($data['pdf_file_upload']);
        }

        return Activity::create($payload);
    }

    public function update(Activity $activity, array $data): Activity
    {
        $payload = [
            'category_id'   => $data['category_id'],
            'title'         => $data['title'],
            'description'   => $data['description'] ?? $activity->description,
            'activity_date' => $data['activity_date'] ?? $activity->activity_date,
            'location'      => $data['location'] ?? $activity->location,
            'status'        => $data['status'] ?? $activity->status,
        ];

        if (isset($data['cover_image_file'])) {
            $this->fileUploadService->delete($activity->cover_image);
            $payload['cover_image'] = $this->fileUploadService->uploadCover($data['cover_image_file']);
        }

        if (isset($data['pdf_file_upload'])) {
            $this->fileUploadService->delete($activity->pdf_file);
            $payload['pdf_file'] = $this->fileUploadService->uploadPdf($data['pdf_file_upload']);
        }

        $activity->update($payload);

        return $activity->fresh(['category']);
    }

    public function delete(Activity $activity): void
    {
        $this->fileUploadService->delete($activity->cover_image);
        $this->fileUploadService->delete($activity->pdf_file);
        $activity->delete();
    }
}
