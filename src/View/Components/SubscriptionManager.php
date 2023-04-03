<?php

namespace Tithe\View\Components;

use Illuminate\View\Component;
use Tithe\Tithe;

class SubscriptionManager extends Component
{
    /**
     * Constructor.
     */
    public function __construct(public mixed $subscriber, public array $permissions = [])
    {
        // 
    }

    public function render()
    {
        return view('tithe::components.subscription-manager');
    }
}