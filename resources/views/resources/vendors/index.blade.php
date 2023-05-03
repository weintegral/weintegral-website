@extends('layout.main')

@section('title', 'Resources')

@section('content')
    <main id="main">
        @include('resources.vendors.breadcrumbs')

        <div class="container my-5">
            <table id="vendor-table" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Job Page</th>
                    <th>Approved Vendor</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($vendors as $vendor)
                    <tr>
                        <td>{{$vendor['name']}}</td>
                        <td><a target="_blank" href="{{$vendor['url']}}">Visit</a></td>
                        @if ($vendor['verified'] === true)
                            <td><i class="bi bi-patch-check-fill text-success"></i></td>
                        @else
                            <td><i class="bi bi-patch-exclamation-fill text-danger"></i></td>
                        @endif
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
