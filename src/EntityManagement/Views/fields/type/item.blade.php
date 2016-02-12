<?php

// get the value
//$page_fieldById = isset($page)
//        ? isset($fieldDataIds)
//                ? $page->fieldById($field->getId(), $fieldDataIds)
//                : $page->fieldById($field->getId())
//        : '';

    $options = $field->getOptions();
    $isInCombo = $field->getParentId() !== 0;

    $idString = str_replace('.', '', microtime(true));
    /* multiple select so input name as array */
    $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}][]" : "fields[{$field->getId()}][]";
    /* name for hidden input as fallback to register field submission, since otherwise not present in $_POST */
    $hdnName = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}]" : "fields[{$field->getId()}]";
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

    @if(!$options->isEmpty())
    <input type="hidden" name="{{ $hdnName }}">
    <select name="{{ $name }}" id="{{ $idString }}" class="form-control" multiple>
        {{--Allow to undo selection, only if field not required--}}
        @if(!$field->isRequired())
            <option value="">Please select:</option>
        @endif
        @foreach($options as $entity)
            <option value="{{ $entity->id }}"@if(in_array($entity->id, $value->get()))) selected @endif>{{ $entity->name }}</option>
        @endforeach
    </select>
    @endif

</div>
