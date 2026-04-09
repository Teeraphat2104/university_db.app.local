<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * Store a cover image and return its storage path.
     */
    public function uploadCover(UploadedFile $file): string
    {
        return $file->store('covers', 'public');
    }

    /**
     * Store a PDF file and return its storage path.
     */
    public function uploadPdf(UploadedFile $file): string
    {
        return $file->store('pdfs', 'public');
    }

    /**
     * Delete a file from the public disk.
     */
    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
