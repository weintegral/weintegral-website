@extends('layout.main')

@section('title', 'Home Page')

@section('content')
    <main id="main">
        @include('management.components.breadcrumbs')
        @include('management.components.members')
    </main>
@endsection
