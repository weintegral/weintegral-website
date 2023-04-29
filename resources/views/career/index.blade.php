@extends('layout.main')

@section('title', 'Career')

@section('styles')
    <style>
        body {
            background: #eee;
        }

        .ratings i {
            color: green;
        }

        .install span {
            font-size: 12px;
        }

        .col-md-4 {
            margin-top: 27px;
        }

        img {
            margin: 0 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">

            @include('components.underConstruction')
            @foreach ($jobs as $job)
                <div class="col-md-4">
                    <div class="card p-3">
                        <div class="d-flex flex-row mb-3"><img src="{{ \App\Enums\TechIcons::getIcon($job['primaryTechnology']) }}" width="50" height="50" alt="php">
                            <div class="d-flex flex-column ml-2">
                                <span>{{ $job['primaryTechnology'] }}</span>
                                <span class="text-black-50">{{ $job['role'] }}</span>
                                <span class="ratings">
                                    <i class="fa fa-star">
                                    </i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </span>
                            </div>
                        </div>
                        <h6>{{ $job['brief'] }}</h6>
                        <div class="d-flex justify-content-between install mt-3">
                            <span>Submitted 17 applications</span>
                            <span class="text-primary" data-bs-toggle="modal" data-bs-target="#{{$job['id']}}">View</span>
                        </div>
                        <div class="modal fade" id="{{$job['id']}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Job Description</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {!! $job['jobDescription'] !!}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
