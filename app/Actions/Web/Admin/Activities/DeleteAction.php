<?php

namespace App\Actions\Web\Admin\Activities;

use App\Models\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    public function __invoke(int $activity): RedirectResponse
    {
        DB::transaction(function () use ($activity): void {
            $model = Activity::query()->with('document')->findOrFail($activity);

            if ($model->document?->file_path) {
                Storage::disk('public')->delete($model->document->file_path);
                $model->document->delete();
            }

            $model->delete();
        });

        return redirect()
            ->route('admin.activities.index')
            ->with('success', 'Activity deleted successfully.');
    }
}
