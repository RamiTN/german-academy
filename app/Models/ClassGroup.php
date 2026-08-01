<?php

namespace App\Models;

use App\Enums\GermanLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Support\Str;

class ClassGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'german_level', 'teacher_id',
        'description', 'max_students', 'is_active',
    ];

    protected static function booted(): void
    {
        static::creating(function (ClassGroup $classGroup) {
            if (empty($classGroup->slug)) {
                $slug = Str::slug($classGroup->name);
                $originalSlug = $slug;
                $count = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }

                $classGroup->slug = $slug;
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
            'german_level' => GermanLevel::class,
            'is_active' => 'boolean',
        ];
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
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

    public function isFull(): bool
    {
        return $this->students()->count() >= $this->max_students;
    }
}
