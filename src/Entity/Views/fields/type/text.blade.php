<label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>
@foreach ($value as $k => $v)
    <input id="fields-{{ $field->getId() }}-0" type="text" class="form__text" name="{{ $field->getFormFieldName($hash) }}" value="{{ $v }}">
@endforeach
