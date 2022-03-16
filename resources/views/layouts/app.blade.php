<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">


    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/manifest.js') }}" defer></script>
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased bg-nu-gray-100">
    <x-jet-banner />
    <div class="flex w-full overflow-hidden">
        <x-sidebar />
        <div class="h-screen max-h-screen flex flex-col flex-grow min-w-0 overflow-x-hidden overflow-y-auto">
            <div class="flex-grow">
                <x-header />
                <main class="mb-16 px-4 md:px-12 max-w-[1480px] m-auto">
                    {{ $slot }}
                </main>
            </div>
            <x-footer />
        </div>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>
