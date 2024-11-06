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

                @foreach ($jobGroups as $jobGroup)
                    <tr>
                        <td>{{$jobGroup['name']}}</td>
                        <td>{{$jobGroup['email']}}</td>
                        <td>{{$jobGroup['tech']}}</td>
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
                "pageLength": 10
            });
        });
    </script>
@endsection
