<footer class="bg-nu-primary">
    <div
        class="w-full text-white py-8 xl:py-6 px-8 md:px-16 flex flex-col xl:flex-row-reverse justify-between items-center max-w-[1480px] m-auto">
        <div class="flex flex-col items-center xl:flex-row gap-12 xl:gap-x-16">
            <nav
                class="flex flex-col md:flex-row xl:items-center justify-between gap-y-6 md:gap-x-12 xl:gap-x-16 text-xs">
                <a href="" class="hover:underline">{{ __('Contact us') }}</a>
                <a href="{{ route('terms.show') }}" target="_blank" class="hover:underline">{{ __('Terms') }}</a>
                <a href="{{ route('policy.show') }}" target="_blank" class="hover:underline">{{ __('Privacy') }}</a>
                <a href="" class="hover:underline">{{ __('Accessibility') }}</a>
            </nav>
            <div class="flex gap-x-4 text-sm">
                <a href="#" class="p-1.5 bg-white text-nu-primary">FR</a>
                <a href="#" class="p-1.5 transition-colors duration-200 hover:bg-white hover:text-nu-primary">EN</a>
            </div>
        </div>
        <img src="{{ asset('svg/logo-iut.svg') }}" alt="IUT de Haguenau" class="mt-10 md:mt-12 xl:mt-0 w-48">
    </div>
</footer>
