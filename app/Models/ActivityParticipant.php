<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'student_id',
        'name',
        'faculty',
        'major',
        'year',
        'extra_data',
    ];

    protected function casts(): array
    {
        return [
            'extra_data' => 'array',
            'year'       => 'integer',
        ];
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
