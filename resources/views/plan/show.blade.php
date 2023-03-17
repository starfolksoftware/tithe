@extends('tithe::admin-layout', ['user' => $user])

@section('content')
<div>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h3 class="text-base font-semibold leading-6 text-gray-900">{{ $plan->display_name ?? $plan->name }} Plan Information</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Plan details and information.</p>
        </div>
        @if ($permissions['canUpdate'] || $permissions['canDelete'])
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <div x-data="{ open: false }" class="relative inline-block text-left">
                <div>
                    <button @click="open = ! open" type="button" class="flex items-center rounded-full bg-white text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 focus:ring-offset-gray-100" id="menu-button" aria-expanded="true" aria-haspopup="true">
                        <span class="sr-only">Open options</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                        </svg>
                    </button>
                </div>

                <!--
                    Dropdown menu, show/hide based on menu state.

                    Entering: "transition ease-out duration-100"
                    From: "transform opacity-0 scale-95"
                    To: "transform opacity-100 scale-100"
                    Leaving: "transition ease-in duration-75"
                    From: "transform opacity-100 scale-100"
                    To: "transform opacity-0 scale-95"
                -->
                <div x-cloak x-show="open" @click.outside="open = false" class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                        @if ($permissions['canUpdate'])
                        <a href="{{ route('plans.edit', $plan->id) }}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">
                            Edit
                        </a>
                        @endif
                        @if ($permissions['canDelete'])
                        <a x-data @click="$store.deletePlan.toggle()" href="javascript:;" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">
                            Delete
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="mt-5 border-t border-gray-200">
        <dl class="sm:divide-y sm:divide-gray-200">
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Unique Identifying Name</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">
                        {{ $plan->name }}
                    </span>
                </dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Display Name</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $plan->display_name }}</dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Interval</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $plan->periodicity_type }}</dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Amount</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $plan->currency . $plan->amount }}</dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Grace Days</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $plan->grace_days }}</dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                <dt class="text-sm font-medium text-gray-500">Description</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $plan->description }}</dd>
            </div>
        </dl>
    </div>
</div>
<div class="my-12">
    {{-- <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select a tab</label>
        <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
        <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-slate-500 focus:outline-none focus:ring-slate-500 sm:text-sm">
            <option selected>Features</option>

            <option>Addons</option>
        </select>
    </div> --}}
    <!-- class="hidden sm:block" -->
    <div>
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="#" class="border-slate-500 text-slate-600 flex whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium" aria-current="page">
                    Features

                    <span class="bg-slate-100 text-slate-600 ml-3 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block">
                        {{ $plan->features_count }}
                    </span>
                </a>

                <!-- Current: "border-slate-500 text-slate-600", Default: "border-transparent text-gray-500 hover:border-gray-200 hover:text-gray-700" -->
                {{-- <a href="#" class="border-transparent text-gray-500 hover:border-gray-200 hover:text-gray-700 flex whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    Addons

                    <!-- Current: "bg-slate-100 text-slate-600", Default: "bg-gray-100 text-gray-900" -->
                    <span class="bg-gray-100 text-gray-900 ml-3 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block">52</span>
                </a> --}}
            </nav>
        </div>
    </div>

    <div class="mt-6 mb-12">
        <div class="bg-white shadow sm:rounded-lg mb-12">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Attach a feature</h3>
                <div class="mt-2 max-w-xl text-sm text-gray-500">
                    <p>Attach a feature to this plan.</p>
                </div>
                <form method="POST" action="{{ route('tithe.plans.attach-feature', $plan->id) }}" class="mt-5 sm:flex sm:items-center">
                    @csrf
                    <div class="w-full sm:max-w-xs">
                        <label for="feature_id" class="sr-only">Feature</label>
                        <select id="feature_id" name="feature_id" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-slate-600 sm:text-sm sm:leading-6">
                            <option value="">--Choose feature--</option>
                            @foreach($features as $feature)
                            <option value="{{ $feature->id }}" {{ old('feature_id') == $feature->id ? 'selected' : '' }}>{{ $feature->name }}</option>
                            @endforeach
                        </select>
                        @error('feature_id', 'attachFeature')
                        <span class="text-sm text-red-600" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="w-full mt-3 sm:max-w-xs sm:mt-0 sm:ml-3 sm:w-auto">
                        <label for="charges" class="sr-only"">Charges</label>
                        <div class="flex rounded-md shadow-sm">
                            <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 px-3 text-gray-500 sm:text-sm">Charges</span>
                            <input type="number" step="0.01" name="charges" id="charges" class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-slate-600 sm:text-sm sm:leading-6" placeholder="0.01">
                        </div>
                        @error('charges', 'attachFeature')
                        <span class="text-sm text-red-600" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="mt-3 inline-flex w-full items-center justify-center rounded-md bg-slate-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600 sm:mt-0 sm:ml-3 sm:w-auto">Attach</button>
                </form>
            </div>
        </div>
        <div>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Features</h1>
                    <p class="mt-2 text-sm text-gray-700">A list of all the features attached to the plan.</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none"></div>
            </div>
            <div class="mt-8">
                @if (count($plan->features) > 0)
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Charges</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">View</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($plan->features as $feature)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">
                                    {{ $feature->name }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ !! $feature->pivot?->charges ? $feature->pivot->charges . ' / ' . $feature->periodicity_type : '' }}</td>
                            <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <a href="{{ route('features.show', $feature->id) }}" class="text-slate-600 hover:text-slate-900">View<span class="sr-only">, {{ $feature->name }}</span></a>
                                <button x-data @click="$store.planFeature.confirmDetachment({{ $feature->id }})" type="button" class="text-slate-600 hover:text-slate-900">Detach<span class="sr-only">, {{ $feature->name }}</span></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="mx-auto max-w-lg">
                    <div class="text-center">
                        <p class="mt-1 text-sm text-gray-500">You haven’t attached any features to this plan.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
<div x-data x-cloak x-show="$store.deletePlan.confirmingDeletion" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Delete Plan</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">{{ $plan->display_name ?? $plan->name }}</span> plan?
                                This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:ml-10 sm:flex sm:pl-4">
                    <form method="POST" action="{{ route('plans.destroy', $plan->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">Delete</button>
                    </form>
                    <button x-data @click="$store.deletePlan.toggle()" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3 sm:mt-0 sm:w-auto">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div x-data x-cloak x-show="$store.planFeature.confirmingDetachment" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Detach Feature</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to detach feature?
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:ml-10 sm:flex sm:pl-4">
                    <form method="POST" action="{{ route('tithe.plans.detach-feature', $plan->id) }}">
                        @csrf
                        <input type="hidden" name="feature_id" x-model="$store.planFeature.detachingFeature">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">Detach</button>
                    </form>
                    <button x-data @click="$store.planFeature.cancelDetachmentConfirmation()" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-3 sm:mt-0 sm:w-auto">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('deletePlan', {
            confirmingDeletion: false,

            toggle() {
                this.confirmingDeletion = ! this.confirmingDeletion
            }
        });

        Alpine.store('planFeature', {
            confirmingDetachment: false,
            detachingFeature: null,

            toggle() {
                this.confirmingDetachment = ! this.confirmingDetachment
            },

            confirmDetachment (feature) {
                this.confirmingDetachment = true;
                this.detachingFeature = feature;
            },

            cancelDetachmentConfirmation () {
                this.confirmingDetachment = false;
                this.detachingFeature = null;
            }
        });
    })
</script>
@endpush