<x-guest-layout>
    <div class="flex flex-col items-center justify-center gap-y-12 md:gap-y-16 xl:gap-y-10 py-8 min-h-screen">
        <div class="flex">
            <h1 class="text-4xl w-fit font-bold tracking-wide">{{ __('Forgot Password') }}</h1>
        </div>
        <x-jet-validation-errors class="mb-4" />



        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}"
            class="flex flex-col gap-y-6 bg-white shadow-drop p-6 text-sm w-[90vw] max-w-[450px] xl:min-w-[350px] xl:w-[35vw] xl:max-w-[550px]">
            @csrf

            <div class="mb-2 text-sm text-gray-600 max-w-[450px]">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>
            <div class="block">
                <x-jet-label for="email" value="{{ __('Email Unistra') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Email Password Reset Link') }}
                </x-jet-button>
            </div>
        </form>
    </div>
</x-guest-layout>
