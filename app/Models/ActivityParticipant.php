<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityParticipant extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'activity_id',
        'student_id',
        'name',
        'extra_data',
    ];

    protected function casts(): array
    {
        return [
            'extra_data' => 'array',
        ];
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
