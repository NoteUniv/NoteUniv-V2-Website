<x-guest-layout>
    <div class="m-auto flex flex-col justify-center items-center gap-y-12 md:gap-y-16 xl:gap-y-10 py-8 min-h-screen">
        <div class="flex">
            <h1 class="text-4xl capitalize w-fit font-bold tracking-wide">{{ __('Contact us') }}</h1>
        </div>

        <x-jet-validation-errors class="mb-4" />

        <form class="flex flex-col gap-y-6 bg-white shadow-drop p-6 text-sm w-[90vw] max-w-[450px] xl:min-w-[350px] xl:w-[35vw] xl:max-w-[550px]">
            <p class="text-xs text-nu-gray-400">{{ __('Your message will be sent directly to the site administrators, i.e. to the grade managers of the IUT de Haguenau as well as to the site developers.') }}</p>
            <div>
                <x-jet-label for="object" value="{{ __('Object') }}" />
                <x-jet-input id="object" type="text" name="object" required class="input py-2 pr-4 outline-2 outline-nu-primary focus:outline placeholder:text-nu-gray-300 rounded-md" />
            </div>

            <div>
                <x-jet-label for="message" value="{{ __('Message') }}" />
                <textarea id="message" name="message" required class="input py-2 pr-4 outline-2 shadow outline-nu-primary focus:outline placeholder:text-nu-gray-300 rounded-md min-h-[200px]"></textarea>
            </div>

            <x-jet-button class="btn justify-center !bg-nu-primary w-full h-10 rounded-md">
                {{ __('Send') }}
            </x-jet-button>
        </form>
        @if (Auth::user()->is_admin)
            <div class="flex flex-col items-center">
                <a href="{{ route('dashboard-admin') }}" class="btn-link mt-3">
                    <span>{{ __('Back to Admin dashboard') }}</span>
                </a>
            </div>
        @else
            <div class="flex flex-col items-center">
                <a href="{{ route('dashboard') }}" class="btn-link mt-3">
                    <span>{{ __('Back to dashboard') }}</span>
                </a>
            </div>
        @endif
    </div>
</x-guest-layout>
