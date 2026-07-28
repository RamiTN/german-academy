<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_group_id', 'teacher_id', 'title', 'description',
        'type', 'file_path', 'file_name', 'external_url',
        'file_size', 'download_count',
    ];

    public function classGroup(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : $this->external_url;
    }

    public function getFileSizeFormattedAttribute(): ?string
    {
        if (!$this->file_size) return null;
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $i = 0;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        return round($size, 1) . ' ' . $units[$i];
    }

    public function getIconAttribute(): string
    {
        return match ($this->type) {
            'pdf' => 'document-text',
            'ppt' => 'presentation-chart-bar',
            'image' => 'photo',
            'video' => 'play-circle',
            'link' => 'link',
            default => 'document',
        };
    }
}
