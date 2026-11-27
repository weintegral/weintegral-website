<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @isset($robotsDirective)
    {{-- Set by the NoIndex middleware on Internal Tools. --}}
    <meta name="robots" content="{{ $robotsDirective }}">
    @endisset

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicons/favicon-16x16.png') }}">

    @viteReactRefresh
    @vite(['resources/js/inertia.tsx', "resources/js/pages/{$page['component']}.tsx"])
    <x-inertia::head>
        <title inertia>WeIntegral</title>
    </x-inertia::head>
</head>

<body class="antialiased">
    <x-inertia::app />
</body>

</html>
