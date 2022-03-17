<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 error</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
    <div class="flex flex-col justify-center items-center h-[100vh] text-center p-6">
        @php
            $controller = new App\Http\Controllers\ApiController();
            $api_data = $controller->getApiData();
        @endphp
        <div class="max-w-[400px] mb-12" style="color: #{{ $api_data['hexCode'] }}">
            @svg(404)
        </div>
        <h2 class="text-xl my-4">{{ __('404 error') }}</h2>
        <p>{{ __('Oops! The page you requested is currently on vacation.') }}</p>
        <p class="pt-2 text-sm" style="color: #{{ $api_data['hexCode'] }}">{{ __('Did you know? People chose to name this color') }} '{{ $api_data['bestName'] }}'</p>
        <p class="text-xs text-nu-gray-400">{{ __('Want to name a color?') }} <a href="https://colornames.org/random" target="_blank">{{ __('Click here!') }}</a></p>

        <div class="flex flex-col items-center m-5">
            <a href="{{ route('login') }}" class="btn-link mt-3">
                <span>{{ __('Back to home page') }}</span>
            </a>
        </div>
    </div>
</body>

</html>
