<footer class="bg-nu-primary">
    <div class="w-full text-white py-8 xl:py-6 px-8 md:px-16 flex flex-col xl:flex-row justify-between items-center max-w-[1480px] m-auto">
        <img src="{{ asset('svg/logo-iut.svg') }}" alt="IUT de Haguenau" class="mb-10 md:mb-12 xl:mb-0 w-48">
        <nav class="flex flex-col md:flex-row xl:items-center justify-between gap-y-6 md:gap-x-12 xl:gap-x-16 text-xs">
            <a href="">{{ __('Contact us') }}</a>
            <a href="{{ route('terms.show') }}" target="_blank">{{ __('Terms') }}</a>
            <a href="{{ route('policy.show') }}" target="_blank">{{ __('Privacy') }}</a>
            <a href="">{{ __('Accessibility') }}</a>
        </nav>
    </div>
</footer>
