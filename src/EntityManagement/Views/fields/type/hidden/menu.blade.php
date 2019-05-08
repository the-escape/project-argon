<?php
if (!isset($hash)) {
    $hash = '';
}
?>

@if($value->isEmpty())
    <input type="hidden" name="{{ $field->getFormFieldName($hash) }}">
@else
    @foreach($value->getSlugs() as $selectedSlug)
        <input type="hidden" name="{{ $field->getFormFieldName($hash) }}" value="{{ $selectedSlug }}">
    @endforeach
@endif
