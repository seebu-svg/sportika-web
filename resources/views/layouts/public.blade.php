<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $settings->site_name ?? 'Sportika')</title>
    <meta name="description" content="@yield('meta_description', $settings->tagline ?? 'Player representation, scouting and sports news.')">
    <meta name="theme-color" content="#05070c">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

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
