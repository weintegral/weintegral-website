@extends('layout.main')

@section('title', 'App Dev')

@section('content')
    <main id="main">
        @include('services.appDevelopment.breadcrumbs')
        @include('components.underConstruction')
        @include('components.placeholderHeight')
    </main>
@endsection
