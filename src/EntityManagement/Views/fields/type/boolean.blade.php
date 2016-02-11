<?php

// get the value
//$page_fieldById = isset($page)
//        ? isset($fieldDataIds)
//                ? $page->fieldById($field->getId(), $fieldDataIds)
//                : $page->fieldById($field->getId())
//        : '';


    $isInCombo = $field->getParentId() !== 0;

    $idString = str_replace('.', '', microtime(true));
    $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}]" : "fields[{$field->getId()}]";
    $camelString = ($isInCombo) ? "combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}" : "fields.{$field->getId()}";

    $value = old($camelString, @$value);

    if ($value !== null) {
        $value = new \Escape\Argon\EntityManagement\FieldValues\BooleanFieldValue($value);
    } else {

        if ($isInCombo) {
            if (!isset($value)) {
                $value = null;
            } else {
                $value = new \Escape\Argon\EntityManagement\FieldValues\SelectFieldValue($value);
            }
        } else {
            if (isset($latest)) {
                $value = $latest->getField($field->getId());
            } else {
                $value = null;
            }
        }
    }

    if ($value === null) {
        $value = new \Escape\Argon\EntityManagement\FieldValues\BooleanFieldValue($field->getSetting('initial_value'));
    }

    if (!isset($hash)) {
        $hash = '';
    }
?>


{{-- Build initial single type field..--}}
<div class="field field-boolean">
    <label>{{ $field->getFieldName() }}</label>

    <div>
        <input type="radio" class="boolean-radio-off" id="{{ $idString }}-off" name="{{ $name }}" value="0" @if($value->isFalse()) checked @endif>
        <input type="radio" class="boolean-radio-on" id="{{ $idString }}-on" name="{{ $name }}" value="1" @if($value->isTrue()) checked @endif>
        <button type="button" class="boolean-on">On</button><button type="button" class="boolean-off">Off</button>
    </div>
</div>
