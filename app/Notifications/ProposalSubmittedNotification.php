<?php

namespace App\Notifications;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProposalSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(public Proposal $proposal)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'proposal_submitted',
            'title' => 'عرض جديد على حملتك',
            'body' => 'وصل عرض جديد من وكالة '.$this->proposal->agency->name.' على حملة '.$this->proposal->campaign->title,
            'url' => route('company.campaigns.proposals', $this->proposal->campaign),
            'campaign_id' => $this->proposal->campaign_id,
            'proposal_id' => $this->proposal->id,
        ];
    }
}
