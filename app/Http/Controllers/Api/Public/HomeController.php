<?php

namespace App\Http\Controllers\Api\Public;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\CategoryResource;
use App\Models\Activity;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * GET /api/public/home
     */
    public function index()
    {
        $categories = Category::where('status', true)->latest()->get();

        $latestActivities = Activity::with('category')
            ->where('status', true)
            ->latest()
            ->limit(8)
            ->get();

        return ApiResponse::success('Home data fetched successfully', [
            'categories'         => CategoryResource::collection($categories),
            'latest_activities'  => ActivityResource::collection($latestActivities),
        ]);
    }
}
