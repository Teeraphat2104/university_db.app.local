<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $response = (object)[];

        try {
            $perPage = (int) $request->input('per_page', 10);

            $query = Activity::with('category');

            if ($request->filled('keyword')) {
                $query->where('title', 'like', '%' . $request->input('keyword') . '%');
            }

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->input('category_id'));
            }

            $paginator = $query->orderByDesc('id')->paginate($perPage);

            $response->success = true;
            $response->message = 'Activities fetched successfully';
            $response->data = collect($paginator->items())->map(fn ($a) => $this->formatActivity($a));
            $response->meta = [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ];

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function store(Request $request)
    {
        $response = (object)[];

        try {
            $data = $request->validate([
                'title'         => 'required|string|max:255',
                'category_id'   => 'required|exists:categories,id',
                'description'   => 'nullable|string',
                'cover_image'   => 'nullable|file|image|max:5120',
                'pdf_file'      => 'nullable|file|mimes:pdf|max:10240',
                'activity_date' => 'nullable|date',
                'location'      => 'nullable|string|max:500',
                'status'        => 'nullable|boolean',
            ]);

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

            $response->success = true;
            $response->message = 'Activity created successfully';
            $response->data = $this->formatActivity($activity);

            $httpCode = 201;
        } catch (ValidationException $e) {
            $response->success = false;
            $response->message = 'Validation failed';
            $response->errors = $e->errors();
            $httpCode = 422;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function show(string $id)
    {
        $response = (object)[];

        try {
            $activity = Activity::with('category')->findOrFail($id);

            $response->success = true;
            $response->message = 'Activity fetched successfully';
            $response->data = $this->formatActivity($activity);

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 404;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function update(Request $request, string $id)
    {
        $response = (object)[];

        try {
            $data = $request->validate([
                'title'         => 'required|string|max:255',
                'category_id'   => 'required|exists:categories,id',
                'description'   => 'nullable|string',
                'cover_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'pdf_file'      => 'nullable|mimes:pdf|max:20480',
                'activity_date' => 'nullable|date',
                'location'      => 'nullable|string|max:500',
                'status'        => 'nullable|boolean',
            ]);

            $activity = Activity::findOrFail($id);

            $payload = [
                'category_id'   => $data['category_id'],
                'title'         => $data['title'],
                'description'   => $data['description'] ?? $activity->description,
                'activity_date' => $data['activity_date'] ?? $activity->activity_date,
                'location'      => $data['location'] ?? $activity->location,
                'status'        => $data['status'] ?? $activity->status,
            ];

            if ($request->hasFile('cover_image')) {
                if ($activity->cover_image) {
                    Storage::disk('public')->delete($activity->cover_image);
                }
                $payload['cover_image'] = $request->file('cover_image')->store('covers', 'public');
            }

            if ($request->hasFile('pdf_file')) {
                if ($activity->pdf_file) {
                    Storage::disk('public')->delete($activity->pdf_file);
                }
                $payload['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
            }

            $activity->update($payload);
            $activity = $activity->fresh(['category']);

            $response->success = true;
            $response->message = 'Activity updated successfully';
            $response->data = $this->formatActivity($activity);

            $httpCode = 200;
        } catch (ValidationException $e) {
            $response->success = false;
            $response->message = 'Validation failed';
            $response->errors = $e->errors();
            $httpCode = 422;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function destroy(string $id)
    {
        $response = (object)[];

        try {
            $activity = Activity::findOrFail($id);

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

            $response->success = true;
            $response->message = 'Activity deleted successfully';

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 404;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function importExcel(Request $request, string $id)
    {
        $response = (object)[];

        try {
            $request->validate([
                'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:20480',
            ]);

            $activity = Activity::findOrFail($id);

            $path = $request->file('excel_file')->store('excels', 'public');

            $filePath = Storage::disk('public')->path($path);
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows  = $sheet->toArray(null, true, true, true);

            if (empty($rows)) {
                Storage::disk('public')->delete($path);
                $response->success = false;
                $response->message = 'ไฟล์ Excel ว่างเปล่า';
                $response->errors = null;
                return response()->json($response, 422);
            }

            $headerRow  = array_shift($rows);
            $colMap     = [];
            $knownCols  = ['student_id', 'name'];

            foreach ($headerRow as $col => $header) {
                $normalized = strtolower(trim((string) $header));
                $colMap[$col] = $normalized;
            }

            $headerNames = array_values($colMap);
            if (!in_array('student_id', $headerNames) || !in_array('name', $headerNames)) {
                Storage::disk('public')->delete($path);
                $response->success = false;
                $response->message = 'ไฟล์ Excel ต้องมีคอลัมน์ "student_id" และ "name"';
                $response->errors = null;
                return response()->json($response, 422);
            }

            $upsertData = [];

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

                if (!$studentId || !$name) continue;

                $upsertData[] = [
                    'activity_id' => $activity->id,
                    'student_id'  => $studentId,
                    'name'        => $name,
                    'extra_data'  => !empty($extra) ? json_encode($extra) : null,
                ];
            }

            if (empty($upsertData)) {
                Storage::disk('public')->delete($path);
                $response->success = false;
                $response->message = 'ไม่พบข้อมูลที่ valid ในไฟล์ Excel';
                $response->errors = null;
                return response()->json($response, 422);
            }

            if ($activity->excel_file) {
                Storage::disk('public')->delete($activity->excel_file);
            }

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

            $response->success = true;
            $response->message = "นำเข้าข้อมูลสำเร็จ {$count} คน";
            $response->data = [
                'imported' => count($upsertData),
                'total'    => $count,
            ];

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function participants(Request $request, string $id)
    {
        $response = (object)[];

        try {
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

            $response->success = true;
            $response->message = 'Participants fetched successfully';
            $response->data = collect($paginator->items())->map(fn ($p) => [
                'id'         => $p->id,
                'student_id' => $p->student_id,
                'name'       => $p->name,
            ]);
            $response->meta = [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
            ];

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

    public function clearParticipants(string $id)
    {
        $response = (object)[];

        try {
            $activity = Activity::findOrFail($id);
            ActivityParticipant::where('activity_id', $id)->delete();

            if ($activity->excel_file) {
                Storage::disk('public')->delete($activity->excel_file);
            }

            $activity->update(['excel_file' => null, 'participants_count' => 0]);

            $response->success = true;
            $response->message = 'ล้างรายชื่อผู้เข้าร่วมแล้ว';

            $httpCode = 200;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = 'An error occurred';
            $response->errors = $e->getMessage();
            $httpCode = 500;
        }

        return response()->json($response, $httpCode ?? 500);
    }

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
