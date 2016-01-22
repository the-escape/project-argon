<?php

    $isInCombo = $field->getParentId();

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

    // get wysiwyg toolbar options
    $toolbar = $format_tags = [];
    foreach ($field->getProperties() as $name => $property)
    {
        if (property_exists($field->getSettings(), $name) && property_exists($property, 'toolbar'))
        {
            $toolbar[] = $property->toolbar;

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

    $wysiwyg_config_height = isset($field->settings->height) ? (int)$field->settings->height : '';

    ?>


    @if($field->allowMultiple())

        @if($field->isRequired())
            <label for="fields-{{ $field->getId() }}-0" class="required">{{ $field->getFieldName() }}</label>
        @else
            <label for="fields-{{ $field->getId() }}-0" class="required">{{ $field->getFieldName() }}</label>
        @endif

        {{-- Attempt to build fields from submitted fields array first. Note variable fields number--}}
        @if($submitted = old("combo.{$field->getId()}"))

            <?php $i = 0; ?>

            @foreach($submitted as $k => $v)

                <?php
                $idString = str_replace('.', '', microtime(true));
                $name = ($isInCombo) ? "combo[{$isInCombo}][$hash][fields][{$field->id}][]" : "fields[{$field->id}][]";
                $camelString = ($isInCombo) ? "combo.{$isInCombo}.{$hash}.fields.{$field->id}.{$i}" : "fields.{$field->id}.{$i}";
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

            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>

        @else

            {{-- Attempt to build fields from stored values.--}}

            <?php $i = 0; ?>

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

            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>

        @endif

    @else

        {{-- Build initial single type field..--}}
        <?php
        $idString = str_replace('.', '', microtime(true));
        $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}][]" : "fields[{$field->getId()}][]";
        $camelString = ($isInCombo) ? "combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}.0" : "fields.{$field->getId()}.0";
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
