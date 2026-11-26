@extends('layout.main')

@section('title', 'Testing')

@section('content')
    <main id="main">
        @include('services.testing.breadcrumbs')
        @include('components.underConstruction')
        @include('components.placeholderHeight')
    </main>
@endsection
