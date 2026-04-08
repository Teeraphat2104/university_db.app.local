<?php

namespace App\Actions\Web\Admin\Activities;

use App\Models\Activity;
use App\Support\ActivityDocumentStorage;
use App\Support\ApiResponse;
use App\Support\JsonRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    use ApiResponse;

    public function __construct(
        private readonly ActivityDocumentStorage $documentStorage
    ) {
    }

    public function __invoke(Request $request, int $activity): JsonResponse|RedirectResponse
    {
        $deletedActivityId = $activity;

        DB::transaction(function () use ($activity): void {
            $model = Activity::query()->with('document')->findOrFail($activity);

            $this->documentStorage->delete($model->document);

            $model->delete();
        });

        if (JsonRequest::wantsJson($request)) {
            return $this->successResponse([
                'deleted_activity_id' => $deletedActivityId,
                'redirect_url' => route('admin.activities.index'),
            ], 'Activity deleted successfully.');
        }

        return redirect()
            ->route('admin.activities.index')
            ->with('success', 'ลบกิจกรรมเรียบร้อยแล้ว');
    }
}
