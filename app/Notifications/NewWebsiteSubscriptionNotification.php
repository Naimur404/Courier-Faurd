<?php

namespace App\Notifications;

use App\Models\WebsiteSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewWebsiteSubscriptionNotification extends Notification
{
    use Queueable;

    public function __construct(
        public WebsiteSubscription $subscription
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Website Subscription',
            'body' => "New {$this->subscription->plan_type} subscription from {$this->subscription->user->name}",
            'subscription_id' => $this->subscription->id,
            'user_name' => $this->subscription->user->name,
            'plan_type' => $this->subscription->plan_type,
            'amount' => $this->subscription->amount,
            'status' => $this->subscription->verification_status,
        ];
    }
}
