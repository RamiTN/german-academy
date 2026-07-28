<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id', 'student_id', 'answers',
        'score', 'total_points', 'started_at', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'answers' => 'array',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function isCompleted(): bool
    {
        return $this->completed_at !== null;
    }

    public function getPercentageAttribute(): ?float
    {
        if ($this->total_points === null || $this->total_points === 0) return null;
        return round(($this->score / $this->total_points) * 100, 1);
    }
}
