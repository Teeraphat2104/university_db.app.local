<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityDocument;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActivitySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->where('role', 'admin')->firstOrFail();
        $categories = Category::query()->pluck('id', 'category_name');

        $activities = [
            [
                'title' => 'Freshman Orientation Camp',
                'description' => 'An introductory program for first-year students covering academic life, campus services, and student community activities.',
                'category_name' => 'Academic',
                'activity_date' => now()->addDays(7)->toDateString(),
                'location' => 'Main Auditorium',
                'organizer' => 'Student Affairs Office',
                'status' => 'published',
                'document_title' => 'Orientation Handbook',
            ],
            [
                'title' => 'Campus Volunteer Cleanup Day',
                'description' => 'A volunteer event focused on improving shared campus spaces and building a culture of responsibility and teamwork.',
                'category_name' => 'Volunteer',
                'activity_date' => now()->addDays(14)->toDateString(),
                'location' => 'Central Courtyard',
                'organizer' => 'Volunteer Club',
                'status' => 'published',
                'document_title' => 'Volunteer Guidelines',
            ],
            [
                'title' => 'Interfaculty Sports Challenge',
                'description' => 'A friendly competition between faculties with football, basketball, and relay matches to encourage student engagement.',
                'category_name' => 'Sports',
                'activity_date' => now()->addDays(20)->toDateString(),
                'location' => 'University Stadium',
                'organizer' => 'Sports Committee',
                'status' => 'draft',
                'document_title' => null,
            ],
            [
                'title' => 'Resume and Interview Workshop',
                'description' => 'A practical workshop helping students prepare resumes, portfolios, and interview answers for internships and job applications.',
                'category_name' => 'Career',
                'activity_date' => now()->addDays(30)->toDateString(),
                'location' => 'Innovation Hub Room 402',
                'organizer' => 'Career Development Center',
                'status' => 'published',
                'document_title' => null,
            ],
        ];

        Storage::disk('public')->makeDirectory('activities/pdf');

        foreach ($activities as $activityData) {
            $activity = Activity::query()->updateOrCreate(
                ['title' => $activityData['title']],
                [
                    'description' => $activityData['description'],
                    'category_id' => $categories[$activityData['category_name']],
                    'activity_date' => $activityData['activity_date'],
                    'location' => $activityData['location'],
                    'organizer' => $activityData['organizer'],
                    'status' => $activityData['status'],
                    'created_by' => $admin->id,
                ]
            );

            if (! $activityData['document_title']) {
                continue;
            }

            $fileName = Str::slug($activityData['document_title']).'.pdf';
            $filePath = 'activities/pdf/'.$fileName;

            Storage::disk('public')->put($filePath, $this->minimalPdfContent($activityData['document_title']));

            ActivityDocument::query()->updateOrCreate(
                ['activity_id' => $activity->id],
                [
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'file_type' => 'application/pdf',
                    'file_size' => Storage::disk('public')->size($filePath),
                    'uploaded_by' => $admin->id,
                ]
            );
        }
    }

    private function minimalPdfContent(string $title): string
    {
        $escapedTitle = str_replace(
            ['\\', '(', ')'],
            ['\\\\', '\\(', '\\)'],
            $title
        );

        $stream = "BT\n/F1 20 Tf\n36 720 Td\n({$escapedTitle}) Tj\nET";
        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Count 1 /Kids [3 0 R] >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
            "<< /Length ".strlen($stream)." >>\nstream\n{$stream}\nendstream",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $index => $object) {
            $offsets[$index + 1] = strlen($pdf);
            $pdf .= ($index + 1)." 0 obj\n{$object}\nendobj\n";
        }

        $xrefOffset = strlen($pdf);

        $pdf .= "xref\n0 ".(count($objects) + 1)."\n";
        $pdf .= "0000000000 65535 f \n";

        foreach (array_slice($offsets, 1) as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        $pdf .= "trailer\n<< /Size ".(count($objects) + 1)." /Root 1 0 R >>\n";
        $pdf .= "startxref\n{$xrefOffset}\n%%EOF";

        return $pdf;
    }
}
