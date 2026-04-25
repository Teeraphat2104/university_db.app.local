<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\ActivityParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ActivityController extends Controller
{
    /**
     * GET /api/admin/activities
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);

        $query = Activity::with('category');

        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->input('keyword') . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $paginator = $query->orderByDesc('id')->paginate($perPage);

        return ApiResponse::paginated(
            'Activities fetched successfully',
            $paginator->through(fn ($a) => $this->formatActivity($a))
        );
    }

    /**
     * POST /api/admin/activities
     */
    public function store(StoreActivityRequest $request)
    {
        $data = $request->validated();

        $payload = [
            'category_id'   => $data['category_id'],
            'title'         => $data['title'],
            'description'   => $data['description'] ?? null,
            'activity_date' => $data['activity_date'] ?? null,
            'location'      => $data['location'] ?? null,
            'status'        => $data['status'] ?? 1,
        ];

        if ($request->hasFile('cover_image')) {
            $payload['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $payload['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        $activity = Activity::create($payload);
        $activity->load('category');

        return ApiResponse::success(
            'Activity created successfully',
            $this->formatActivity($activity),
            201
        );
    }

    /**
     * GET /api/admin/activities/{id}
     */
    public function show(string $id)
    {
        $activity = Activity::with('category')->findOrFail($id);

        return ApiResponse::success(
            'Activity fetched successfully',
            $this->formatActivity($activity)
        );
    }

    /**
     * PUT /api/admin/activities/{id}
     * Also handles POST with _method=PUT (multipart form-data)
     */
    public function update(UpdateActivityRequest $request, string $id)
    {
        $activity = Activity::findOrFail($id);

        $data = $request->validated();

        $payload = [
            'category_id'   => $data['category_id'],
            'title'         => $data['title'],
            'description'   => $data['description'] ?? $activity->description,
            'activity_date' => $data['activity_date'] ?? $activity->activity_date,
            'location'      => $data['location'] ?? $activity->location,
            'status'        => $data['status'] ?? $activity->status,
        ];

        // Handle cover image upload (delete old file if exists)
        if ($request->hasFile('cover_image')) {
            if ($activity->cover_image) {
                Storage::disk('public')->delete($activity->cover_image);
            }
            $payload['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        // Handle PDF upload (delete old file if exists)
        if ($request->hasFile('pdf_file')) {
            if ($activity->pdf_file) {
                Storage::disk('public')->delete($activity->pdf_file);
            }
            $payload['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        $activity->update($payload);
        $activity = $activity->fresh(['category']);

        return ApiResponse::success(
            'Activity updated successfully',
            $this->formatActivity($activity)
        );
    }

    /**
     * DELETE /api/admin/activities/{id}
     */
    public function destroy(string $id)
    {
        $activity = Activity::findOrFail($id);

        // Delete associated files from storage
        if ($activity->cover_image) {
            Storage::disk('public')->delete($activity->cover_image);
        }
        if ($activity->pdf_file) {
            Storage::disk('public')->delete($activity->pdf_file);
        }
        if ($activity->excel_file) {
            Storage::disk('public')->delete($activity->excel_file);
        }

        $activity->delete();

        return ApiResponse::success('Activity deleted successfully');
    }

    /**
     * POST /api/admin/activities/{id}/import-excel
     * Upload & parse Excel file, store participants in DB.
     */
    public function importExcel(Request $request, string $id)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:20480',
        ]);

        $activity = Activity::findOrFail($id);

        // Store the file
        $path = $request->file('excel_file')->store('excels', 'public');

        // Parse Excel
        $filePath = Storage::disk('public')->path($path);
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows  = $sheet->toArray(null, true, true, true); // keyed by col letter

        if (empty($rows)) {
            Storage::disk('public')->delete($path);
            return ApiResponse::error('ไฟล์ Excel ว่างเปล่า', 422);
        }

        // First row = headers (map column letter → header name lowercase)
        $headerRow  = array_shift($rows);
        $colMap     = []; // 'A' => 'student_id', etc.
        $knownCols  = ['student_id', 'name'];

        foreach ($headerRow as $col => $header) {
            $normalized = strtolower(trim((string) $header));
            $colMap[$col] = $normalized;
        }

        // Validate required columns
        $headerNames = array_values($colMap);
        if (!in_array('student_id', $headerNames) || !in_array('name', $headerNames)) {
            Storage::disk('public')->delete($path);
            return ApiResponse::error(
                'ไฟล์ Excel ต้องมีคอลัมน์ "student_id" และ "name"',
                422
            );
        }

        // Build upsert data
        $upsertData = [];
        $now = now();

        foreach ($rows as $row) {
            $mapped = [];
            $extra  = [];

            foreach ($row as $col => $value) {
                $header = $colMap[$col] ?? null;
                if (!$header) continue;

                if (in_array($header, $knownCols)) {
                    $mapped[$header] = $value !== null ? trim((string) $value) : null;
                } else {
                    $extra[$header] = $value;
                }
            }

            $studentId = $mapped['student_id'] ?? null;
            $name      = $mapped['name']       ?? null;

            if (!$studentId || !$name) continue; // skip empty rows

            $upsertData[] = [
                'activity_id' => $activity->id,
                'student_id'  => $studentId,
                'name'        => $name,
                'extra_data'  => !empty($extra) ? json_encode($extra) : null,
            ];
        }

        if (empty($upsertData)) {
            Storage::disk('public')->delete($path);
            return ApiResponse::error('ไม่พบข้อมูลที่ valid ในไฟล์ Excel', 422);
        }

        // Delete old excel file if exists
        if ($activity->excel_file) {
            Storage::disk('public')->delete($activity->excel_file);
        }

        // Upsert participants (update on duplicate activity_id+student_id)
        ActivityParticipant::upsert(
            $upsertData,
            ['activity_id', 'student_id'],
            ['name', 'extra_data']
        );

        $count = ActivityParticipant::where('activity_id', $activity->id)->count();

        $activity->update([
            'excel_file'         => $path,
            'participants_count' => $count,
        ]);

        return ApiResponse::success("นำเข้าข้อมูลสำเร็จ {$count} คน", [
            'imported' => count($upsertData),
            'total'    => $count,
        ]);
    }

    /**
     * GET /api/admin/activities/{id}/participants
     */
    public function participants(Request $request, string $id)
    {
        $activity = Activity::findOrFail($id);
        $perPage  = (int) $request->input('per_page', 20);

        $query = ActivityParticipant::where('activity_id', $id);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('student_id', $q)
                    ->orWhere('name', 'LIKE', "%{$q}%");
            });
        }

        $paginator = $query->orderBy('name')->paginate($perPage);

        return ApiResponse::paginated(
            'Participants fetched successfully',
            $paginator->through(fn ($p) => [
                'id'         => $p->id,
                'student_id' => $p->student_id,
                'name'       => $p->name,
            ])
        );
    }

    /**
     * DELETE /api/admin/activities/{id}/participants
     */
    public function clearParticipants(string $id)
    {
        $activity = Activity::findOrFail($id);
        ActivityParticipant::where('activity_id', $id)->delete();

        if ($activity->excel_file) {
            Storage::disk('public')->delete($activity->excel_file);
        }

        $activity->update(['excel_file' => null, 'participants_count' => 0]);

        return ApiResponse::success('ล้างรายชื่อผู้เข้าร่วมแล้ว');
    }

    /**
     * Format activity data for JSON response.
     */
    private function formatActivity(Activity $activity): array
    {
        return [
            'id'                 => $activity->id,
            'title'              => $activity->title,
            'description'        => $activity->description,
            'cover_image_url'    => $activity->cover_image_url,
            'pdf_url'            => $activity->pdf_url,
            'excel_url'          => $activity->excel_url,
            'participants_count' => $activity->participants_count ?? 0,
            'category'           => $activity->relationLoaded('category') && $activity->category ? [
                'id'   => $activity->category->id,
                'name' => $activity->category->name,
            ] : null,
            'category_id'        => $activity->category_id,
            'activity_date'      => $activity->activity_date?->format('Y-m-d'),
            'location'           => $activity->location,
            'status'             => (int) $activity->status,
        ];
    }
}
