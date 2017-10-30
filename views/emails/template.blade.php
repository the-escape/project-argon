@if(is_scalar($content))

    {!! $content !!}

@else

    @foreach($content as $key => $value)

        <p><strong>{!! $key !!}</strong>: {!! nl2br($value) !!}</p>

    @endforeach

@endif
