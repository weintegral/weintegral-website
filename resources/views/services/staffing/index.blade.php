@extends('layout.main')

@section('title', 'Staffing')

@section('content')
    <main id="main">
        @include('services.staffing.breadcrumbs')
        @include('components.underConstruction')
        @include('components.placeholderHeight')
    </main>
@endsection
