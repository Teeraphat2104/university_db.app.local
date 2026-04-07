<?php

namespace App\Actions\Api\V1\Activities;

use App\Models\Activity;
use App\Models\ActivityDocument;
use App\Models\User;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadDocumentAction
{
    use ApiResponse;

    public function __invoke(Request $request, int $id): JsonResponse
    {
        $validated = validator($request->all(), [
            'document' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ])->validate();

        /** @var \App\Models\User $user */
        $user = $request->user();

        $document = DB::transaction(function () use ($id, $validated, $user): ActivityDocument {
            $activity = Activity::query()->with('document')->findOrFail($id);
            $this->storeDocument($activity, $validated['document'], $user);

            return $activity->fresh(['document.uploader'])->document;
        });

        return $this->successResponse($document->toArray(), 'Activity document uploaded successfully.', 201);
    }

    private function storeDocument(Activity $activity, UploadedFile $file, User $user): void
    {
        if ($activity->document?->file_path) {
            Storage::disk('public')->delete($activity->document->file_path);
        }

        Storage::disk('public')->makeDirectory('activities/pdf');

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $sanitizedName = Str::slug($originalName) ?: 'activity-document';
        $filename = now()->format('YmdHis').'-'.$activity->id.'-'.Str::random(6).'-'.$sanitizedName.'.'.$file->extension();
        $path = $file->storeAs('activities/pdf', $filename, 'public');

        ActivityDocument::query()->updateOrCreate(
            ['activity_id' => $activity->id],
            [
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientMimeType() ?? 'application/pdf',
                'file_size' => $file->getSize(),
                'uploaded_by' => $user->id,
            ]
        );
    }
}
