<?php

namespace App\Actions\Api\V1\Documents;

use App\Models\ActivityDocument;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    use ApiResponse;

    public function __invoke(int $id): JsonResponse
    {
        $document = ActivityDocument::query()->findOrFail($id);

        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return $this->successResponse(null, 'Activity document deleted successfully.');
    }
}
