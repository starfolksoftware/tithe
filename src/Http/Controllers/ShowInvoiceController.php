<?php

namespace Tithe\Http\Controllers;

use Illuminate\Routing\Controller;
use Tithe\Tithe;

class ShowInvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(int $invoiceId): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        $invoice = Tithe::subscriptionInvoiceModel()::findOrFail($invoiceId);

        return view('tithe::billing.invoice', compact('invoice'));
    }
}
