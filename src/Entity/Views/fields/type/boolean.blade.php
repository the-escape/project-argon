<label for="field-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>
<label class="switch">
    <input id="field-{{ $field->getId() }}-0" type="checkbox" name="{{ $field->getFormFieldName($hash) }}" value="1" {{ $value->isTrue() ? 'checked' : '' }}>
    <div class="slider">
        <span>YES</span>
        <span>NO</span>
    </div>
</label>
