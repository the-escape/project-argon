<label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>
@foreach ($value as $k => $v)
    <textarea id="fields-{{ $field->getId() }}-0" name="{{ $field->getFormFieldName($hash) }}" rows="5" class="form__text form__text--area">{{ $v }}</textarea>
@endforeach
