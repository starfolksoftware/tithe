<!doctype html>
<html class="h-full bg-gray-50" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} ― Tithe</title>

    <link href="{{ asset('vendor/tithe/main.css') }}" rel="stylesheet">
    @foreach (config('tithe.styles', []) as $style)
    <link href="{{ $style }}" rel="stylesheet">
    @endforeach
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet" />

    <style>
        .font-cursive {
            font-family: 'Caveat', cursive;
        }
    </style>
</head>

<body class="h-full font-sans antialiased">
    @yield('content')
</body>

</html>