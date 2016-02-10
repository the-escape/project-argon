<?php

    $isInCombo = $field->getParentId() !== 0;

    if ($isInCombo) {
        if (!isset($value)) {
            $value = null;
        } else {
            $value = new \Escape\Argon\EntityManagement\FieldValues\WysiwygFieldValue($value);
        }
    } else {
        if (isset($latest)) {
            $value = $latest->getField($field->getId());
        } else {
            $value = null;
        }
    }

    if ($value === null) {
        $value = new \Escape\Argon\EntityManagement\FieldValues\WysiwygFieldValue();
    }

    if (!isset($hash)) {
        $hash = '';
    }

    // get wysiwyg toolbar options
    $toolbar = $format_tags = [];

    foreach ($field->getProperties() as $name => $property)
    {
        if (property_exists($field->getSettings(), $name) && property_exists($property, 'toolbar'))
        {
            if ($field->getSetting($name))
            {
                $toolbar[] = $property->toolbar;
            }

            if (($name == 'format') && $property->children)
            {
                foreach($property->children as $child_name => $child_propery)
                {
                    if ($field->getSetting($child_name))
                    {
                        $format_tags[] = $child_name;
                    }
                }
            }
        }
    }

    $wysiwyg_config_toolbar = implode(',', $toolbar);

    $wysiwyg_config_format_tags = implode(';', $format_tags);

    $wysiwyg_config_height = $field->getSetting('height');

?>


    @if($field->allowMultiple())

        @if(!isset($clone))
            @if($field->isRequired())
                <label for="fields-{{ $field->getId() }}-0" class="required">{{ $field->getFieldName() }}</label>
            @else
                <label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>
            @endif
        @endif

        {{-- Attempt to build fields from submitted fields array first. Note variable fields number--}}
        <?php $submitted = ($isInCombo) ? old("combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}") : old("fields.{$field->getId()}"); ?>

        @if($submitted)

            <?php $i = 0; ?>

            @foreach($submitted as $k => $v)

                <?php
                $idString = str_replace('.', '', microtime(true));
                $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}][]" : "fields[{$field->getId()}][]";
                $camelString = ($isInCombo) ? "combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}.{$i}" : "fields.{$field->getId()}.{$i}";
                $errorClass = Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, $camelString);
                ?>

                <div class="input-group sortable-item">
                    <div class="input-group-addon sortable-handle">&#8645;</div>

                    @if($field->isRequired())
                        <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control ckeditor required {{$errorClass}}" data-wysiwyg_height="{{$wysiwyg_config_height}}" data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}" data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}">{{ old($camelString, $v) }}</textarea>
                    @else
                        <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control ckeditor {{$errorClass}}" data-wysiwyg_height="{{$wysiwyg_config_height}}" data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}" data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}">{{ old($camelString, $v) }}</textarea>
                    @endif

                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>

                <?php $i++; ?>

            @endforeach

            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->getId()}}" data-hash="{{$hash}}">Add Field</a>

        @else

            {{-- Attempt to build fields from stored values.--}}

            @if(!$value->isEmpty())

                <?php
                $i = 0;
                if (is_scalar($value)) {
                    $value = (array)$value;
                }
                ?>

                @foreach($value as $k => $v)

                    <?php
                    $idString = str_replace('.', '', microtime(true));
                    $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}][]" : "fields[{$field->getId()}][]";
                    $camelString = ($isInCombo) ? "combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}.{$i}" : "fields.{$field->getId()}.{$i}";
                    ?>

                    <div class="input-group sortable-item">
                        <div class="input-group-addon sortable-handle">&#8645;</div>

                        @if($field->isRequired())
                            <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control ckeditor required" data-wysiwyg_height="{{$wysiwyg_config_height}}" data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}" data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}">{{ old($camelString, $v) }}</textarea>
                        @else
                            <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control ckeditor" data-wysiwyg_height="{{$wysiwyg_config_height}}" data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}" data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}">{{ old($camelString, $v) }}</textarea>
                        @endif

                        <div class="input-group-addon field-remove">&#10005;</div>
                    </div>

                    <?php $i++; ?>

                @endforeach

                @if(!isset($clone))
                    <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->getId()}}" data-hash="{{$hash}}">Add Field</a>
                @endif

            @else

                {{-- Build initial multiple type field..--}}

                <?php
                $idString = str_replace('.', '', microtime(true));
                $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}][]" : "fields[{$field->getId()}][]";
                $camelString = ($isInCombo) ? "combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}.0" : "fields.{$field->getId()}.0";
                ?>

                <div class="input-group sortable-item">
                    <div class="input-group-addon sortable-handle">&#8645;</div>

                    @if($field->isRequired())
                        <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control required">{{ old($camelString) }}</textarea>
                    @else
                        <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control">{{ old($camelString) }}</textarea>
                    @endif

                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>

                @if(!isset($clone))
                    <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->getId()}}" data-hash="{{$hash}}">Add Field</a>
                @endif

            @endif

        @endif

    @else

        {{-- Build initial single type field..--}}
        <?php
        $idString = str_replace('.', '', microtime(true));
        $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}]" : "fields[{$field->getId()}]";
        $camelString = ($isInCombo) ? "combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}" : "fields.{$field->getId()}";
        $errorClass = Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, $camelString);
        ?>

        @if($field->isRequired())
            <label for="{{ $idString }}" class="required">{{ $field->getFieldName() }}</label>
            <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control ckeditor required {{$errorClass}}" data-wysiwyg_height="{{$wysiwyg_config_height}}" data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}" data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}">{{ old($camelString, $value) }}</textarea>
        @else
            <label for="{{ $idString }}">{{ $field->getFieldName() }}</label>
            <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control ckeditor {{$errorClass}}" data-wysiwyg_height="{{$wysiwyg_config_height}}" data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}" data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}">{{ old($camelString, $value) }}</textarea>
        @endif

    @endif
