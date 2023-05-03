@extends('layout.main')

@section('title', 'Resources')

@section('content')
    <main id="main">
        @include('resources.clients.breadcrumbs')

        <div class="container my-5">
            <table id="vendor-table" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Career Page</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Technologies Used</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($clients as $client)
                    <tr>
                        <td>{{$client['name']}}</td>
                        <td><a target="_blank" href="{{$client['url']}}">Visit</a></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
