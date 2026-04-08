<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ActivityDocument;
use App\Support\ActivityDocumentStorage;
use App\Support\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DocumentsController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ActivityDocumentStorage $documentStorage
    ) {
    }

    public function destroy(int $id): JsonResponse
    {
        $document = ActivityDocument::query()->findOrFail($id);

        $this->documentStorage->delete($document);

        return $this->successResponse(null, 'Activity document deleted successfully.');
    }
}