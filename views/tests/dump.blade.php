<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>

<h1>Test</h1>

<hr>

@if(isset($data))

    {!! (new Symfony\Component\VarDumper\VarDumper())->dump($data) !!}

@endif

</body>
</html>
