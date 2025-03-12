<!DOCTYPE html>
<html>
<head>
    <title>Record Data</title>
</head>
<body>
<h1>Record Data</h1>

<p>Here is the data for the record:</p>

<ul>
    @foreach ($data as $key => $value)
        <li><strong>{{ $key }}:</strong> {{ $value }}</li>
    @endforeach
</ul>
</body>
</html>
