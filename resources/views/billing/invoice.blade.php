@extends('tithe::ui-layout')

@section('content')
<!-- Invoice -->
<div class="px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="mx-auto">
        <!-- Card -->
        <div class="flex flex-col p-4 sm:p-10 bg-white shadow-md rounded-xl">
            <!-- Grid -->
            <div class="flex justify-between">
                <div>
                    @if (config('tithe.logo'))
                    <img class="w-10 h-10" src="{{ config('tithe.logo') }}" alt="{{ config('app.name') }}">
                    @endif
                    <h1 class="mt-2 text-lg md:text-xl font-semibold text-primary-600">{{ config('app.name') }}</h1>
                </div>
                <!-- Col -->

                <div class="text-right">
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800">Invoice #</h2>
                    <span class="mt-1 block text-gray-500">INV-{{ $invoice->id }}</span>

                    <address class="mt-4 not-italic text-gray-800">
                        @foreach(config('tithe.billing_address') as $line)
                            {{ $line }},<br>
                        @endforeach
                    </address>
                </div>
                <!-- Col -->
            </div>
            <!-- End Grid -->

            <!-- Grid -->
            <div class="mt-8 grid sm:grid-cols-2 gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Bill to:</h3>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $invoice->subscriber->titheEmail() }}</h3>
                    {{-- <address class="mt-2 not-italic text-gray-500">
                        line,<br>
                    </address> --}}
                </div>
                <!-- Col -->

                <div class="sm:text-right space-y-2">
                    <!-- Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                        <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Date:</dt>
                            <dd class="col-span-2 text-gray-500">{{ $invoice->created_at->format('M d, Y') }}</dd>
                        </dl>
                    </div>
                    <!-- End Grid -->
                </div>
                <!-- Col -->
            </div>
            <!-- End Grid -->

            <!-- Table -->
            <div class="mt-6">
                <div class="border border-gray-200 p-4 rounded-lg space-y-4">
                    <div class="hidden sm:grid sm:grid-cols-5">
                        <div class="sm:col-span-2 text-xs font-medium text-gray-500 uppercase">Item</div>
                        <div class="text-left text-xs font-medium text-gray-500 uppercase">Qty</div>
                        <div class="text-left text-xs font-medium text-gray-500 uppercase">Rate</div>
                        <div class="text-right text-xs font-medium text-gray-500 uppercase">Amount</div>
                    </div>

                    <div class="hidden sm:block border-b border-gray-200"></div>

                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                        <div class="col-span-full sm:col-span-2">
                            <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Item</h5>
                            <p class="font-medium text-gray-800">{{ $invoice->description }}</p>
                        </div>
                        <div>
                            <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Qty</h5>
                            <p class="text-gray-800">1</p>
                        </div>
                        <div>
                            <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Rate</h5>
                            <p class="text-gray-800">{{ $invoice->amount }}</p>
                        </div>
                        <div>
                            <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Amount</h5>
                            <p class="sm:text-right text-gray-800">{{ $invoice->amount }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Table -->

            <!-- Flex -->
            <div class="mt-8 flex sm:justify-end">
                <div class="w-full max-w-2xl sm:text-right space-y-2">
                    <!-- Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                        <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Total:</dt>
                            <dd class="col-span-2 text-gray-500">{{ $invoice->amount }}</dd>
                        </dl>

                        <dl class="grid sm:grid-cols-5 gap-x-3">
                            <dt class="col-span-3 font-semibold text-gray-800">Amount paid:</dt>
                            <dd class="col-span-2 text-gray-500">{{ $invoice->amount }}</dd>
                        </dl>
                    </div>
                    <!-- End Grid -->
                </div>
            </div>
            <!-- End Flex -->

            <div class="mt-8 sm:mt-12">
                <h4 class="text-lg font-semibold text-gray-800">Thank you!</h4>
                <p class="text-gray-500">If you have any questions concerning this invoice, use the following contact information:</p>
                <div class="mt-2">
                    <p class="block text-sm font-medium text-gray-800">{{ config('tithe.contact.email') }}</p>
                    <p class="block text-sm font-medium text-gray-800">{{ config('tithe.contact.phone') }}</p>
                </div>
            </div>

            <p class="mt-5 text-sm text-gray-500">© {{ now()->year }} {{ config('app.name') }}.</p>
        </div>
        <!-- End Card -->

        <!-- Buttons -->
        <div class="mt-6 flex justify-end gap-x-3">
            <a onclick="window.print()" class="inline-flex justify-center items-center gap-x-3 text-center bg-primary-600 hover:bg-primary-700 border border-transparent text-sm text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 focus:ring-offset-white transition py-3 px-4 dark:focus:ring-offset-gray-800" href="#">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                    <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                </svg>
                Print details
            </a>
        </div>
        <!-- End Buttons -->
    </div>
</div>
<!-- End Invoice -->
@endsection