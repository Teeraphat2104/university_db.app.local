<?php

namespace App\Actions\Api\V1\Categories;

use App\Models\Category;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class DeleteAction
{
    use ApiResponse;

    public function __invoke(int $id): JsonResponse
    {
        $category = Category::query()->findOrFail($id);

        if ($category->activities()->exists()) {
            return $this->errorResponse(
                'Category deletion failed.',
                'Cannot delete a category that still has activities.',
                409
            );
        }

        $category->delete();

        return $this->successResponse(null, 'Category deleted successfully.');
    }
}
