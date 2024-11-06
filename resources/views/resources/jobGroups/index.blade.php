@extends('layout.main')

@section('title', 'Job Groups')

@section('content')
    <main id="main">
        @include('resources.jobGroups.breadcrumbs')

        <div class="container my-5">
            <table id="job-group-table" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Technologies</th>
                </tr>
                </thead>
                <tbody>

                @php
                    $pillClasses = [
                        'text-bg-primary',
                        'text-bg-secondary',
                        'text-bg-success',
                        'text-bg-danger',
                        'text-bg-warning',
                        'text-bg-info',
                        'text-bg-dark'
                    ];
                    $pillClassIndex = 0;
                @endphp
                @foreach ($jobGroups as $jobGroup)
                    @php
                        $technologies = explode(', ', $jobGroup['tech']);
                    @endphp
                    <tr>
                        <td><strong>{{$jobGroup['name']}}</strong></td>
                        <td><a href="mailto:{{$jobGroup['email']}}">{{$jobGroup['email']}}</a></td>
                        <td>
                            @foreach ($technologies as $technology)
                                @php
                                    $randomClass = $pillClasses[$pillClassIndex % count($pillClasses)];
                                    $pillClassIndex++;
                                @endphp
                                <span class="badge rounded-pill {{ $randomClass }}">{{ $technology }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#job-group-table').DataTable({
                "pageLength": 10,
                "columnDefs": [
                    { "width": "25%", "targets": 0 },
                    { "width": "25%", "targets": 1 },
                    { "width": "50%", "targets": 2 }
                ]
            });
        });
    </script>
@endsection
