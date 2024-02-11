@extends('layout.main')

@section('title', 'Submissions')

@section('content')
    <main id="main">
        @include('management.components.marketing.breadcrumbs')
        @include('components.desktopOnly')
        <div class="container">
            <h2>Submission Data</h2>
            <div id="marketing-submission-data">
                <iframe 
                width="600" 
                height="500"  
                frameborder="0" 
                scrolling="no" 
                src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQD--45vQupz7V4wLSps4ZKVrOzFjDO5PQIVxMo9SIhIuiLadq3EuY-vk_x7Vu5RcoCNx_UDFdM7fEk/pubchart?oid=1328419568&amp;format=interactive"
                >
            </iframe>
            </div>
        </div>
        
    </main>
@endsection
