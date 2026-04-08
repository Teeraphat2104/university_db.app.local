<?php

namespace App\Http\Controllers\Web\Admin;

use App\Actions\Web\Admin\Activities\CreateAction as CreateActivityAction;
use App\Actions\Web\Admin\Activities\DeleteAction as DeleteActivityAction;
use App\Actions\Web\Admin\Activities\EditAction as EditActivityAction;
use App\Actions\Web\Admin\Activities\IndexAction as ListActivitiesAction;
use App\Actions\Web\Admin\Activities\ShowAction as ShowActivityAction;
use App\Actions\Web\Admin\Activities\StoreAction as StoreActivityAction;
use App\Actions\Web\Admin\Activities\UpdateAction as UpdateActivityAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    public function index(Request $request)
    {
        return (new ListActivitiesAction())($request);
    }

    public function create(Request $request)
    {
        return (new CreateActivityAction())($request);
    }

    public function store(Request $request)
    {
        return (new StoreActivityAction())($request);
    }

    public function show(int $activity, Request $request)
    {
        return (new ShowActivityAction())($request, $activity);
    }

    public function edit(int $activity, Request $request)
    {
        return (new EditActivityAction())($request, $activity);
    }

    public function update(int $activity, Request $request)
    {
        return (new UpdateActivityAction())($request, $activity);
    }

    public function destroy(int $activity, Request $request)
    {
        return (new DeleteActivityAction())($request, $activity);
    }
}