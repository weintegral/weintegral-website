@extends('layout.main')

@section('title', 'Resources')

@section('content')
    <main id="main">
        @include('resources.jobPortals.breadcrumbs')

        <div class="container my-5">
            <table id="vendor-table" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Website</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($jobPortals as $jobPortal)
                    <tr>
                        <td>{{$jobPortal['name']}}</td>
                        <td><a target="_blank" href="{{$jobPortal['url']}}">Visit</a></td>
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
            $('#vendor-table').DataTable({
                "pageLength": 10
            });
        });
    </script>
@endsection
