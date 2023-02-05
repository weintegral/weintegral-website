@extends('layout.main')

@section('title', 'Home Page')

@section('content')
    <main id="main">
        @include('blog.components.breadcrumbs')
        @include('blog.components.posts')
    </main>
@endsection
