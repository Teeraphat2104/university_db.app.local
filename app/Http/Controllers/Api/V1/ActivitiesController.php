<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Activity;
use App\Models\ActivityDocument;
use App\Support\ActivityDocumentStorage;
use App\Support\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ActivitiesController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ActivityDocumentStorage $documentStorage
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $validated = validator($request->all(), Activity::filterRules(true))->validate();

        $isAdmin = $request->user()?->isAdmin() ?? false;

        $query = Activity::query()
            ->withApiRelations()
            ->orderBy('activity_date');

        if (! $isAdmin) {
            $query->published();
        }

        $query->applyFilters($validated, $isAdmin);

        $activities = $query->paginate((int) ($validated['per_page'] ?? 10))->withQueryString();

        return $this->successResponse([
            'items' => collect($activities->items())
                ->map(fn (Activity $activity) => $activity->toArray())
                ->values(),
            'pagination' => [
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
                'per_page' => $activities->perPage(),
                'total' => $activities->total(),
            ],
        ], 'Activities fetched successfully.');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = validator($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'activity_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'organizer' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(Activity::STATUSES)],
            'document' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ])->validate();

        $user = $request->user();

        $activity = DB::transaction(function () use ($validated, $request, $user): Activity {
            $activity = Activity::query()->create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'activity_date' => $validated['activity_date'],
                'location' => $validated['location'],
                'organizer' => $validated['organizer'],
                'status' => $validated['status'],
                'created_by' => $user->id,
            ]);

            if ($request->hasFile('document')) {
                $this->documentStorage->store($activity, $request->file('document'), $user);
            }

            return $activity->fresh(['category', 'creator', 'document.uploader']);
        });

        return $this->successResponse($activity->toArray(), 'Activity created successfully.', 201);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $query = Activity::query()->withApiRelations();

        if (! ($request->user()?->isAdmin() ?? false)) {
            $query->published();
        }

        $activity = $query->findOrFail($id);

        return $this->successResponse($activity->toArray(), 'Activity fetched successfully.');
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = validator($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'activity_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'organizer' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(Activity::STATUSES)],
            'document' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ])->validate();

        $user = $request->user();

        $activity = DB::transaction(function () use ($validated, $request, $id, $user): Activity {
            $activity = Activity::query()->with('document')->findOrFail($id);

            $activity->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'activity_date' => $validated['activity_date'],
                'location' => $validated['location'],
                'organizer' => $validated['organizer'],
                'status' => $validated['status'],
            ]);

            if ($request->hasFile('document')) {
                $this->documentStorage->store($activity, $request->file('document'), $user);
            }

            return $activity->fresh(['category', 'creator', 'document.uploader']);
        });

        return $this->successResponse($activity->toArray(), 'Activity updated successfully.');
    }

    public function destroy(int $id): JsonResponse
    {
        DB::transaction(function () use ($id): void {
            $activity = Activity::query()->with('document')->findOrFail($id);

            $this->documentStorage->delete($activity->document);

            $activity->delete();
        });

        return $this->successResponse(null, 'Activity deleted successfully.');
    }

    public function uploadDocument(Request $request, int $id): JsonResponse
    {
        $validated = validator($request->all(), [
            'document' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ])->validate();

        $user = $request->user();

        $document = DB::transaction(function () use ($id, $validated, $user): ActivityDocument {
            $activity = Activity::query()->with('document')->findOrFail($id);
            $this->documentStorage->store($activity, $validated['document'], $user);

            return $activity->fresh(['document.uploader'])->document;
        });

        return $this->successResponse($document->toArray(), 'Activity document uploaded successfully.', 201);
    }
}