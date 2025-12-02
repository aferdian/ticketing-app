@extends('layouts.auth')

@section('title', 'Select Organization')

@section('content')
<div class="flex flex-col items-center justify-center p-4">
    <div class="text-center mb-8">
        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600">
            <i class="ri-dashboard-3-line text-3xl text-white"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('Select an Organization') }}</h1>
        <p class="text-gray-600 dark:text-gray-400">
            {{ __('You are logged in as') }} <span class="font-semibold">{{ Auth::user()->email }}</span>.
            {{ __('Select an organization to continue.') }}
        </p>
    </div>

    <div class="w-full max-w-md space-y-4">
        @foreach ($userOrganizations as $organization)
            <form method="POST" action="{{ route('organization.select.post') }}" class="w-full">
                @csrf
                <input type="hidden" name="organization_id" value="{{ $organization->id }}">
                <button type="submit"
                    class="w-full flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm text-base font-medium text-gray-900 dark:text-white bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 cursor-pointer">
                    <i class="ri-building-line mr-2"></i>
                    {{ $organization->name }}
                </button>
            </form>
        @endforeach

        @error('organization_id')
            <div class="text-red-500 text-sm text-center mt-4" role="alert">
                <strong>{{ $message }}</strong>
            </div>
        @enderror
    </div>
</div>
@endsection