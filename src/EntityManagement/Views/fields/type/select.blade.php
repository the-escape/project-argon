<?php
//    $isInCombo = $field->getParentId() !== 0;

    if (!isset($hash)) {
        $hash = '';
    }
?>

@if (!$isCloning)
    <div class="field field-select field-{{ $field->getId() }} @if($field->isRequired()) required @endif"
        data-field="{{$field->getId()}}"
        data-hash="{{$hash}}">

        <label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>

        <div class="field-values">
@endif

    @foreach($value as $k => $v)


        @if($field->allowMultiple())
            <div class="input-group sortable-item">
                <div class="input-group-addon sortable-handle">&#8645;</div>
        @endif

            <select name="{{ $field->getFormFieldName($hash) }}" class="form-control">

                <option value="">Please select:</option>

                @foreach($field->getOptions() as $optionId => $optionValue)

                    <?php
                    $optionValue = (is_object($optionValue)) ? (array)$optionValue : [$optionValue => $optionValue];
                    $key = key($optionValue);
                    $value = current($optionValue)
                    ?>

                    <option value="{{ $key }}" @if($key === $v) selected @endif>{{ $value }}</option>

                @endforeach

            </select>

        @if($field->allowMultiple())
            <div class="input-group-addon field-remove">&#10005;</div>
            </div>
        @endif

    @endforeach

@if(!$isCloning)
        </div>
        @if ($field->allowMultiple())
            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>
        @endif
    </div>
@endif