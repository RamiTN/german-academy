<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id', 'type', 'question_text', 'options',
        'correct_answer', 'points', 'order', 'requires_manual_grading',
    ];

    protected function casts(): array
    {
        return [
            'type' => QuestionType::class,
            'options' => 'array',
            'requires_manual_grading' => 'boolean',
        ];
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
}
