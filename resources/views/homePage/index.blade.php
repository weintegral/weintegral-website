@extends('layout.main')

@section('title', 'Home')

@section('content')
    @include('homePage.components.hero')

    <main id="main">
        @include('homePage.components.featured')
        @include('homePage.components.about')
        @include('homePage.components.services')
        @include('homePage.components.clients')
    </main>
@endsection
