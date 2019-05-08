@if($value->isEmpty())
    <input type="hidden" name="{{ $field->getFormFieldName($hash) }}">
@else
    @foreach($value->getIds() as $selectedId)
        <input type="hidden" name="{{ $field->getFormFieldName($hash) }}" value="{{ $selectedId }}">
    @endforeach
@endif
