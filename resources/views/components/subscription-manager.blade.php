@php
$subscription = $subscriber->subscription;
if (!!$subscription) {
$plan = $subscription?->plan;
$planName = $plan->display_name;
$planAmount = $plan->currency . round((float) ($plan->amount / 100), 2);
$interval = $plan->periodicity_type;
$nextPaymentAt = $subscription->expired_at->format("M d, Y");
}
$planPeriodicityTypes = collect($plans)->keys()->toArray();
$defaultTab = collect($plans)->keys()->first();
@endphp
<div x-data="{ open: false, current_tab: '{{ $defaultTab }}' }" id="subscription" class="bg-white shadow sm:rounded-lg">
    @error('upgrade-error', 'upgradeSubscription')
    <div class="px-4 py-5 sm:p-6">
        <span class="text-sm text-red-600">
            {{ $message }}
        </span>
    </div>
    @enderror
    @error('downgrade-error', 'downgradeSubscription')
    <div class="px-4 py-5 sm:p-6">
        <span class="text-sm text-red-600">
            {{ $message }}
        </span>
    </div>
    @enderror
    @error('cancel-pending-downgrade-error', 'cancelPendingDowngrade')
    <div class="px-4 py-5 sm:p-6">
        <span class="text-sm text-red-600">
            {{ $message }}
        </span>
    </div>
    @enderror
    @if (session('upgrade-subscription-success') == true)
    <div class="rounded-md bg-green-50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">Yay! Your subscription upgrade has been successful.</p>
            </div>
        </div>
    </div>
    @endif
    @if (session('downgrade-subscription-success') == true)
    <div class="rounded-md bg-green-50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">
                    Your subscription has been flagged for downgrade at the end of the
                    current billing cycle. Feel free to cancel anytime before then.
                </p>
            </div>
        </div>
    </div>
    @endif
    @if (session('cancel-pending-downgrade-success') == true)
    <div class="rounded-md bg-green-50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">Your pending downgrade has been cancelled successfully.</p>
            </div>
        </div>
    </div>
    @endif
    <div x-show="!open" class="px-4 py-5 sm:p-6">
        @if ($subscription)
        <div class="mb-5">
            <h3 class="text-base font-semibold leading-6 text-gray-900">{{ $planName }}</h3>
            <div class="mt-2 text-md font-semibold text-gray-700">
                <span>{{ $planAmount }}</span> <!----> <i>per</i> {{ $interval }}
                <span class="text-gray-400"></span>
            </div>
            <div class="mt-2 max-w-xl text-sm text-gray-500">
                <p>{{ $plan->description }}</p>
                <p class="mt-2 text-sm font-medium text-gray-500 truncate"><span>Next Payment on {{ $nextPaymentAt }}</span></p>
            </div>
        </div>
        @endif
        <div class="mt-5">
            @if (data_get($permissions, 'canUpdateSubscription'))
            <button @click="open = ! open" type="button" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500">
                Update plan
            </button>
            @elseif (!!!$subscriber->defaultAuthorization())
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
            @elseif ($subscriber->hasPendingDowngrade())
            <div class="p-4 mb-4 text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-lg font-medium">Pending Downgrade</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    Your subscription will be downgraded to <span class="font-bold">{{ data_get($subscriber->subscription->meta, 'to_plan_label') }}</span> 
                    on <span class="font-bold">{{ data_get($subscriber->subscription->meta, 'switch_starts_at') }}</span>.
                </div>
                <div class="flex">
                    <button @click="$store.subscription.confirmingPendingDowngradeCancellation = true" type="button" class="text-white bg-yellow-800 hover:bg-yellow-900 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-1.5 mr-2 text-center inline-flex items-center dark:bg-yellow-300 dark:text-gray-800 dark:hover:bg-yellow-400 dark:focus:ring-yellow-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="-ml-0.5 mr-2 h-4 w-4">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                        Cancel pending downgrade
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div x-show="open" class="px-4 py-5 sm:p-6">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Plans</h1>
                @if ($subscription)
                <p class="mt-2 text-sm text-gray-700">
                    Your team is on the <strong class="font-semibold text-gray-900">{{ $planName }}</strong>
                    plan. The next payment of {{ $planAmount }} will be due on {{ $nextPaymentAt }}.
                </p>
                @else
                <p class="mt-2 text-sm text-gray-700">
                    You do not have an active subscription.
                </p>
                @endif
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button @click="open = ! open" type="button" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="mt-6">
            <nav class="flex" aria-label="Tabs">
                <template x-for="tab in JSON.parse('{{ json_encode($planPeriodicityTypes) }}')">
                    <a href="javascript:;" @click="current_tab = tab" :class="current_tab == tab ? 'bg-gray-100 text-gray-700' : 'text-gray-500 hover:text-gray-700'" class="rounded-md px-3 py-2 text-sm font-medium" :aria-current="current_tab == tab ? 'page' : ''" x-text="tab" />
                </template>
            </nav>
        </div>
        <div class="-mx-4 mt-6 ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Plan</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Price</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Select</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-y-transparent">
                    <template x-for="plan in JSON.parse('{{ json_encode($plans) }}')[current_tab]">
                        <tr>
                            <td class="relative py-4 pl-4 pr-3 text-sm sm:pl-6">
                                <div class="inline-flex items-center">
                                    <span class="font-medium text-gray-900" x-text="plan.display_name"></span>
                                    <template x-if="plan.user_current">
                                        <span class="ml-1 text-primary-600">(Current Plan)</span>
                                    </template>
                                    <div x-data="{ popover_open: false }">
                                        <p class="inline-flex items-center text-gray-500 dark:text-gray-400">
                                            <button @click="popover_open = ! popover_open" type="button">
                                                <svg class="w-5 h-5 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Show features</span>
                                            </button>
                                        </p>
                                        <div x-show="popover_open" role="tooltip" class="absolute z-50 inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm w-72">
                                            <div class="p-3 space-y-2">
                                                <h3 class="font-semibold text-gray-900">
                                                    Features
                                                </h3>
                                                <ul class="mb-8 space-y-4 text-left text-gray-500">
                                                    <template x-for="feature in plan.features">
                                                        <li class="flex items-center space-x-3">
                                                            <!-- Icon -->
                                                            <svg class="flex-shrink-0 w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            <span x-text="feature.label"></span>
                                                        </li>
                                                    </template>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <template x-if="plan.user_current">
                                    <div class="absolute -top-px left-6 right-0 h-px bg-gray-200"></div>
                                </template>
                            </td>
                            <td class="px-3 py-3.5 text-sm text-gray-500">
                                <div x-text="`${plan.currency + (plan.amount / 100)}/${plan.periodicity_type}`"></div>
                            </td>
                            <td class="relative py-3.5 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <template x-if="plan.update_charge > 0">
                                    <button @click="$store.subscription.confirmSubscriptionUpgrade(plan.name)" type="button" class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white" :disabled="plan.user_current">
                                        <span>Upgrade</span>
                                        <span class="sr-only" x-text="', ' + plan.display_name"></span>
                                        <span x-text="plan.update_charge > 0 ? `&nbsp;at ${plan.currency + plan.update_charge}` : ''"></span>
                                    </button>
                                </template>
                                <template x-if="plan.update_charge <= 0">
                                    <button @click="$store.subscription.confirmSubscriptionDowngrade(plan.name)" type="button" class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white" :disabled="plan.user_current">
                                        <span x-text="plan.user_current ? 'Current' : 'Downgrade'"></span>
                                        <span class="sr-only" x-text="', ' + plan.display_name"></span>
                                        <span x-text="plan.update_charge > 0 ? `&nbsp;at ${plan.currency + plan.update_charge}` : ''"></span>
                                    </button>
                                </template>

                                <template x-if="plan.user_current">
                                    <div class="absolute -top-px left-0 right-6 h-px bg-gray-200"></div>
                                </template>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('modals')
<div x-data x-cloak x-show="$store.subscription.confirmingSubscriptionUpgrade" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Subscription Upgrade</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                You are about to upgrade your subscription. Your card might be charged for this update. Continue?
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:ml-10 sm:flex sm:pl-4">
                    <form method="POST" action="{{ route('tithe.billing.upgrade-subscription') }}">
                        @csrf
                        <input type="hidden" name="planName" x-model="$store.subscription.upgradingToPlan">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">
                            Continue
                        </button>
                    </form>
                    <button x-data @click="$store.subscription.cancelSubscriptionUpgrade()" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3 sm:mt-0 sm:w-auto">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div x-data x-cloak x-show="$store.subscription.confirmingSubscriptionDowngrade" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Subscription Downgrade</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                You are about to downgrade your subscription. It will take effect at the end of the current billing cycle. Continue?
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:ml-10 sm:flex sm:pl-4">
                    <form method="POST" action="{{ route('tithe.billing.downgrade-subscription') }}">
                        @csrf
                        <input type="hidden" name="planName" x-model="$store.subscription.downgradingToPlan">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">
                            Continue
                        </button>
                    </form>
                    <button x-data @click="$store.subscription.cancelSubscriptionDowngrade()" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3 sm:mt-0 sm:w-auto">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div x-data x-cloak x-show="$store.subscription.confirmingPendingDowngradeCancellation" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Pending Downgrade Cancellation</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                You are about to cancel your pending downgrade cancellation. Continue?
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:ml-10 sm:flex sm:pl-4">
                    <form method="POST" action="{{ route('tithe.billing.cancel-pending-downgrade') }}">
                        @csrf
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">
                            Cancel pending downgrade
                        </button>
                    </form>
                    <button x-data @click="$store.subscription.confirmingPendingDowngradeCancellation = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3 sm:mt-0 sm:w-auto">
                        Nevermind
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('subscription', {
            confirmingSubscriptionUpgrade: false,
            upgradingToPlan: null,
            confirmingSubscriptionDowngrade: false,
            downgradingToPlan: null,
            confirmingPendingDowngradeCancellation: false,

            confirmSubscriptionUpgrade(plan) {
                this.confirmingSubscriptionUpgrade = true;
                this.upgradingToPlan = plan;
            },

            cancelSubscriptionUpgrade() {
                this.confirmingSubscriptionUpgrade = false;
                this.upgradingToPlan = null;
            },

            confirmSubscriptionDowngrade(plan) {
                this.confirmingSubscriptionDowngrade = true;
                this.downgradingToPlan = plan;
            },

            cancelSubscriptionDowngrade() {
                this.confirmingSubscriptionDowngrade = false;
                this.downgradingToPlan = null;
            },
        });
    });
</script>
@endpush