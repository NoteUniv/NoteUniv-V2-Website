<x-guest-layout>
    <div x-data="{isOpen: false}" class="relative flex flex-col-reverse xl:flex-row w-full overflow-hidden">
        <div class='relative w-full xl:w-1/2 flex h-screen text-nu-primary'>
            <p class="absolute top-[5vw] left-[5vw] xl:hidden" @click="isOpen = true">
                {{ __('What is') }} <span class="text-nu-secondary font-semibold">NoteUniv ?</span>
            </p>
            <div class="m-auto flex flex-col items-center gap-y-12 md:gap-y-16 xl:gap-y-10">
                <div class="flex">
                    <h1 class="text-4xl capitalize w-fit font-bold tracking-wide">{{ __('Register') }}</h1>
                </div>
                <x-jet-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-y-6 bg-white shadow-drop p-6 text-sm w-[90vw] max-w-[450px] xl:min-w-[350px] xl:w-[35vw] xl:max-w-[550px]">
                    @csrf

                    <div>
                        <x-jet-label for="student_id" value="{{ __('Student ID') }}" />
                        <x-jet-input id="student_id" type="number" name="student_id" :value="old('student_id')" minlength="8" maxlength="8" placeholder="12345678" required autofocus autocomplete="student_id" class="input py-2 pr-4 outline-2 outline-nu-primary focus:outline placeholder:text-nu-gray-300 rounded-md" />
                    </div>

                    <div>
                        <x-jet-label for="email" value="{{ __('Email Unistra') }}" />
                        <x-jet-input id="email" type="email" name="email" :value="old('email')" placeholder="{{ __('student@etu.unistra.fr') }}" required class="input py-2 pr-4 outline-2 outline-nu-primary focus:outline placeholder:text-nu-gray-300 rounded-md" />
                    </div>

                    <div>
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="********" class="input py-2 pr-4 outline-2 outline-nu-primary focus:outline placeholder:text-nu-gray-300 rounded-md" />
                    </div>

                    <div>
                        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="password_confirmation" type="password" placeholder="********" name="password_confirmation" required autocomplete="new-password" class="input py-2 pr-4 outline-2 outline-nu-primary focus:outline placeholder:text-nu-gray-300 rounded-md" />
                    </div>

                    <div>
                        <x-jet-label for="email_notifications">
                            <div class="flex items-center text-xs text-gray-600">
                                <x-jet-checkbox name="email_notifications" id="email_notifications" />

                                <div class="ml-2">
                                    {{ __('Receive email notifications') }}
                                </div>
                            </div>
                        </x-jet-label>
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div>
                            <x-jet-label for="terms">
                                <div class="flex items-center text-xs text-gray-600">
                                    <x-jet-checkbox name="terms" id="terms" required />

                                    <div class="ml-2">
                                        {{-- blade-formatter-disable --}}
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '"
                                        class="underline text-gray-600 hover:text-gray-900">' . __('Terms of Service') . '</a>',
                                    'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '"
                                        class="underline text-gray-600 hover:text-gray-900">' . __('Privacy Policy') . '</a>',
                                    ]) !!}
                                    {{-- blade-formatter-enable --}}
                                    </div>
                                </div>
                            </x-jet-label>
                        </div>
                    @endif

                    <x-jet-button class="btn !bg-nu-primary w-full h-10 rounded-md">
                        {{ __('Sign up') }}
                    </x-jet-button>
                </form>
                <div class="flex flex-col items-center">
                    <p>{{ __('Already registered?') }}</p>
                    <a href="{{ route('login') }}" class="btn-link mt-3">
                        <span>{{ __('Log in') }}</span>
                    </a>
                </div>
            </div>
        </div>
        <div x-cloak class="absolute top-0 w-full xl:w-1/2 h-screen bg-nu-primary flex justify-center transform translate-x-full transition-transform duration-500" :class="{'translate-x-0': isOpen}" @click="isOpen = false">
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
