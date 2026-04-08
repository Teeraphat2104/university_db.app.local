<?php

namespace App\Http\Controllers\Web\Public;

use App\Actions\Web\Public\Activities\IndexAction as ListActivitiesAction;
use App\Actions\Web\Public\Activities\ShowAction as ShowActivityAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    public function index(Request $request)
    {
        return (new ListActivitiesAction())($request);
    }

    public function show(int $activity, Request $request)
    {
        return (new ShowActivityAction())($request, $activity);
    }
}