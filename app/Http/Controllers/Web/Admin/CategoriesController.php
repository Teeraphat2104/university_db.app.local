<?php

namespace App\Http\Controllers\Web\Admin;

use App\Actions\Web\Admin\Categories\CreateAction as CreateCategoryAction;
use App\Actions\Web\Admin\Categories\DeleteAction as DeleteCategoryAction;
use App\Actions\Web\Admin\Categories\EditAction as EditCategoryAction;
use App\Actions\Web\Admin\Categories\IndexAction as ListCategoriesAction;
use App\Actions\Web\Admin\Categories\StoreAction as StoreCategoryAction;
use App\Actions\Web\Admin\Categories\UpdateAction as UpdateCategoryAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        return (new ListCategoriesAction())($request);
    }

    public function create(Request $request)
    {
        return (new CreateCategoryAction())($request);
    }

    public function store(Request $request)
    {
        return (new StoreCategoryAction())($request);
    }

    public function edit(int $category, Request $request)
    {
        return (new EditCategoryAction())($request, $category);
    }

    public function update(int $category, Request $request)
    {
        return (new UpdateCategoryAction())($request, $category);
    }

    public function destroy(int $category, Request $request)
    {
        return (new DeleteCategoryAction())($request, $category);
    }
}