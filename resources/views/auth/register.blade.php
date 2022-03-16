<x-guest-layout>
    <div class="m-auto flex flex-col justify-center items-center gap-y-12 md:gap-y-16 xl:gap-y-10 py-8 min-h-screen">
        <div class="flex">
            <h1 class="text-4xl capitalize w-fit font-bold tracking-wide">{{ __('Register') }}</h1>
        </div>
        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}"
            class="flex flex-col gap-y-6 bg-white shadow-drop p-6 text-sm w-[90vw] max-w-[450px] xl:min-w-[350px] xl:w-[35vw] xl:max-w-[550px]">
            @csrf

            <div>
                <x-jet-label for="student_id" value="{{ __('Student ID') }}" />
                <x-jet-input id="student_id" type="number" name="student_id" :value="old('student_id')" minlength="8"
                    maxlength="8" placeholder="12345678" required autofocus autocomplete="student_id"
                    class="input py-2 pr-4 outline-2 outline-nu-primary focus:outline placeholder:text-nu-gray-300 rounded-md" />
            </div>

            <div>
                <x-jet-label for="email" value="{{ __('Email Unistra') }}" />
                <x-jet-input id="email" type="email" name="email" :value="old('email')"
                    placeholder="{{ __('student@etu.unistra.fr') }}" required
                    class="input py-2 pr-4 outline-2 outline-nu-primary focus:outline placeholder:text-nu-gray-300 rounded-md" />
            </div>

            <div>
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="********"
                    class="input py-2 pr-4 outline-2 outline-nu-primary focus:outline placeholder:text-nu-gray-300 rounded-md" />
            </div>

            <div>
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" type="password" placeholder="********"
                    name="password_confirmation" required autocomplete="new-password"
                    class="input py-2 pr-4 outline-2 outline-nu-primary focus:outline placeholder:text-nu-gray-300 rounded-md" />
            </div>

            <div>
                <x-jet-label for="email_notifications">
                    <div class="flex items-center text-xs text-gray-600">
                        <x-jet-checkbox name="email_notifications" id="email_notifications" class="text-nu-primary" />

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
                            <x-jet-checkbox name="terms" id="terms" required class="text-nu-primary" />

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

            <x-jet-button class="btn justify-center !bg-nu-primary w-full h-10 rounded-md">
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
</x-guest-layout>
