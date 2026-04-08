<?php

namespace App\Actions\Api\V1\Activities;

use App\Models\Activity;
use App\Support\ActivityDocumentStorage;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    use ApiResponse;

    public function __construct(
        private readonly ActivityDocumentStorage $documentStorage
    ) {
    }

    public function __invoke(int $id): JsonResponse
    {
        DB::transaction(function () use ($id): void {
            $activity = Activity::query()->with('document')->findOrFail($id);

            $this->documentStorage->delete($activity->document);

            $activity->delete();
        });

        return $this->successResponse(null, 'Activity deleted successfully.');
    }
}
