<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        \Illuminate\Support\Facades\Log::info('Document index request params types:', array_map(function($v) { return gettype($v); }, $params));
        \Illuminate\Support\Facades\Log::info('Document index request values:', $params);
        
        try {
            $validated = $request->validate([
                'keyword' => 'nullable',
                'year' => 'nullable',
                'category_id' => 'nullable',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::error('Validation failed details:', $e->errors());
            throw $e;
        }

        $response = (object) [];

        try {
            $query = Document::query()->with('category');

            if (!empty($validated['keyword'])) {
                $query->where('title', 'like', '%' . $validated['keyword'] . '%');
            }

            if (!empty($validated['year'])) {
                $query->where('year', $validated['year']);
            }

            if (!empty($validated['category_id'])) {
                $query->where('category_id', $validated['category_id']);
            }

            $documents = $query->latest()->paginate(10);

            $data = $documents->map(function ($doc) {
                return $this->formatDocument($doc);
            });

            $response->status = 200;
            $response->message = 'Documents retrieved successfully';
            $response->data = $data;
            $response->pagination = [
                'current_page' => $documents->currentPage(),
                'last_page' => $documents->lastPage(),
                'total' => $documents->total(),
            ];

        } catch (\Exception $e) {
            $response->status = 500;
            $response->message = 'Failed to retrieve documents';
            $response->error = $e->getMessage();
        }

        return response()->json($response, $response->status);
    }

    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Document store request:', $request->all());
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'category_id' => 'required|integer|exists:categories,id',
                'year' => 'required|integer',
                'file' => 'required|file|max:10240',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::error('Store validation failed:', $e->errors());
            throw $e;
        }

        $response = (object) [];

        try {
            $filePath = $request->file('file')->store('documents', 'public');

            $document = Document::create([
                'title' => $validated['title'],
                'category_id' => $validated['category_id'],
                'year' => $validated['year'],
                'file_path' => $filePath,
                'created_by' => Auth::id() ?? 1, // Fallback for now
            ]);

            $response->status = 200;
            $response->message = 'Document created successfully';
            $response->data = $this->formatDocument($document);

        } catch (\Exception $e) {
            $response->status = 500;
            $response->message = 'Failed to create document';
            $response->error = $e->getMessage();
        }

        return response()->json($response, $response->status);
    }

    public function update(Request $request, $id)
    {
        \Illuminate\Support\Facades\Log::info('Document update request for ID ' . $id, $request->all());
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'category_id' => 'required|integer|exists:categories,id',
                'year' => 'required|integer',
                'file' => 'nullable|file|max:10240',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::error('Update validation failed for ID ' . $id, $e->errors());
            throw $e;
        }

        $response = (object) [];

        try {
            $document = Document::findOrFail($id);

            if ($request->hasFile('file')) {
                // Delete old file if exists
                if ($document->file_path) {
                    Storage::disk('public')->delete($document->file_path);
                }
                $filePath = $request->file('file')->store('documents', 'public');
                $document->file_path = $filePath;
            }

            $document->update([
                'title' => $validated['title'],
                'category_id' => $validated['category_id'],
                'year' => $validated['year'],
            ]);

            $response->status = 200;
            $response->message = 'Document updated successfully';
            $response->data = $this->formatDocument($document);

        } catch (\Exception $e) {
            $response->status = 500;
            $response->message = 'Failed to update document';
            $response->error = $e->getMessage();
        }

        return response()->json($response, $response->status);
    }

    public function destroy($id)
    {
        $response = (object) [];

        try {
            $document = Document::findOrFail($id);
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            $document->delete();

            $response->status = 200;
            $response->message = 'Document deleted successfully';

        } catch (\Exception $e) {
            $response->status = 500;
            $response->message = 'Failed to delete document';
            $response->error = $e->getMessage();
        }

        return response()->json($response, $response->status);
    }

    private function formatDocument($doc)
    {
        return [
            'id' => $doc->id,
            'title' => $doc->title,
            'category_id' => $doc->category_id,
            'category_name' => $doc->category?->name,
            'year' => $doc->year,
            'file_url' => asset('storage/' . $doc->file_path),
            'created_at' => $doc->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function getCategories()
    {
        $categories = Category::all();
        return response()->json([
            'status' => 200,
            'data' => $categories
        ]);
    }
}
