<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_group_id', 'teacher_id', 'title', 'description',
        'time_limit_minutes', 'available_from', 'available_until', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'available_from' => 'datetime',
            'available_until' => 'datetime',
        ];
    }

    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(TestQuestion::class)->orderBy('order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(TestAttempt::class);
    }

    public function isAvailable(): bool
    {
        $now = now();
        if (!$this->is_published) return false;
        if ($now->lt($this->available_from)) return false;
        if ($now->gt($this->available_until)) return false;
        return true;
    }

    public function getTotalPointsAttribute(): int
    {
        return $this->questions->sum('points');
    }
}
