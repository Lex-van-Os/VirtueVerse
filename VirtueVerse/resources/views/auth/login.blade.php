@extends('app')

@section('content')

<head>
    @vite('resources/css/app.css')
</head>

<div class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-lg shadow w-full max-w-md">
        <div class="p-4 text-center">
            <h1 class="text-2xl font-semibold">{{ __('Login') }}</h1>
        </div>
        <form method="POST" action="{{ route('login') }}" class="p-4">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm">{{ __('Password') }}</label>
                <input id="password" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 flex items-center">
                <input class="mr-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="text-gray-700 text-sm">{{ __('Remember Me') }}</label>
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    {{ __('Login') }}
                </button>
            </div>

            @if (Route::has('password.request'))
            <div class="text-center">
                <a class="text-blue-500 text-sm hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection