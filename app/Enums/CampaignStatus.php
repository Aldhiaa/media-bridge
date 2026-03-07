<?php

namespace App\Enums;

enum CampaignStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case ReceivingProposals = 'receiving_proposals';
    case UnderReview = 'under_review';
    case Awarded = 'awarded';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'مسودة',
            self::Published => 'منشورة',
            self::ReceivingProposals => 'استقبال عروض',
            self::UnderReview => 'قيد المراجعة',
            self::Awarded => 'تم الترسية',
            self::InProgress => 'قيد التنفيذ',
            self::Completed => 'مكتملة',
            self::Cancelled => 'ملغاة',
        };
    }

    public function allowsProposals(): bool
    {
        return in_array($this, [self::Published, self::ReceivingProposals], true);
    }

    public function canReceiveReview(): bool
    {
        return $this === self::Completed;
    }
}
