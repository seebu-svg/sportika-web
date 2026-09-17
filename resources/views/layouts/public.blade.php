<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $settings->site_name ?? 'Sportika')</title>
    <meta name="description" content="@yield('meta_description', $settings->tagline ?? 'Player representation, scouting and sports news.')">
    <meta name="theme-color" content="#0f2557">

    <link rel="icon" type="image/png" href="{{ asset('images/wolf-favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/wolf-favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col">

    <x-navbar :settings="$settings ?? null" />

    <main class="flex-1">
        @yield('content')
    </main>

    <x-footer :settings="$settings ?? null" />

</body>
</html>
