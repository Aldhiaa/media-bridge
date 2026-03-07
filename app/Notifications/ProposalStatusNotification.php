<?php

namespace App\Notifications;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProposalStatusNotification extends Notification
{
    use Queueable;

    public function __construct(public Proposal $proposal, public string $statusLabel)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'proposal_status',
            'title' => 'تحديث حالة العرض',
            'body' => 'تم تحديث حالة عرضك إلى: '.$this->statusLabel,
            'url' => route('agency.proposals.show', $this->proposal),
            'campaign_id' => $this->proposal->campaign_id,
            'proposal_id' => $this->proposal->id,
        ];
    }
}
