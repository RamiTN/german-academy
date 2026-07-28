<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id', 'type', 'question_text', 'options',
        'correct_answer', 'points', 'order',
    ];

    protected function casts(): array
    {
        return [
            'type' => QuestionType::class,
            'options' => 'array',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function isAutoGradeable(): bool
    {
        return $this->type->isAutoGradeable();
    }

    public function checkAnswer(string $answer): bool
    {
        return mb_strtolower(trim($answer)) === mb_strtolower(trim($this->correct_answer));
    }
}
