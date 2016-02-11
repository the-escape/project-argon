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
        $value = new \Escape\Argon\EntityManagement\FieldValues\ItemFieldValue($value);
    } else {

        if ($isInCombo) {
            if (!isset($value)) {
                $value = null;
            } else {
                $value = new \Escape\Argon\EntityManagement\FieldValues\ItemFieldValue($value);
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
        $value = new \Escape\Argon\EntityManagement\FieldValues\ItemFieldValue();
    }

    if (!isset($hash)) {
        $hash = '';
    }
?>


{{-- Build initial single type field..--}}
<div class="field field-item">
    <label>{{ $field->getFieldName() }}</label>

    <select name="{{ $name }}" id="{{ $idString }}" multiple>
        <option value="1">Content Type 1</option>
        <option value="2">Content Type 2</option>
        <option value="3">Content Type 3</option>
    </select>

</div>
