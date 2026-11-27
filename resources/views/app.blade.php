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
    {{--
        The slot renders only when SSR is unavailable (with SSR up, Inertia sends the
        server-rendered head instead), so crawlers still get the page's SEO head. It
        mirrors resources/js/components/site/seo.tsx; each tag's `data-inertia` attribute is
        its head-key, so the client-side <Head> replaces it rather than duplicating it.
    --}}
    <x-inertia::head>
        @php($seo = $page['props']['seo'] ?? null)
        @if ($seo)
        @php($fullTitle = $seo['title'].' | WeIntegral')
        @php($canonicalUrl = $page['props']['site']['canonicalUrl'])
        @php($shareImage = $page['props']['site']['shareImage'])
        <title data-inertia="">{{ $fullTitle }}</title>
        <meta name="description" content="{{ $seo['description'] }}" data-inertia="description">
        <link rel="canonical" href="{{ $canonicalUrl }}" data-inertia="canonical">
        <meta property="og:type" content="website" data-inertia="og:type">
        <meta property="og:site_name" content="WeIntegral" data-inertia="og:site_name">
        <meta property="og:locale" content="en_US" data-inertia="og:locale">
        <meta property="og:title" content="{{ $fullTitle }}" data-inertia="og:title">
        <meta property="og:description" content="{{ $seo['description'] }}" data-inertia="og:description">
        <meta property="og:url" content="{{ $canonicalUrl }}" data-inertia="og:url">
        <meta property="og:image" content="{{ $shareImage['url'] }}" data-inertia="og:image">
        <meta property="og:image:width" content="{{ $shareImage['width'] }}" data-inertia="og:image:width">
        <meta property="og:image:height" content="{{ $shareImage['height'] }}" data-inertia="og:image:height">
        <meta property="og:image:alt" content="{{ $shareImage['alt'] }}" data-inertia="og:image:alt">
        <meta name="twitter:card" content="summary_large_image" data-inertia="twitter:card">
        <meta name="twitter:title" content="{{ $fullTitle }}" data-inertia="twitter:title">
        <meta name="twitter:description" content="{{ $seo['description'] }}" data-inertia="twitter:description">
        @else
        <title data-inertia="">WeIntegral</title>
        @endif
    </x-inertia::head>
</head>

<body class="antialiased">
    <x-inertia::app />
</body>

</html>
