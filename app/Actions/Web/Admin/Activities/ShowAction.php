<?php

namespace App\Actions\Web\Admin\Activities;

use App\Models\Activity;
use Illuminate\Contracts\View\View;

class ShowAction
{
    public function __invoke(int $activity): View
    {
        return view('admin.activities.show', [
            'activity' => Activity::query()
                ->with(['category', 'creator', 'document'])
                ->findOrFail($activity),
        ]);
    }
}
