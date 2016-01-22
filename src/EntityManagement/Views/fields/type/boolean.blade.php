<?php

// get the value
//$page_fieldById = isset($page)
//        ? isset($fieldDataIds)
//                ? $page->fieldById($field->getId(), $fieldDataIds)
//                : $page->fieldById($field->getId())
//        : '';

    $isInCombo = $field->getParentId() !== 0;
    $submitted = ($isInCombo) ? old("combo.{$field->getId()}") : old("field.{$field->getId()}");

    if (!$isInCombo) {
        if (isset($latest)) {
            $value = $latest->getField($field->getId());
        } else {
            $value = null;
        }
    }
    else {
        if (!isset($value)) {
            $value = null;
        }
    }

    if ($value === null) {
        $value = new \Escape\Argon\EntityManagement\FieldValues\BooleanFieldValue();
    }

    if (!isset($hash)) {
        $hash = '';
    }
?>


    {{-- Build initial single type field..--}}
    <?php
    $idString = str_replace('.', '', microtime(true));
    $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}]" : "fields[{$field->getId()}]";
    $camelString = ($isInCombo) ? "combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}" : "fields.{$field->getId()}";
    $errorClass = Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, $camelString);


    ?>
<div class="field field-boolean">
    <label>{{ $field->getFieldName() }}</label>

    <div>
        <input type="radio" class="boolean-radio-off" id="{{ $idString }}-off" name="{{ $name }}" value="0" @if(old($camelString, $value) == '0') checked @endif>
        <input type="radio" class="boolean-radio-on" id="{{ $idString }}-on" name="{{ $name }}" value="1" @if(old($camelString, $value) == '1') checked @endif>
        <button type="button" class="boolean-on">On</button><button type="button" class="boolean-off">Off</button>
    </div>
</div>
