@extends('layout.main')

@section('title', 'Industries')

@section('content')
    <main id="main">
        @include('about.components.industries.breadcrumbs')
        @include('about.components.industries.pricing')
    </main>
@endsection
