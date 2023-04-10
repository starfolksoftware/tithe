<?php

namespace App\Actions\Tithe;

use Tithe\Contracts\HandlesOverdueSubscriptions;

class HandleOverdueSubscription implements HandlesOverdueSubscriptions
{
    /**
     * Handle the provided overdue subscription.
     */
    public function handle(mixed $subscription): void
    {
        $this->ensureSubscriptionIsOverdue($subscription);

        $subscriber = $subscription->subscriber;

        // You may customise the logic to fit your usecase
        $subscription->suppress();
    }

    /**
     * Ensures subscription can be renewed.
     */
    protected function ensureSubscriptionIsOverdue(mixed $subscription): void
    {
        throw_if(
            ! $subscription->is_overdue, 
            'Exception', 
            'Subscription is not overdue.'
        );
    }
}
