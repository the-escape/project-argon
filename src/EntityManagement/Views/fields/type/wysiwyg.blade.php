@if(@$field)

    <?php

    // get the value
    $page_fieldById = isset($page)
            ? isset($fieldDataIds)
                    ? $page->fieldById($field->id, $fieldDataIds)
                    : $page->fieldById($field->id)
            : '';

    $isComboParent = $field->parent_field_id;

    // get wysiwyg toolbar options
    $toolbar = $format_tags = [];
    foreach ($field->type->getProperties() as $name => $property)
    {
        if (@$field->settings->$name)
        {
            if (@$property->toolbar)
            {
                $toolbar[] = $property->toolbar;

                if (($name == 'format') && @$property->children)
                {
                    foreach($property->children as $child_name => $child_propery)
                    {
                        if (@$field->settings->$child_name)
                        {
                            $format_tags[] = $child_name;
                        }

                    }
                }
            }
        }
    }

    $wysiwyg_config_toolbar = implode(',', $toolbar);

    $wysiwyg_config_format_tags = implode(';', $format_tags);

    $wysiwyg_config_height = isset($field->settings->height) ? (int)$field->settings->height : '';

    ?>


    @if(@$field->settings->multiple)

        @if(@$field->settings->required)
            <label for="fields-{{ $field->id }}-0" class="required">{{ $field->name }}</label>
        @else
            <label for="fields-{{ $field->id }}-0" class="required">{{ $field->name }}</label>
        @endif

        {{-- Attempt to build fields from submitted fields array first. Note variable fields number--}}
        @if($submitted = old("combo.{$field->id}"))

            <?php $i = 0; ?>

            @foreach($submitted as $k => $v)

                <?php
                $idString = str_replace('.', '', microtime(true));
                $name = ($isComboParent) ? "combo[{$isComboParent}][$hash][fields][{$field->id}][]" : "fields[{$field->id}][]";
                $camelString = ($isComboParent) ? "combo.{$isComboParent}.{$hash}.fields.{$field->id}.{$i}" : "fields.{$field->id}.{$i}";
                $errorClass = Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, $camelString);
                ?>

                <div class="input-group sortable-item">
                    <div class="input-group-addon sortable-handle">&#8645;</div>

                    @if(@$field->settings->required)
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
            @if($page_fieldById)

                <?php $i = 0; ?>

                @foreach($page_fieldById as $k => $v)

                    <?php
                    $idString = str_replace('.', '', microtime(true));
                    $name = ($isComboParent) ? "combo[{$isComboParent}][$hash][fields][{$field->id}][]" : "fields[{$field->id}][]";
                    $camelString = ($isComboParent) ? "combo.{$isComboParent}.{$hash}.fields.{$field->id}.{$i}" : "fields.{$field->id}.{$i}";
                    ?>

                    <div class="input-group sortable-item">
                        <div class="input-group-addon sortable-handle">&#8645;</div>

                        @if(@$field->settings->required)
                            <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control ckeditor required" data-wysiwyg_height="{{$wysiwyg_config_height}}" data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}" data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}">{{ old($camelString, $v) }}</textarea>
                        @else
                            <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control ckeditor" data-wysiwyg_height="{{$wysiwyg_config_height}}" data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}" data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}">{{ old($camelString, $v) }}</textarea>
                        @endif

                        <div class="input-group-addon field-remove">&#10005;</div>
                    </div>

                    <?php $i++; ?>

                @endforeach

                <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>

            @else

                {{-- Build initial multiple type field..--}}
                <?php
                $idString = str_replace('.', '', microtime(true));
                $name = ($isComboParent) ? "combo[{$isComboParent}][$hash][fields][{$field->id}][]" : "fields[{$field->id}][]";
                $camelString = ($isComboParent) ? "combo.{$isComboParent}.{$hash}.fields.{$field->id}.0" : "fields.{$field->id}.0";
                ?>

                <div class="input-group sortable-item">
                    <div class="input-group-addon sortable-handle">&#8645;</div>

                    @if(@$field->settings->required)
                        <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control ckeditor required" data-wysiwyg_height="{{$wysiwyg_config_height}}" data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}" data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}">{{ old($camelString) }}</textarea>
                    @else
                        <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control ckeditor" data-wysiwyg_height="{{$wysiwyg_config_height}}" data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}" data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}">{{ old($camelString) }}</textarea>
                    @endif

                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>

                <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>

            @endif

        @endif

    @else

        {{-- Build initial single type field..--}}
        <?php
        $idString = str_replace('.', '', microtime(true));
        $name = ($isComboParent) ? "combo[{$isComboParent}][$hash][fields][{$field->id}]" : "fields[{$field->id}]";
        $camelString = ($isComboParent) ? "combo.{$isComboParent}.{$hash}.fields.{$field->id}" : "fields.{$field->id}";
        $errorClass = Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, $camelString);
        ?>

        @if(@$field->settings->required)
            <label for="{{ $idString }}" class="required">{{ $field->name }}</label>
            <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control ckeditor required {{$errorClass}}" data-wysiwyg_height="{{$wysiwyg_config_height}}" data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}" data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}">{{ old($camelString, $page_fieldById) }}</textarea>
        @else
            <label for="{{ $idString }}">{{ $field->name }}</label>
            <textarea name="{{ $name }}" id="{{ $idString }}" class="form-control ckeditor {{$errorClass}}" data-wysiwyg_height="{{$wysiwyg_config_height}}" data-wysiwyg_toolbar="{{$wysiwyg_config_toolbar}}" data-wysiwyg_format_tags="{{$wysiwyg_config_format_tags}}">{{ old($camelString, $page_fieldById) }}</textarea>
        @endif

    @endif

@endif