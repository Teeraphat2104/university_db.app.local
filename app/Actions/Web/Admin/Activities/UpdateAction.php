<?php

namespace App\Actions\Web\Admin\Activities;

use App\Models\Activity;
use App\Models\ActivityDocument;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateAction
{
    public function __invoke(Request $request, int $activity): RedirectResponse
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
                $this->storeDocument($model, $request->file('document'), $user);
            }

            return $model;
        });

        return redirect()
            ->route('admin.activities.show', $model->id)
            ->with('success', 'Activity updated successfully.');
    }

    private function storeDocument(Activity $activity, UploadedFile $file, User $user): void
    {
        $existingDocument = $activity->document()->first();

        if ($existingDocument?->file_path) {
            Storage::disk('public')->delete($existingDocument->file_path);
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
