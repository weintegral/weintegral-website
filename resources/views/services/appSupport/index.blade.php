@extends('layout.main')

@section('title', 'App Support')

@section('content')
    <main id="main">
        @include('services.appSupport.breadcrumbs')
        @include('components.underConstruction')
        @include('components.placeholderHeight')
    </main>
@endsection
