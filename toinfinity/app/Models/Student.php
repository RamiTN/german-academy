<?php

namespace App\Models;

use App\Enums\GermanLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_group_id',
        'german_level',
        'enrollment_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'german_level' => GermanLevel::class,
            'enrollment_date' => 'date',
        ];
    }

    // ── Relationships ──

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function homeworkSubmissions(): HasMany
    {
        return $this->hasMany(HomeworkSubmission::class);
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function testAttempts(): HasMany
    {
        return $this->hasMany(TestAttempt::class);
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    // ── Helpers ──

    public function getAttendancePercentageAttribute(): float
    {
        $total = $this->attendances()->count();
        if ($total === 0) return 0;

        $present = $this->attendances()->where('status', 'present')->count();
        $late = $this->attendances()->where('status', 'late')->count();

        return round((($present + ($late * 0.5)) / $total) * 100, 1);
    }
}
