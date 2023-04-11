<?php

namespace Tithe\View\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class SubscriptionInvoices extends Component
{
    /**
     * Constructor.
     */
    public function __construct(public Collection $invoices)
    {
        
    }

    public function render()
    {
        return view('tithe::components.subscription-invoices');
    }
}
