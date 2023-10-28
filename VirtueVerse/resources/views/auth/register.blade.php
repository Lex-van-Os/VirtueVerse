@extends('app')

@section('content')

<head>
    @vite('resources/css/app.css')
</head>

<div class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow w-full max-w-md">
        <div class="p-4 text-center">
            <h1 class="text-2xl font-semibold">{{ __('Register') }}</h1>
        </div>
        <form method="POST" action="{{ route('store') }}" class="p-4">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm">{{ __('Name') }}</label>
                <input id="name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm">{{ __('Password') }}</label>
                <input id="password" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password-confirm" class="block text-gray-700 text-sm">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="mb-4">
                <x-forms.combobox-input id="user_role" name="user_role" label="User role" :models="$userRoles" idField="id" valueField="name"></x-forms.combobox-input>

                @error('user_role')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection