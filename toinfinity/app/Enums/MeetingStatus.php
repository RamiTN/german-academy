<?php

namespace App\Enums;

enum MeetingStatus: string
{
    case Scheduled = 'scheduled';
    case Live = 'live';
    case Ended = 'ended';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Scheduled => 'Scheduled',
            self::Live => 'Live Now',
            self::Ended => 'Ended',
            self::Cancelled => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Scheduled => 'blue',
            self::Live => 'red',
            self::Ended => 'gray',
            self::Cancelled => 'gray',
        };
    }
}
