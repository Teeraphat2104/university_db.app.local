<?php

namespace App\Actions\Api\V1\Activities;

use App\Models\Activity;
use App\Models\ActivityDocument;
use App\Support\ActivityDocumentStorage;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadDocumentAction
{
    use ApiResponse;

    public function __construct(
        private readonly ActivityDocumentStorage $documentStorage
    ) {
    }

    public function __invoke(Request $request, int $id): JsonResponse
    {
        $validated = validator($request->all(), [
            'document' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ])->validate();

        /** @var \App\Models\User $user */
        $user = $request->user();

        $document = DB::transaction(function () use ($id, $validated, $user): ActivityDocument {
            $activity = Activity::query()->with('document')->findOrFail($id);
            $this->documentStorage->store($activity, $validated['document'], $user);

            return $activity->fresh(['document.uploader'])->document;
        });

        return $this->successResponse($document->toArray(), 'Activity document uploaded successfully.', 201);
    }
}
