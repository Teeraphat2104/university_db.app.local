<?php

namespace App\Actions\Web\Admin\Categories;

use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateAction
{
    use ApiResponse;

    public function __invoke(Request $request): View|JsonResponse
    {
        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([], 'Category form data fetched successfully.');
        }

        return view('admin.categories.create');

        return response()->json();

    }
}
