@extends('layout.main')

@section('title', 'Team')

@section('content')
    <main id="main">
        @include('management.components.breadcrumbs')
        @include('management.components.members')
    </main>
@endsection
