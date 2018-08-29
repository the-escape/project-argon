<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>

<h1>Test</h1>

<hr>

@if(isset($data))

    {!! (new Illuminate\Support\Debug\Dumper())->dump($data) !!}

@endif

</body>
</html>
