<x-guest-layout>
    <div x-data="{isOpen: false}" class="relative flex flex-col-reverse xl:flex-row w-full overflow-hidden">
        <div class='relative w-full xl:w-1/2 flex h-screen text-nu-primary'>
            <p class="absolute top-[5vw] left-[5vw] xl:hidden" @click="isOpen = true">
                {{ __('What is') }} <span class="text-nu-secondary font-semibold">NoteUniv ?</span>
            </p>
            <div class="m-auto flex flex-col items-center gap-y-12 md:gap-y-16 xl:gap-y-10">
                <div class="flex">
                    <h1 class="text-4xl capitalize w-fit font-bold tracking-wide">NoteUniv</h1>
                </div>
                <x-jet-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-y-6 bg-white shadow-drop p-6 text-sm w-[90vw] max-w-[450px] xl:min-w-[350px] xl:w-[35vw] xl:max-w-[550px]">
                    @csrf

                    <div>
                        <x-jet-label for="email" class="block mb-1.5" value="{{ __('Email Unistra') }}" />
                        <div class="flex row-reverse h-10">
                            <x-jet-input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="{{ __('Your unistra email') }}"
                                pattern=".+@etu\.unistra\.fr"
                                class="input py-2 pl-14 pr-4 outline-2 outline-nu-primary focus:outline placeholder:text-nu-gray-300 rounded-md"/>
                            <div class="absolute w-10 h-10 bg-nu-gray-200 flex-shrink-0 flex rounded-l-md">
                                <span class="m-auto w-5 h-5 text-white">
                                    @svg(mail-icon)
                                </span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1.5">
                            <x-jet-label for="password" value="{{ __('Password') }}" />
                            @if (Route::has('password.request'))
                                <a class="text-nu-gray-300 text-xs underline" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                        <div class="flex h-10">
                            <x-jet-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="{{ __('Your password') }}"
                                class="input py-2 pl-14 pr-4 outline-2 outline-nu-primary focus:outline placeholder:text-nu-gray-300 rounded-md"/>
                            <div class="absolute w-10 h-10 bg-nu-gray-200 flex-shrink-0 flex rounded-l-md">
                                <span class="m-auto w-5 h-5 text-white">
                                    @svg(password-icon)
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="block">
                        <label for="remember_me" class="flex items-center">
                            <x-jet-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-xs text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <x-jet-button class="btn !bg-nu-primary w-full h-10 rounded-md">
                        {{ __('Log in') }}
                    </x-jet-button>
                </form>

                <div class="flex flex-col items-center">
                    <p>{{ __('Need an account?') }}</p>
                    <a href="{{ route('register') }}" class="btn-link mt-3">
                        <span>{{ __('Sign up') }}</span>
                    </a>
                </div>
            </div>
        </div>
        <div x-cloak
            class="absolute top-0 w-full xl:w-1/2 h-screen bg-nu-primary flex justify-center transform translate-x-full transition-transform duration-500"
            :class="{'translate-x-0': isOpen}" @click="isOpen = false">
            <div class="relative w-full h-full">
                <img src="../images/login-page-top.svg" alt="" class="absolute top-10 left-0 w-[400px]">
                <img src="../images/login-page-bg.svg" alt="" class="m-auto h-full object-cover">
                <img src="../images/login-page-bottom.svg" alt="" class="absolute bottom-10 right-0 w-[600px]">
                <div class="absolute top-[5vw] left-[5vw] h-8 w-8 text-white transform -rotate-90 xl:hidden">
                    @svg(chevron-down)
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

