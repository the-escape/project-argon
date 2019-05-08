<?php
//    $isInCombo = $field->getParentId() !== 0;

    if (!isset($hash)) {
        $hash = '';
    }
?>
@foreach($value as $k => $v)
    <input type="hidden" name="{{ $field->getFormFieldName($hash) }}" value="{{ $v }}">
@endforeach
