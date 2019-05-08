@foreach ($value as $hash => $v)
    @foreach($field->getSubFields() as $subField)
        {!! $subField->renderHidden($value->getValueForSubField($hash, $subField->getId()), ['hash' => $hash]) !!}
    @endforeach
@endforeach
