<?php

namespace App\Http\Controllers\Api\Public;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * GET /api/public/categories
     */
    public function index()
    {
        $categories = Category::where('status', true)->latest()->get();

        return ApiResponse::success(
            'Categories fetched successfully',
            CategoryResource::collection($categories)
        );
    }
}
