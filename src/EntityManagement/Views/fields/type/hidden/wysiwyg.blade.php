@foreach($value as $k => $v)
    <input type="hidden" name="{{ $field->getFormFieldName($hash) }}[]" value="{{ $v }}">
@endforeach
