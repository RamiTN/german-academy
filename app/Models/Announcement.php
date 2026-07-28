<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_group_id', 'teacher_id', 'created_by',
        'title', 'content', 'is_pinned', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'published_at' => 'datetime',
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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeGlobal($query)
    {
        return $query->whereNull('class_group_id');
    }

    public function scopeForClass($query, $classGroupId)
    {
        return $query->where(function ($q) use ($classGroupId) {
            $q->whereNull('class_group_id')
              ->orWhere('class_group_id', $classGroupId);
        });
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }
}
