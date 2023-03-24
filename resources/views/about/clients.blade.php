@extends('layout.main')

@section('title', 'Home')

@section('content')
    <main id="main">
        @include('about.components.clients.breadcrumbs')
{{--        @include('about.components.clients.portfolio')--}}
        @include('about.components.clients.clients')
    </main>
@endsection
