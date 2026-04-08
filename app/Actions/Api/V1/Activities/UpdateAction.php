<?php

namespace App\Actions\Api\V1\Activities;

use App\Models\Activity;
use App\Support\ActivityDocumentStorage;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UpdateAction
{
    use ApiResponse;

    public function __construct(
        private readonly ActivityDocumentStorage $documentStorage
    ) {
    }

    public function __invoke(Request $request, int $id): JsonResponse
    {
        $validated = validator($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'activity_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'organizer' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(Activity::STATUSES)],
            'document' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ])->validate();

        /** @var \App\Models\User $user */
        $user = $request->user();

        $activity = DB::transaction(function () use ($validated, $request, $id, $user): Activity {
            $activity = Activity::query()->with('document')->findOrFail($id);

            $activity->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'activity_date' => $validated['activity_date'],
                'location' => $validated['location'],
                'organizer' => $validated['organizer'],
                'status' => $validated['status'],
            ]);

            if ($request->hasFile('document')) {
                $this->documentStorage->store($activity, $request->file('document'), $user);
            }

            return $activity->fresh(['category', 'creator', 'document.uploader']);
        });

        return $this->successResponse($activity->toArray(), 'Activity updated successfully.');
    }
}
