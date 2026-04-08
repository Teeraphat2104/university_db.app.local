<?php

namespace App\Actions\Web\Admin\Activities;

use App\Models\Activity;
use App\Support\ActivityDocumentStorage;
use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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

    public function __invoke(Request $request, int $activity): JsonResponse|RedirectResponse
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

        $model = DB::transaction(function () use ($validated, $request, $activity, $user): Activity {
            $model = Activity::query()->with('document')->findOrFail($activity);

            $model->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'activity_date' => $validated['activity_date'],
                'location' => $validated['location'],
                'organizer' => $validated['organizer'],
                'status' => $validated['status'],
            ]);

            if ($request->hasFile('document')) {
                $this->documentStorage->store($model, $request->file('document'), $user);
            }

            return $model->fresh(['category', 'creator', 'document.uploader']);
        });

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([
                'activity' => $model->toArray(),
                'redirect_url' => route('admin.activities.show', $model->id),
            ], 'Activity updated successfully.');
        }

        return redirect()
            ->route('admin.activities.show', $model->id)
            ->with('success', 'อัปเดตกิจกรรมเรียบร้อยแล้ว');
    }
}
