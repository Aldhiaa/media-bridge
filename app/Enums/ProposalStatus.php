<?php

namespace App\Enums;

enum ProposalStatus: string
{
    case Submitted = 'submitted';
    case Shortlisted = 'shortlisted';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Withdrawn = 'withdrawn';

    public function label(): string
    {
        return match ($this) {
            self::Submitted => 'مرسل',
            self::Shortlisted => 'قائمة مختصرة',
            self::Accepted => 'مقبول',
            self::Rejected => 'مرفوض',
            self::Withdrawn => 'مسحوب',
        };
    }
}
