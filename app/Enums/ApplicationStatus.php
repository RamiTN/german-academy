<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case Pending = 'pending';
    case Accepted = 'accepted';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending Review',
            self::Accepted, self::Approved => 'Approved',
            self::Rejected => 'Rejected',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'amber',
            self::Accepted, self::Approved => 'green',
            self::Rejected => 'red',
        };
    }
}
