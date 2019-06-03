@foreach($value as $k => $v)
    <?php
        if (!$field->isInCombo()){
            $hash = guid();
        }
        $name = $field->getFormFieldName($hash);

        if ($field->isInCombo()){
            $name = $name.'['.guid().']';
        }
    ?>
    <input type="hidden" name="{{ $name }}[label]" value="{{@$v->label}}">
    <input type="hidden" name="{{ $name }}[url]" value="{{@$v->url}}">
    <input type="hidden" name="{{ $name }}[class]" value="{{@$v->class}}">
    <input type="hidden" name="{{ $name }}[id]" value="{{@$v->id}}">
    <input type="hidden" name="{{ $name }}[target]" value="{{@$v->target}}">
@endforeach
