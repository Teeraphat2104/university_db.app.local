<?php

namespace App\Actions\Api\V1\Activities;

use App\Models\Activity;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    use ApiResponse;

    public function __invoke(int $id): JsonResponse
    {
        DB::transaction(function () use ($id): void {
            $activity = Activity::query()->with('document')->findOrFail($id);

            if ($activity->document?->file_path) {
                Storage::disk('public')->delete($activity->document->file_path);
                $activity->document->delete();
            }

            $activity->delete();
        });

        return $this->successResponse(null, 'Activity deleted successfully.');
    }
}
