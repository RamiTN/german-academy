<?php

namespace App\Models;

use App\Enums\MeetingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_group_id', 'teacher_id', 'title',
        'meet_link', 'google_event_id', 'status',
        'scheduled_at', 'started_at', 'ended_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'status' => MeetingStatus::class,
            'scheduled_at' => 'datetime',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
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

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function isLive(): bool
    {
        return $this->status === MeetingStatus::Live;
    }

    public function isEnded(): bool
    {
        return $this->status === MeetingStatus::Ended;
    }

    public function getDurationAttribute(): ?string
    {
        if (!$this->started_at || !$this->ended_at) return null;
        return $this->started_at->diffForHumans($this->ended_at, true);
    }
}
