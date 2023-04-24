@extends('layout.main')

@section('title', 'About')

@section('content')
    <main id="main">
        @include('about.components.index.breadcrumbs')
        @include('about.components.index.about')
        @include('about.components.index.counts')
        @include('about.components.index.clients')
        @include('about.components.index.testimonials')
    </main>
@endsection
