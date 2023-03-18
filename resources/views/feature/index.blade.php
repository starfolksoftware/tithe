@extends('tithe::admin-layout', ['user' => $user])

@section('content')
<div class="">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-base font-semibold leading-6 text-gray-900">Features</h1>
            <p class="mt-2 text-sm text-gray-700">A list of all the features including their name, quota, periodicity and more.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('features.create') }}" class="block rounded-md bg-primary-600 py-2 px-3 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                Add Feature
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
                            <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Can be Consumed?</th>
                            <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Has Quota?</th>
                            <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Is Postpaid?</th>
                            <th scope="col" class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Interval</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">View</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($features as $feature)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $feature->name }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $feature->consumable ? 'bg-primary-100 text-primary-800' : 'bg-primary-100 text-primary-800' }}">
                                    {{ $feature->consumable ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $feature->consumable ? 'bg-primary-100 text-primary-800' : 'bg-primary-100 text-primary-800' }}">
                                    {{ $feature->quota ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $feature->consumable ? 'bg-primary-100 text-primary-800' : 'bg-primary-100 text-primary-800' }}">
                                    {{ $feature->postpaid ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">{{ $feature->periodicity_type }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <a href="{{ route('features.show', $feature->id) }}" class="text-primary-600 hover:text-primary-900">View<span class="sr-only">, {{ $feature->name }}</span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $features->links('tithe::paginator') }}
            </div>
        </div>
    </div>
</div>
@endsection