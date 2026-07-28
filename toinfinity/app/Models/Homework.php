<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'homework';

    protected $fillable = [
        'class_group_id', 'teacher_id', 'title', 'instructions',
        'file_path', 'file_name', 'deadline', 'max_score', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
            'is_published' => 'boolean',
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

    public function submissions(): HasMany
    {
        return $this->hasMany(HomeworkSubmission::class);
    }

    public function isOverdue(): bool
    {
        return $this->deadline->isPast();
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}
