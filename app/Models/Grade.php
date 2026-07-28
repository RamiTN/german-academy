<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'gradeable_type', 'gradeable_id',
        'score', 'max_score', 'percentage', 'feedback', 'graded_by',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'max_score' => 'decimal:2',
            'percentage' => 'decimal:2',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function gradeable(): MorphTo
    {
        return $this->morphTo();
    }

    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    public function getLetterGradeAttribute(): string
    {
        return match (true) {
            $this->percentage >= 90 => 'A',
            $this->percentage >= 80 => 'B',
            $this->percentage >= 70 => 'C',
            $this->percentage >= 60 => 'D',
            default => 'F',
        };
    }
}
