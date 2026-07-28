<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_group_id', 'teacher_id', 'title', 'description',
        'time_limit_minutes', 'is_published', 'available_from', 'available_until',
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
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function isAvailable(): bool
    {
        $now = now();
        if (!$this->is_published) return false;
        if ($this->available_from && $now->lt($this->available_from)) return false;
        if ($this->available_until && $now->gt($this->available_until)) return false;
        return true;
    }

    public function getTotalPointsAttribute(): int
    {
        return $this->questions->sum('points');
    }
}
