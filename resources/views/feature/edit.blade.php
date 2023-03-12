@extends('tithe::admin-layout', ['user' => $user])

@section('content')
<form autocomplete="off" method="POST" action="{{ route('plans.update', $plan->id) }}" class="space-y-8 divide-y divide-gray-200">
    <div class="space-y-8 divide-y divide-gray-200">
        <div>
            @csrf
            @method('PUT')
            <div>
                <h3 class="text-base font-semibold leading-6 text-gray-900">Update plan</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by making the necessary changes of the information below to update your plan.</p>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="display_name" class="block text-sm font-medium leading-6 text-gray-900">Display name</label>
                    <div class="mt-2">
                        <input type="text" name="display_name" id="display_name" value="{{ $plan->display_name }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                    @error('display_name', 'createPlan')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
                <div class="sm:col-span-4">
                    <label for="amount" class="block text-sm font-medium leading-6 text-gray-900">Amount</label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 flex items-center">
                            <label for="currency" class="sr-only">Currency</label>
                            <select id="currency" name="currency" class="h-full rounded-md border-0 bg-transparent py-0 pl-3 pr-7 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                                <option selected>NGN</option>
                            </select>
                        </div>
                        <input type="number" step="0.01" name="amount" id="amount" value="{{ $plan->amount }}" class="block w-full rounded-md border-0 py-1.5 pl-16 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="2500">
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Convert the amount to the lowest denomination of the currency. For example, NGN2500 will be 250000.</p>
                    @error('amount', 'createPlan')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="sm:col-span-6">
                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                    <div class="mt-2">
                        <textarea id="description" name="description" rows="3" class="block w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6">{{ $plan->description }}</textarea>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Write a few sentences description of the plan.</p>
                    @error('description', 'createPlan')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="sm:col-span-4">
                    <label for="grace_days" class="block text-sm font-medium leading-6 text-gray-900">Grace Days</label>
                    <div class="mt-2">
                        <input type="hidden" name="periodicity" id="periodicity" value="1">
                        <select id="grace_days" name="grace_days" value="{{ $plan->grace_days }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            @foreach (range(1, 7) as $gd)    
                                <option {{ $plan->grace_days === $gd ? 'selected' : '' }}>{{ $gd }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">At the end of a subscription cycle, the grace days represent the days into the next cycle the subscription is considered active without renewal.</p>
                    @error('grace_days', 'createPlan')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="pt-5">
        <div class="flex justify-end">
            <a href="{{ route('plans.show', $plan->id) }}" class="rounded-md bg-white py-2 px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
        </div>
    </div>
</form>
@endsection