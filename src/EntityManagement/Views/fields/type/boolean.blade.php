<div class="field field-boolean field-{{ $field->getId() }}">
    <label>{{ $field->getFieldName() }}</label>

    <div>
        <input type="radio" class="boolean-radio-off" id="field-{{ $field->getId() }}-off" name="{{ $field->getFormFieldName($hash) }}" value="0" @if($value->isFalse()) checked @endif>
        <input type="radio" class="boolean-radio-on" id="field-{{ $field->getId() }}-on" name="{{ $field->getFormFieldName($hash) }}" value="1" @if($value->isTrue()) checked @endif>
        <button type="button" class="boolean-on">On</button><button type="button" class="boolean-off">Off</button>
    </div>
</div>