@extends('layout.main')

@section('title', 'Services')

@section('content')
    <main id="main">

        @include('about.components.services.breadcrumbs')

        @include('about.components.services.services')

        @include('about.components.services.skills')

    </main>
@endsection
