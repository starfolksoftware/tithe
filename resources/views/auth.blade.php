<!doctype html>
<html class="h-full bg-gray-50" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} ― Tithe</title>

    <link href="{{ asset('vendor/tithe/main.css') }}" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="//fonts.googleapis.com/css2?family=Karla&family=Caveat:wght@700&display=swap">

    <style>
        .font-cursive {
            font-family: 'Caveat', cursive;
        }
    </style>
</head>

<body class="h-full">
    @yield('content')
</body>

</html>