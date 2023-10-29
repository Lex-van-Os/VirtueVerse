@extends('app')

@section('content')
<head>
    @vite('resources/css/app.css')
</head>

<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-gray-100 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Profile Information') }}
                        </h2>
        
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Update your username and your email address.") }}
                        </p>
                    </header>
        
                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')
        
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
        
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
        
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
        
                            @if (session('status') === 'profile-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </section>                
            </div>
        </div>
        
        <div class="p-4 sm:p-8 bg-gray-100 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header class="space-y-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            Study trajectories
                        </h2>
        
                        <div class="flex items-center gap-4">
                            <x-primary-button href="{{ route('study-trajectory.catalogue', $user->id) }}">
                                {{ __('View my study trajectories') }}
                            </x-primary-button>
                        </div>
                    </header>
                </section>
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-gray-100 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header class="space-y-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            Apply for editor
                        </h2>
        
                        <div>
                            <p class="mt-1 text-sm text-gray-600">
                                As an editor, you have the possibility to moderate the application and have the ability to modify author information.
                            </p>
                            <p class="mt-1 text-sm text-gray-600">
                                To apply for the editor role, you must have created at least five records in either the book or book edition categories.
                            </p>
                        </div>
        
                        @if ($displayEditorButton)
                            <form method="POST" action="{{ route('profile.applyForEditor') }}">
                                @csrf
                                @method('PATCH')
        
                                <x-primary-button type="submit">
                                    {{ __('Apply for editor') }}
                                </x-primary-button>
                            </form>
                        @else
                            <x-primary-button disabled>
                                {{ __('Cannot apply') }}
                            </x-primary-button>
                        @endif
                    </header>
                </section>
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-gray-100 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Update Password') }}
                        </h2>
        
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('When updating your password, please remember to provide a secure password.') }}
                        </p>
                    </header>
        
                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')
        
                        <div>
                            <x-input-label for="current_password" :value="__('Current Password')" />
                            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full bg-white border-gray-300" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>
        
                        <div>
                            <x-input-label for="password" :value="__('New Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full bg-white border-gray-300" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>
        
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-white border-gray-300" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>
        
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
        
                            @if (session('status') === 'password-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-gray-100 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section class="space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Delete Account') }}
                        </h2>
                
                    <form method="post" action="{{ route('profile.destroy') }}" class="">
                        @csrf
                        @method('delete')
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Once your account is deleted, your created books and book editions will be left intact. However, your study trajectory information will be deleted. Please enter your password to delete your account.') }}
                        </p>
                
                        <div class="mt-6">
                            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                class="mt-1 block w-3/4 bg-white border-gray-300"
                                placeholder="{{ __('Password') }}"
                            />
                
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>
                
                
                        <x-danger-button class="mt-6">
                            {{ __('Delete Account') }}
                        </x-danger-button>
                    </form>
                </section>             
            </div>
        </div>
    </div>
</div>

@endsection