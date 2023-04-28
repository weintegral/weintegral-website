@extends('layout.main')

@section('title', 'Clients')

@section('content')
    <main id="main">
        @include('about.components.clients.breadcrumbs')
{{--        @include('about.components.clients.portfolio')--}}
        @include('about.components.clients.clients')
        @include('components.placeholderHeight')
    </main>
@endsection
