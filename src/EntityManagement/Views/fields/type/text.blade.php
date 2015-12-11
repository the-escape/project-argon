@if(@$field)

    <?php

    // get the value
    $page_fieldById = isset($page)
            ? isset($fieldDataIds)
                    ? $page->fieldById($field->id, $fieldDataIds)
                    : $page->fieldById($field->id)
            : '';

    $isComboParent = $field->parent_field_id;
    $submitted = ($isComboParent) ? old("combo.{$field->id}") : old("field.{$field->id}")
    ?>

    @if(@$field->settings->multiple)

        @if(@$field->settings->required)
            <label for="fields-{{ $field->id }}-0" class="required">{{ $field->name }}</label>
        @else
            <label for="fields-{{ $field->id }}-0" class="required">{{ $field->name }}</label>
        @endif

        {{-- Attempt to build fields from submitted fields array first. Note variable fields number--}}
        @if($submitted)

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
                        <input type="text" id="{{ $idString }}" class="form-control required {{$errorClass}}" name="{{ $name }}" value="{{ old($camelString, $v) }}">
                    @else
                        <input type="text" id="{{ $idString }}" class="form-control {{$errorClass}}" name="{{ $name }}" value="{{ old($camelString, $v) }}">
                    @endif

                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>

                <?php $i++; ?>

            @endforeach

            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->id}}" data-hash="{{$hash}}">Add Field</a>

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
                            <input type="text" id="{{ $idString }}" class="form-control required" name="{{ $name }}" value="{{ old($camelString, $v) }}">
                        @else
                            <input type="text" id="{{ $idString }}" class="form-control" name="{{ $name }}" value="{{ old($camelString, $v) }}">
                        @endif

                        <div class="input-group-addon field-remove">&#10005;</div>
                    </div>

                    <?php $i++; ?>

                @endforeach

                <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->id}}" data-hash="{{$hash}}">Add Field</a>

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
                        <input type="text" id="{{ $idString }}" class="form-control required" name="{{ $name }}" value="{{ old($camelString) }}">
                    @else
                        <input type="text" id="{{ $idString }}" class="form-control" name="{{ $name }}" value="{{ old($camelString) }}">
                    @endif

                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>

                <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->id}}" data-hash="{{$hash}}">Add Field</a>

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
            <input type="text" id="{{ $idString }}" class="form-control required {{ $errorClass }}" name="{{ $name }}" value="{{ old($camelString, $page_fieldById) }}">
        @else
            <label for="{{ $idString }}">{{ $field->name }}</label>
            <input type="text" id="{{ $idString }}" class="form-control {{ $errorClass }}" name="{{ $name }}" value="{{ old($camelString, $page_fieldById) }}">
        @endif

    @endif

@endif