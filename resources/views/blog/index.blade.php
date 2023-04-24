@extends('layout.main')

@section('title', 'Blog')

@section('content')
    <main id="main">
        @include('blog.components.breadcrumbs')
        @include('blog.components.posts')
    </main>
@endsection
