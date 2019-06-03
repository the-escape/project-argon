<?php
$name = $field->getFormFieldName($hash);
?>
@foreach($value as $k => $v)
    @if(!$v)
        <input type="hidden" name="<?=$name.'['.guid().'][id]'?>">
    @else
        <?php
        if (!$field->isInCombo()) $hash = guid();
        $name = $field->getFormFieldName($hash);
        $name = $name.'['.guid().']';
        ?>

        <input type="hidden" name="{{ $name }}[id]" value="{{ $v->getId() }}">
        <input type="hidden" name="{{ $name }}[width]" value="{{ $v->getWidth()}}">
        <input type="hidden" name="{{ $name }}[height]" value="{{ $v->getHeight()}}">
        <input type="hidden" name="{{$name}}[alt]" value="{{ $v->getAlt() }}">
    @endif

@endforeach
