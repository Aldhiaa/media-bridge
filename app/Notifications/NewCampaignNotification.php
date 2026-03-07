<?php

namespace App\Notifications;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCampaignNotification extends Notification
{
    use Queueable;

    public function __construct(public Campaign $campaign)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_campaign',
            'title' => 'فرصة جديدة متاحة',
            'body' => 'تم نشر حملة جديدة: '.$this->campaign->title,
            'url' => route('agency.campaigns.show', $this->campaign),
            'campaign_id' => $this->campaign->id,
        ];
    }
}
