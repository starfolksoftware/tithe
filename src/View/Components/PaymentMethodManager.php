<?php

namespace Tithe\View\Components;

use Illuminate\View\Component;

class PaymentMethodManager extends Component
{
    /**
     * Constructor.
     */
    public function __construct(public $subscriber)
    {
        // 
    }

    public function render()
    {
        return view('tithe::components.payment-method-manager');
    }
}