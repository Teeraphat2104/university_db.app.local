<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'cover_image',
        'pdf_file',
        'excel_file',
        'participants_count',
        'activity_date',
        'location',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status'        => 'boolean',
            'activity_date' => 'date',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function participants()
    {
        return $this->hasMany(ActivityParticipant::class);
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image
            ? Storage::disk('public')->url($this->cover_image)
            : null;
    }

    public function getPdfUrlAttribute(): ?string
    {
        return $this->pdf_file
            ? Storage::disk('public')->url($this->pdf_file)
            : null;
    }

    public function getExcelUrlAttribute(): ?string
    {
        return $this->excel_file
            ? Storage::disk('public')->url($this->excel_file)
            : null;
    }
}
