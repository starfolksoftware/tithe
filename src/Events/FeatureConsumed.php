<?php

namespace Tithe\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Tithe\Models\Feature;
use Tithe\Models\FeatureConsumption;

class FeatureConsumed
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public $subscriber,
        public Feature $feature,
        public FeatureConsumption $featureConsumption,
    ) {
        //
    }
}
