<x-guest-layout>
    <div class="pt-4 bg-gray-100 pb-12">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
                <x-jet-authentication-card-logo />
            </div>

            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                {!! $policy !!}
            </div>

            @if (Auth::user() === null)
                <div class="flex flex-col items-center m-5">
                    <a href="{{ url()->previous() }}" class="btn-link mt-3">
                        <span>{{ __('Back to last page') }}</span>
                    </a>
                </div>
            @elseif (Auth::user()->is_admin)
                <div class="flex flex-col items-center m-5">
                    <a href="{{ route('dashboard-admin') }}" class="btn-link mt-3">
                        <span>{{ __('Back to Admin dashboard') }}</span>
                    </a>
                </div>
            @else
                <div class="flex flex-col items-center m-5">
                    <a href="{{ route('dashboard') }}" class="btn-link mt-3">
                        <span>{{ __('Back to dashboard') }}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
