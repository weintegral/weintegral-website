@extends('layout.main')

@section('title', 'Resources')

@section('content')
    <main id="main">
        @include('resources.breadcrumbs')

        <div class="container my-5">
            <div class="row">
                @foreach ($resources as $resource)
                    <div class="col-sm-6 my-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $resource['title'] }}</h5>
                                <p class="card-text">{{ $resource['brief'] }}</p>
                                <a href="{{ $resource['url'] }}" target="_blank" class="btn btn-secondary">Check</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
