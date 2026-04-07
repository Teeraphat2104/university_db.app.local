<?php

namespace App\Actions\Web\Admin\Activities;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Contracts\View\View;

class CreateAction
{
    public function __invoke(): View
    {
        return view('admin.activities.create', [
            'categories' => Category::query()->orderBy('category_name')->get(),
            'statuses' => Activity::STATUSES,
        ]);
    }
}
