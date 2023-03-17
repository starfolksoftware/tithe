<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} ― Billing</title>

    <link rel="icon" href="{{ config('tithe.favicon') }}">

    <link href="{{ asset('vendor/tithe/main.css') }}" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="//fonts.googleapis.com/css2?family=Karla&family=Merriweather:wght@400;700&display=swap">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-gray-50">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12 my-0 sm:my-12 border">
        <div class="mx-auto max-w-3xl">
            @yield('content')
        </div>
    </div>

    @stack('modals')

    @stack('scripts')
</body>

</html>