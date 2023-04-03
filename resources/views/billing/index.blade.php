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
        @if ($errors->any())
            <div class="mt-5 text-sm text-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Current Subscription -->
        <x-tithe-subscription-manager :subscriber="$subscriber" :permissions="$permissions" />

        <!-- Payment method -->
        <x-tithe-payment-method-manager :subscriber="$subscriber" />

        <!-- Email Recipients -->
        {{-- <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Email Recipients</h3>
                <div class="mt-2 max-w-xl text-sm text-gray-500">
                    <p>The email addresses that you provide below will receive a download link for the receipt. To enter multiple email addresses, you can separate them by using commas.</p>
                </div>
                <form class="mt-5 sm:flex sm:items-center">
                    <div class="w-full sm:max-w-xs">
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" name="email" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6" placeholder="you@example.com">
                    </div>
                    <button type="submit" class="mt-3 inline-flex w-full items-center justify-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 sm:mt-0 sm:ml-3 sm:w-auto">Save</button>
                </form>
            </div>
        </div> --}}

        <!-- Invoices -->
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Invoices</h1>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none"></div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">#</th>
                                        <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Amount</th>
                                        <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Due</th>
                                        <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Description</th>
                                        <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Status</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">INV-24</td>
                                        <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">NGN200</td>
                                        <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">01 August, 2023</td>
                                        <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">Subscription Invoice</td>
                                        <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">Unpaid</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                            <a href="#" class="text-primary-600 hover:text-primary-900">Download<span class="sr-only">, INV-24</span></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancel Plan -->
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="sm:flex sm:items-start sm:justify-between">
                    <div>
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Cancel Plan</h3>
                        <div class="mt-2 max-w-xl text-sm text-gray-500">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae voluptatibus corrupti atque repudiandae nam.</p>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex sm:flex-shrink-0 sm:items-center">
                        <button type="button" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                            Cancel plan
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection