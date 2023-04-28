@extends('layout.main')

@section('title', 'DevOps')

@section('content')
    <main id="main">
        @include('services.devops.breadcrumbs')
        @include('components.underConstruction')
        @include('components.placeholderHeight')
    </main>
@endsection
