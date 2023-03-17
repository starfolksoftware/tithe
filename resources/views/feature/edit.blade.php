@extends('tithe::admin-layout', ['user' => $user])

@section('content')
<form autocomplete="off" method="POST" action="{{ route('features.update', $feature->id) }}" class="space-y-8 divide-y divide-gray-200">
    <div class="space-y-8 divide-y divide-gray-200">
        <div>
            @csrf
            @method('PUT')
            <div>
                <h3 class="text-base font-semibold leading-6 text-gray-900">Update feature</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by making the necessary changes of the information below to update your feature.</p>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <fieldset class="mt-6">
                        <legend class="contents text-sm font-semibold leading-6 text-gray-900">Consumable</legend>
                        <p class="text-sm text-gray-500">Indicate if a feature can be consumed by your customers.</p>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center">
                                <input id="consumable-yes" name="consumable" type="radio" value="1" {{ old('consumable', $feature->consumable) == '1' ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-slate-600 focus:ring-slate-600">
                                <label for="consumable-yes" class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>
                            <div class="flex items-center">
                                <input id="consumable-no" name="consumable" type="radio" value="0" {{ old('consumable', $feature->consumable) == '0' ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-slate-600 focus:ring-slate-600">
                                <label for="consumable-no" class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                        </div>
                    </fieldset>
                    @error('consumable', 'updateFeature')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <fieldset class="mt-6">
                        <legend class="contents text-sm font-semibold leading-6 text-gray-900">Quota</legend>
                        <p class="text-sm text-gray-500">Indicate if a feature should be adjusted according to usage.</p>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center">
                                <input id="quota-yes" name="quota" type="radio" value="1" {{ $feature->quota == '1' ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-slate-600 focus:ring-slate-600">
                                <label for="quota-yes" class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>
                            <div class="flex items-center">
                                <input id="quota-no" name="quota" type="radio" value="0" {{ $feature->quota == '0' ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-slate-600 focus:ring-slate-600">
                                <label for="quota-no" class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                        </div>
                    </fieldset>
                    @error('quota', 'updateFeature')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <fieldset class="mt-6">
                        <legend class="contents text-sm font-semibold leading-6 text-gray-900">Postpaid</legend>
                        <p class="text-sm text-gray-500">Indicate if you charge your customers after feature consumption.</p>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center">
                                <input id="postpaid-yes" name="postpaid" type="radio" value="1" {{ $feature->postpaid == '1' ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-slate-600 focus:ring-slate-600">
                                <label for="postpaid-yes" class="ml-3 block text-sm font-medium leading-6 text-gray-900">Yes</label>
                            </div>
                            <div class="flex items-center">
                                <input id="postpaid-no" name="postpaid" type="radio" value="0" {{ $feature->postpaid == '0' ? 'checked' : '' }} class="h-4 w-4 border-gray-300 text-slate-600 focus:ring-slate-600">
                                <label for="postpaid-no" class="ml-3 block text-sm font-medium leading-6 text-gray-900">No</label>
                            </div>
                        </div>
                    </fieldset>
                    @error('postpaid', 'updateFeature')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="sm:col-span-4">
                    <label for="periodicity_type" class="block text-sm font-medium leading-6 text-gray-900">Interval</label>
                    <div class="mt-2">
                        <input type="hidden" name="periodicity" id="periodicity" value="1">
                        <select id="periodicity_type" name="periodicity_type" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-slate-600 sm:text-sm sm:leading-6">
                            <option value="">--Please choose an option--</option>
                            @foreach(['Year', 'Month', 'Week', 'Day'] as $p) 
                            <option value="{{ $p }}" {{ $feature->periodicity_type === $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('periodicity_type', 'updateFeature')
                    <span class="text-sm text-red-600" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    @error('periodicity', 'updateFeature')
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
            <a href="{{ route('features.show', $feature->id) }}" class="rounded-md bg-white py-2 px-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="ml-3 inline-flex justify-center rounded-md bg-slate-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600">Update</button>
        </div>
    </div>
</form>
@endsection