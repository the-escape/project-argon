<?php

    $isInCombo = $field->getParentId() !== 0;
    $submitted = ($isInCombo) ? old("combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}") : old("fields.{$field->getId()}");

    if ($isInCombo) {
        if (!isset($value)) {
            $value = null;
        }
    } else {
        if (isset($latest)) {
            $value = $latest->getField($field->getId());
        } else {
            $value = null;
        }
    }

    if ($value === null) {
        $value = new \Escape\Argon\EntityManagement\FieldValues\TextFieldValue();
    }

    if (!isset($hash)) {
        $hash = '';
    }
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
                    <input type="text" id="{{ $idString }}" class="form-control required {{$errorClass}}" name="{{ $name }}" value="{{ old($camelString, $v) }}">
                @else
                    <input type="text" id="{{ $idString }}" class="form-control {{$errorClass}}" name="{{ $name }}" value="{{ old($camelString, $v) }}">
                @endif

                <div class="input-group-addon field-remove">&#10005;</div>
            </div>

            <?php $i++; ?>

        @endforeach

        <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->getId()}}" data-hash="{{$hash}}">Add Field</a>

    @else

        {{-- Attempt to build fields from stored values.--}}
        @if(!empty($value))

            <?php $i = 0; ?>

            @foreach($value as $k => $v)

                <?php
                $idString = str_replace('.', '', microtime(true));
                $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}][]" : "fields[{$field->getId()}][]";
                $camelString = ($isInCombo) ? "combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}.{$i}" : "fields.{$field->getId()}.{$i}";
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
                    <input type="text" id="{{ $idString }}" class="form-control required" name="{{ $name }}" value="{{ old($camelString) }}">
                @else
                    <input type="text" id="{{ $idString }}" class="form-control" name="{{ $name }}" value="{{ old($camelString) }}">
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
        <input type="text" id="{{ $idString }}" class="form-control required {{ $errorClass }}" name="{{ $name }}" value="{{ old($camelString, $value) }}">
    @else
        <label for="{{ $idString }}">{{ $field->getFieldName() }}</label>
        <input type="text" id="{{ $idString }}" class="form-control {{ $errorClass }}" name="{{ $name }}" value="{{ old($camelString, $value) }}">
    @endif

@endif
