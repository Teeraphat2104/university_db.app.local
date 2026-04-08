<?php

namespace App\Actions\Web\Admin\Categories;

use App\Models\Category;
use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexAction
{
    use ApiResponse;

    public function __invoke(Request $request): View|JsonResponse
    {
        $validated = validator($request->all(), [
            'search' => ['nullable', 'string', 'max:255'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ])->validate();

        $query = Category::query()
            ->withCount('activities')
            ->orderBy('category_name');

        if (! empty($validated['search'])) {
            $query->where('category_name', 'like', '%'.$validated['search'].'%');
        }

        $categories = $query
            ->paginate((int) ($validated['per_page'] ?? 10))
            ->withQueryString();

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([
                'items' => $categories->getCollection()->map->toArray()->values(),
                'pagination' => [
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                    'per_page' => $categories->perPage(),
                    'total' => $categories->total(),
                    'next_page_url' => $categories->nextPageUrl(),
                    'previous_page_url' => $categories->previousPageUrl(),
                ],
                'filters' => $validated,
            ], 'Categories fetched successfully.');
        }

        return view('admin.categories.index', [
            'categories' => $categories,
            'filters' => $validated,
        ]);
    }
}
