@php
$plan = $subscriber->subscription?->plan;
$subscription = $subscriber->subscription;
@endphp
<div id="subscription" class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-base font-semibold leading-6 text-gray-900">{{ $plan->display_name }}</h3>
        <div class="mt-2 text-md font-semibold text-gray-700">
            <span>{{ $plan->currency }}{{ $plan->amount / 100 }}</span> <!----> <i>per</i> {{ $plan->periodicity_type }} 
            <span class="text-gray-400"></span>
        </div>
        <div class="mt-2 max-w-xl text-sm text-gray-500">
            <p>{{ $plan->description }}</p>
            <p class="mt-2 text-sm font-medium text-gray-500 truncate"><span>Next Payment on {{ $subscription->expired_at->format("M d, Y") }}</span></p>
        </div>
        <div class="mt-5">
            @if (data_get($permissions, 'canUpdateSubscription'))
            <button type="button" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500">
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
</div>