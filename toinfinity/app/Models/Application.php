<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use App\Enums\GermanLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'german_level',
        'preferred_schedule', 'message', 'status',
        'admin_notes', 'reviewed_by', 'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ApplicationStatus::class,
            'german_level' => GermanLevel::class,
            'reviewed_at' => 'datetime',
        ];
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isPending(): bool
    {
        return $this->status === ApplicationStatus::Pending;
    }
}
