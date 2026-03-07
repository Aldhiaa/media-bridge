<?php

namespace App\Notifications;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CampaignStatusNotification extends Notification
{
    use Queueable;

    public function __construct(public Campaign $campaign, public string $statusLabel)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'campaign_status',
            'title' => 'تحديث حالة الحملة',
            'body' => 'الحملة "'.$this->campaign->title.'" أصبحت بحالة: '.$this->statusLabel,
            'url' => route($notifiable->isCompany() ? 'company.campaigns.show' : 'agency.campaigns.show', $this->campaign),
            'campaign_id' => $this->campaign->id,
        ];
    }
}
