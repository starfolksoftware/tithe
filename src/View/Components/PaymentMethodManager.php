<?php

namespace Tithe\View\Components;

use Illuminate\View\Component;
use Tithe\Tithe;

class PaymentMethodManager extends Component
{
    /**
     * @var $subscriber
     */
    public $subscriber;

    /**
     * @var $authorizations
     */
    public $authorizations;

    /**
     * Constructor.
     */
    public function __construct(mixed $subscriber)
    {
        $this->subscriber = $subscriber;
        $this->authorizations = call_user_func(Tithe::$activeSubscriberCallback)
            ->authorizations
            ->load('creditCard');
    }

    public function render()
    {
        return view('tithe::components.payment-method-manager');
    }
}
