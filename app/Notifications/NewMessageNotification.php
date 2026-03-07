<?php

namespace App\Notifications;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Conversation $conversation,
        public User $sender,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_message',
            'title' => 'رسالة جديدة',
            'body' => 'لديك رسالة جديدة من '.$this->sender->name,
            'url' => route('conversations.show', $this->conversation),
            'conversation_id' => $this->conversation->id,
        ];
    }
}
