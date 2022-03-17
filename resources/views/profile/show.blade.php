@section('title', __('User settings'))
@section('icon', 'account-icon')

<x-app-layout>
    <div>
        @if (Auth::user()->is_student)
            <x-jet-form-section submit="updatePassword">
                <x-slot name="title">
                    {{ __('Student ID') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Update your student ID by making a request with the contact form.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        {{ Auth::user()->student_id }}
                    </div>
                </x-slot>
            </x-jet-form-section>

            <x-jet-section-border />
        @endif

        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            @livewire('profile.update-profile-information-form')

            <x-jet-section-border />
        @endif

        @livewire('update-preferences-form')

        <x-jet-section-border />

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="mt-10 sm:mt-0">
                @livewire('profile.update-password-form')
            </div>

            <x-jet-section-border />
        @endif

        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div class="mt-10 sm:mt-0">
                @livewire('profile.two-factor-authentication-form')
            </div>

            <x-jet-section-border />
        @endif

        <div class="mt-10 sm:mt-0">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>

        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <x-jet-section-border />

            <div class="mt-10 sm:mt-0">
                @livewire('profile.delete-user-form')
            </div>
        @endif
    </div>
</x-app-layout>
