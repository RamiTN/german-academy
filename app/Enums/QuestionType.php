<?php

namespace App\Enums;

enum QuestionType: string
{
    case MultipleChoice = 'multiple_choice';
    case TrueFalse = 'true_false';
    case ShortAnswer = 'short_answer';
    case Essay = 'essay';

    public function label(): string
    {
        return match ($this) {
            self::MultipleChoice => 'Multiple Choice',
            self::TrueFalse => 'True / False',
            self::ShortAnswer => 'Short Answer',
            self::Essay => 'Essay',
        };
    }

    public function isAutoGradeable(): bool
    {
        return match ($this) {
            self::MultipleChoice, self::TrueFalse => true,
            self::ShortAnswer, self::Essay => false,
        };
    }
}
