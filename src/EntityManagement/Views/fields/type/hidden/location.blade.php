@foreach($value as $k => $v)
    <?php
        if (!$field->isInCombo()) $hash = guid();
        $name = $field->getFormFieldName($hash);
        if ($field->isInCombo()) $name = $name.'['.guid().']';
    ?>
    <input type="hidden" name="{{ $name }}[latitude]" value="{{@$v->latitude}}">
    <input type="hidden" name="{{ $name }}[longitude]" value="{{@$v->longitude}}">
@endforeach
