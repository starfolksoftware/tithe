<?php

use Illuminate\Support\Facades\Bus;
use Tithe\Jobs\SubscriptionRenewalJob;

test('subscription due for renewal can be renewed', function () {
    Bus::fake();

    SubscriptionRenewalJob::dispatch();

    Bus::assertDispatched(SubscriptionRenewalJob::class);
});
