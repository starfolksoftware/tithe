<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Tithe\Jobs\SubscriptionRenewalJob;
use Tithe\Tests\Mocks\Team;
use Tithe\Tithe;

test('subscription due for renewal can be renewed', function () {
    Bus::fake();

    SubscriptionRenewalJob::dispatch();

    Bus::assertDispatched(SubscriptionRenewalJob::class);
});
