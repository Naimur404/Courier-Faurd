<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewApiSubscriptionNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Subscription $subscription
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New API Subscription',
            'body' => "New API subscription from {$this->subscription->user->name} - Plan: {$this->subscription->plan->name}",
            'subscription_id' => $this->subscription->id,
            'user_name' => $this->subscription->user->name,
            'plan_name' => $this->subscription->plan->name,
            'amount' => $this->subscription->amount_paid,
            'status' => $this->subscription->status,
        ];
    }
}
