<?php
    $isInCombo = $field->getParentId() != 0;
    $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}][]" : "fields[{$field->getId()}][]";
?>
@if(!$value->isEmpty())
    @foreach($value as $k => $v)
        <input type="hidden" name="{{ $name }}" value="{{ $v->getId() }}">
    @endforeach
@endif
