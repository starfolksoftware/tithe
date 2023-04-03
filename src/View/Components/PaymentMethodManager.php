<?php

namespace Tithe\View\Components;

use Illuminate\View\Component;

class PaymentMethodManager extends Component
{
    public mixed $subscriber;

    public mixed $authorizations;

    /**
     * Constructor.
     */
    public function __construct(mixed $subscriber)
    {
        $this->subscriber = $subscriber;
        $this->authorizations = $this->subscriber
            ->authorizations
            ->load('creditCard');
    }

    public function render()
    {
        return view('tithe::components.payment-method-manager');
    }
}
