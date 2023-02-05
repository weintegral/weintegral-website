@extends('layout.main')

@section('title', 'Home Page')

@section('content')
    <main id="main">
        @include('management.components.contact.breadcrumbs')
        @include('management.components.contact.info')
    </main>
@endsection
