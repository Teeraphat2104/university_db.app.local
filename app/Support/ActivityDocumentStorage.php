<?php

namespace App\Support;

use App\Models\Activity;
use App\Models\ActivityDocument;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActivityDocumentStorage
{
    public function store(Activity $activity, UploadedFile $file, User $user): ActivityDocument
    {
        $this->delete($activity->document);

        Storage::disk('public')->makeDirectory('activities/pdf');

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $sanitizedName = Str::slug($originalName) ?: 'activity-document';
        $filename = now()->format('YmdHis').'-'.$activity->id.'-'.Str::random(6).'-'.$sanitizedName.'.'.$file->extension();
        $path = $file->storeAs('activities/pdf', $filename, 'public');

        return ActivityDocument::query()->updateOrCreate(
            ['activity_id' => $activity->id],
            [
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientMimeType() ?? 'application/pdf',
                'file_size' => $file->getSize(),
                'uploaded_by' => $user->id,
            ]
        )->fresh(['uploader']);
    }

    public function delete(?ActivityDocument $document): void
    {
        if (! $document) {
            return;
        }

        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();
    }
}
