<?php

namespace App\Actions\Web\Public\Activities;

use App\Models\Activity;
use Illuminate\Contracts\View\View;

class ShowAction
{
    public function __invoke(int $activity): View
    {
        return view('public.activities.show', [
            'activity' => Activity::query()
                ->with(['category', 'creator', 'document'])
                ->where('status', 'published')
                ->findOrFail($activity),
        ]);
    }
}
