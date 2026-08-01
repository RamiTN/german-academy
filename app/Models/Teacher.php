<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Support\Str;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'bio',
        'experience',
        'certificates',
        'philosophy',
        'profile_image',
        'specializations',
    ];

    protected static function booted(): void
    {
        static::creating(function (Teacher $teacher) {
            if (empty($teacher->slug)) {
                $baseName = $teacher->user ? $teacher->user->name : 'teacher';
                $slug = Str::slug($baseName);
                $originalSlug = $slug;
                $count = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }

                $teacher->slug = $slug;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'certificates' => 'array',
            'specializations' => 'array',
        ];
    }

    // ── Relationships ──

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classGroups(): HasMany
    {
        return $this->hasMany(ClassGroup::class);
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class);
    }

    public function homework(): HasMany
    {
        return $this->hasMany(Homework::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    // ── Helpers ──

    public function getProfileImageUrlAttribute(): ?string
    {
        return $this->profile_image ? asset('storage/' . $this->profile_image) : null;
    }
}
