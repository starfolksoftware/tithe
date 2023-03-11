<?php

namespace Tithe\Events;

use Illuminate\Foundation\Events\Dispatchable;

class AddingPlan
{
    use Dispatchable;

    /**
     * The user adding the plan.
     *
     * @var mixed
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
