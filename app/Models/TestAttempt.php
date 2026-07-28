<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id', 'student_id', 'answers',
        'auto_score', 'manual_score', 'total_score', 'total_points',
        'graded_by', 'graded_at', 'started_at', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'answers' => 'array',
            'graded_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    public function getPercentageAttribute(): ?float
    {
        if ($this->total_points === null || $this->total_points === 0) return null;
        return round(($this->total_score / $this->total_points) * 100, 1);
    }

    public function needsManualGrading(): bool
    {
        return $this->graded_at === null && $this->completed_at !== null;
    }
}
