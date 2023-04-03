@php
$plan = $subscriber->subscription?->plan;
$subscription = $subscriber->subscription;
$planName = $plan->display_name;
$planAmount = $plan->currency . ($plan->amount / 100);
$interval = $plan->periodicity_type;
$nextPaymentAt = $subscription->expired_at->format("M d, Y");
@endphp
<div x-data="{ open: false }" id="subscription" class="bg-white shadow sm:rounded-lg">
    <div x-show="!open" class="px-4 py-5 sm:p-6">
        <h3 class="text-base font-semibold leading-6 text-gray-900">{{ $planName }}</h3>
        <div class="mt-2 text-md font-semibold text-gray-700">
            <span>{{ $planAmount }}</span> <!----> <i>per</i> {{ $interval }}
            <span class="text-gray-400"></span>
        </div>
        <div class="mt-2 max-w-xl text-sm text-gray-500">
            <p>{{ $plan->description }}</p>
            <p class="mt-2 text-sm font-medium text-gray-500 truncate"><span>Next Payment on {{ $nextPaymentAt }}</span></p>
        </div>
        <div class="mt-5">
            @if (data_get($permissions, 'canUpdateSubscription'))
            <button @click="open = ! open" type="button" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500">
                Update plan
            </button>
            @else
            <div class="rounded-md bg-yellow-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Important</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>You don't have a payment method. Kindly add a payment method to update subscription.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div x-show="open" class="px-4 py-5 sm:p-6">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Plans</h1>
                <p class="mt-2 text-sm text-gray-700">Your team is on the <strong class="font-semibold text-gray-900">{{ $planName }}</strong> plan. The next payment of $80 will be due on {{ $nextPaymentAt }}.</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button @click="open = ! open" type="button" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="-mx-4 mt-10 ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Plan</th>
                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">Memory</th>
                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">CPU</th>
                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">Storage</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Price</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Select</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="relative py-4 pl-4 pr-3 text-sm sm:pl-6">
                            <div class="font-medium text-gray-900">Hobby</div>
                            <div class="mt-1 flex flex-col text-gray-500 sm:block lg:hidden">
                                <span>4 GB RAM / 4 CPUs</span>
                                <span class="hidden sm:inline">·</span>
                                <span>128 GB SSD disk</span>
                            </div>
                        </td>
                        <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell">4 GB RAM</td>
                        <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell">4 CPUs</td>
                        <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell">128 GB SSD disk</td>
                        <td class="px-3 py-3.5 text-sm text-gray-500">
                            <div class="sm:hidden">$40/mo</div>
                            <div class="hidden sm:block">$40/month</div>
                        </td>
                        <td class="relative py-3.5 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <button type="button" class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white">Select<span class="sr-only">, Hobby</span></button>
                        </td>
                    </tr>

                    <tr>
                        <td class="relative py-4 pl-4 pr-3 text-sm sm:pl-6 border-t border-transparent">
                            <div class="font-medium text-gray-900">
                                Startup

                                <span class="ml-1 text-primary-600">(Current Plan)</span>
                            </div>
                            <div class="mt-1 flex flex-col text-gray-500 sm:block lg:hidden">
                                <span>8 GB RAM / 6 CPUs</span>
                                <span class="hidden sm:inline">·</span>
                                <span>256 GB SSD disk</span>
                            </div>

                            <div class="absolute -top-px left-6 right-0 h-px bg-gray-200"></div>
                        </td>
                        <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell border-t border-gray-200">8 GB RAM</td>
                        <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell border-t border-gray-200">6 CPUs</td>
                        <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell border-t border-gray-200">256 GB SSD disk</td>
                        <td class="px-3 py-3.5 text-sm text-gray-500 border-t border-gray-200">
                            <div class="sm:hidden">$80/mo</div>
                            <div class="hidden sm:block">$80/month</div>
                        </td>
                        <td class="relative py-3.5 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 border-t border-transparent">
                            <button type="button" class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white" disabled>Select<span class="sr-only">, Startup</span></button>

                            <div class="absolute -top-px left-0 right-6 h-px bg-gray-200"></div>
                        </td>
                    </tr>

                    <!-- More plans... -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('subscription', {

        });
    });
</script>
@endpush