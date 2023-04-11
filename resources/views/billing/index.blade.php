@extends('tithe::ui-layout')

@section('content')
<div>
    <div>
        <nav class="sm:hidden" aria-label="Back">
            <a href="{{ config('tithe.app_home_url') }}" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                <svg class="-ml-1 mr-1 h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                </svg>
                Back
            </a>
        </nav>
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-4">
                <li>
                    <div class="flex">
                        <a href="{{ config('tithe.app_home_url') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Home</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                        <a href="javascript:;" aria-current="page" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Billing</a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div class="mt-2 md:flex md:items-center md:justify-between sm:mb-6">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Billing</h2>
        </div>
        <div class="my-4 flex flex-shrink-0 md:mt-0 md:ml-4">
            <div class="sm:flex-auto">
                @if (config('tithe.logo'))
                <img class="block h-8 w-auto lg:hidden" src="{{ config('tithe.logo') }}" alt="{{ config('app.name') }}">
                <img class="hidden h-8 w-auto lg:block" src="{{ config('tithe.logo') }}" alt="{{ config('app.name') }}">
                @else
                <h1 class="text-base text-right font-semibold leading-6 text-gray-900">{{ config('app.name') }}</h1>
                @endif
                <p class="mt-2 text-sm text-gray-700">{{ $subscriber->titheDisplayName() }}</p>
            </div>
        </div>
    </div>
    
    <div class="space-y-6">
        <!-- Current Subscription -->
        <x-tithe-subscription-manager :subscriber="$subscriber" :permissions="$permissions" />

        <!-- Payment method -->
        <x-tithe-payment-method-manager :subscriber="$subscriber" />

        <!-- Invoices -->
        <x-tithe-subscription-invoices :invoices="$invoices" />
    </div>
</div>

@endsection