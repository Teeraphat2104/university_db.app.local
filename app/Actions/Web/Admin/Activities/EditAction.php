<?php

namespace App\Actions\Web\Admin\Activities;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Contracts\View\View;

class EditAction
{
    public function __invoke(int $activity): View
    {
        return view('admin.activities.edit', [
            'activity' => Activity::query()
                ->with(['category', 'creator', 'document'])
                ->findOrFail($activity),
            'categories' => Category::query()->orderBy('category_name')->get(),
            'statuses' => Activity::STATUSES,
        ]);
    }
}
