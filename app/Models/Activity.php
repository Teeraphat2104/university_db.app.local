<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\Rule;

class Activity extends Model
{
    use HasFactory;

    public const STATUSES = [
        'draft',
        'published',
        'completed',
        'cancelled',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'activity_date',
        'location',
        'organizer',
        'status',
        'created_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
        ];
    }

    public static function filterRules(bool $allowStatus = false): array
    {
        $rules = [
            'search' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'activity_date_from' => ['nullable', 'date'],
            'activity_date_to' => ['nullable', 'date', 'after_or_equal:activity_date_from'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];

        if ($allowStatus) {
            $rules['status'] = ['nullable', Rule::in(self::STATUSES)];
        }

        return $rules;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function document(): HasOne
    {
        return $this->hasOne(ActivityDocument::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeWithPublicRelations(Builder $query): Builder
    {
        return $query->with(['category', 'creator', 'document']);
    }

    public function scopeWithApiRelations(Builder $query): Builder
    {
        return $query->with(['category', 'creator', 'document.uploader']);
    }

    public function scopeApplyFilters(Builder $query, array $filters, bool $allowStatus = false): Builder
    {
        if (! empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function (Builder $builder) use ($search): void {
                $builder
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('organizer', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if ($allowStatus && ! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['activity_date_from'])) {
            $query->whereDate('activity_date', '>=', $filters['activity_date_from']);
        }

        if (! empty($filters['activity_date_to'])) {
            $query->whereDate('activity_date', '<=', $filters['activity_date_to']);
        }

        return $query;
    }
}
