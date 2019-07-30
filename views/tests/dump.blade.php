<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>

<h1>Test</h1>

<hr>

@if(isset($data))

    @if(isLaravelVersionPre("5.7"))
        {!! (new Illuminate\Support\Debug\Dumper())->dump($data) !!}
    @else
        {!! (new Symfony\Component\VarDumper\VarDumper())->dump($data) !!}
    @endif

@endif

</body>
</html>
