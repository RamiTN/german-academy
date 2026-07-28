<?php

namespace App\Enums;

enum GermanLevel: string
{
    case A1 = 'A1';
    case A2 = 'A2';
    case B1 = 'B1';
    case B2 = 'B2';
    case C1 = 'C1';
    case C2 = 'C2';
    case None = 'none';

    public function label(): string
    {
        return match ($this) {
            self::A1 => 'A1 — Beginner',
            self::A2 => 'A2 — Elementary',
            self::B1 => 'B1 — Intermediate',
            self::B2 => 'B2 — Upper Intermediate',
            self::C1 => 'C1 — Advanced',
            self::C2 => 'C2 — Mastery',
            self::None => 'No Prior Knowledge',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::A1 => 'emerald',
            self::A2 => 'teal',
            self::B1 => 'blue',
            self::B2 => 'indigo',
            self::C1 => 'purple',
            self::C2 => 'amber',
            self::None => 'gray',
        };
    }
}
