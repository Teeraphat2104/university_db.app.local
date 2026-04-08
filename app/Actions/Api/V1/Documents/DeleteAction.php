<?php

namespace App\Actions\Api\V1\Documents;

use App\Models\ActivityDocument;
use App\Support\ActivityDocumentStorage;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class DeleteAction
{
    use ApiResponse;

    public function __construct(
        private readonly ActivityDocumentStorage $documentStorage
    ) {
    }

    public function __invoke(int $id): JsonResponse
    {
        $document = ActivityDocument::query()->findOrFail($id);

        $this->documentStorage->delete($document);

        return $this->successResponse(null, 'Activity document deleted successfully.');
    }
}
