@extends('tithe::admin-layout', ['user' => $user])

@section('content')
<div class="">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-base font-semibold leading-6 text-gray-900">Plans</h1>
            <p class="mt-2 text-sm text-gray-700">A list of all the plans including their name, interval, amount and currency.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('plans.create') }}" class="block rounded-md bg-slate-600 py-2 px-3 text-center text-sm font-semibold text-white shadow-sm hover:bg-slate-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">
                Add Plan
            </a>
        </div>
    </div>
    <div class="mt-8 flow-root">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                            <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Amount</th>
                            <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Interval</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">View</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($plans as $plan)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $plan?->display_name ?? $plan->name }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{ $plan->currency . $plan->amount }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{ $plan->periodicity_type }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <a href="{{ route('plans.show', $plan->id) }}" class="text-slate-600 hover:text-slate-900">View<span class="sr-only">, {{ $plan?->display_name ?? $plan->name }}</span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{ $plans->links('tithe::paginator') }}
            </div>
        </div>
    </div>
</div>
@endsection