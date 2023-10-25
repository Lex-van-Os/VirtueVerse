<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header class="space-y-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
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

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header class="space-y-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Apply for editor
                            </h2>

                            <div>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    As an editor you have the possibility to moderate the application and have the possibility to modify author information.
                                </p>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
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
                                    {{ __('Apply for editor') }}
                                </x-primary-button>
                            @endif
                            
                        </header>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
