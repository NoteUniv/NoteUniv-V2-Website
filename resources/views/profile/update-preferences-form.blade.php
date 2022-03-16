<x-jet-form-section submit="updatePreferences">
    <x-slot name="title">
        {{ __('Preferences') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your preferences.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Checkbox email notifications -->
        <div class="col-span-6 sm:col-span-4 flex items-center">
            <x-jet-checkbox class="mr-2" id="email_notifications" wire:model.defer="email_notifications" />
            <x-jet-label for="email_notifications" value="{{ __('Email Notifications for new grades') }}" />
            <x-jet-input-error for="email_notifications" class="mt-1" />
        </div>

        <!-- Checkbox for ranking -->
        <div class="col-span-6 sm:col-span-4 flex items-center">
            <x-jet-checkbox class="mr-2" id="is_ranked" wire:model.defer="is_ranked" />
            <x-jet-label for="is_ranked" value="{{ __('Show yourself in the ranking page') }}" />
            <x-jet-input-error for="is_ranked" class="mt-1" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
