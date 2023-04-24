@extends('layout.main')

@section('title', 'Contact')

@section('content')
    <main id="main">
        @include('management.components.contact.breadcrumbs')
        @include('management.components.contact.info')
    </main>
@endsection
