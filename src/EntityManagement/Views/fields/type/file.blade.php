<?php
    $isInCombo = $field->getParentId() != 0;
    $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}][]" : "fields[{$field->getId()}][]";
?>

<div class="field field-file" data-type="text" data-settings="{{json_encode($field->getSettings())}}" data-name="{{ $name }}">
    <label>{{ $field->getFieldName() }}</label>

    <div class="files sortable">
        @foreach($value as $k => $v)
            <div class="input-group sortable-item">
                <input type="hidden" name="{{ $name }}" value="{{ $v->getId() }}">
            @if ($field->allowMultiple())

                    <div class="input-group-addon sortable-handle">&#8645;</div>
            @endif
                        <div class="file-name form-control"> {{$v->filename}}.{{$v->extension}} </div>
                        <div class="input-group-addon field-remove">&#10005;</div>
                </div>
        @endforeach
    </div>

    <a href="#addField" class="btn btn-secondary-outline btn-sm field-add-file" data-field="{{$field->getId()}}">Add File</a>
</div>

