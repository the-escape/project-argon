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
    @if($submitted = old("fields.{$field->getId()}"))

        @foreach($submitted as $k => $v)

            <?php
            $idString = "fields-{$field->getId()}-{$k}"; // used by js too
            $camelString = str_replace('-', '.', $idString);
            $errorClass = Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, $camelString);
            ?>

            <div class="input-group sortable-item">
                <div class="input-group-addon sortable-handle">&#8645;</div>

                @if(@$field->settings->required)
                    <textarea name="fields[{{ $field->getId() }}][]" id="{{ $idString }}" class="form-control required {{$errorClass}}">{{ old($camelString, $v) }}</textarea>
                @else
                    <textarea name="fields[{{ $field->getId() }}][]" id="{{ $idString }}" class="form-control {{$errorClass}}">{{ old($camelString, $v) }}</textarea>
                @endif

                <div class="input-group-addon field-remove">&#10005;</div>
            </div>

        @endforeach

        <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->getId()}}" data-hash="{{$hash}}">Add Field</a>

    @else

        {{-- Attempt to build fields from stored values.--}}
        @if($value)

            @foreach($value as $k => $v)

                <?php
// TODO: clarify differences in the view for textarea and wysiwyg
                $idString = "fields-{$field->getId()}-{$k}"; // used by js too
                $camelString = str_replace('-', '.', $idString);
                ?>

                <div class="input-group sortable-item">
                    <div class="input-group-addon sortable-handle">&#8645;</div>

                    @if(@$field->settings->required)
                        <textarea name="fields[{{ $field->getId() }}][]" id="{{ $idString }}" class="form-control required">{{ old($camelString, $v) }}</textarea>
                    @else
                        <textarea name="fields[{{ $field->getId() }}][]" id="{{ $idString }}" class="form-control">{{ old($camelString, $v) }}</textarea>
                    @endif

                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>

            @endforeach

            @if(!isset($clone))
                <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->getId()}}" data-hash="{{$hash}}">Add Field</a>
            @endif

        @else

            {{-- Build initial multiple type field..--}}
            <?php
            $idString = "fields-{$field->getId()}-0"; // used by js too
            $camelString = str_replace('-', '.', $idString);
            ?>

            <div class="input-group sortable-item">
                <div class="input-group-addon sortable-handle">&#8645;</div>

                @if(@$field->settings->required)
                    <textarea name="fields[{{ $field->getId() }}][]" id="{{ $idString }}" class="form-control required">{{ old($camelString) }}</textarea>
                @else
                    <textarea name="fields[{{ $field->getId() }}][]" id="{{ $idString }}" class="form-control">{{ old($camelString) }}</textarea>
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
    $idString = "fields-{$field->getId()}";
    $camelString = str_replace('-', '.', $idString);
    $errorClass = Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, $camelString);
    ?>

    @if($field->isRequired())
        <label for="{{ $idString }}" class="required">{{ $field->getName() }}</label>
        <textarea name="fields[{{ $field->getId() }}]" id="{{ $idString }}" class="form-control required {{$errorClass}}">{{ old($camelString, $value) }}</textarea>
    @else
        <label for="{{ $idString }}">{{ $field->getName() }}</label>
        <textarea name="fields[{{ $field->getId() }}]" id="{{ $idString }}" class="form-control {{$errorClass}}">{{ old($camelString, $value) }}</textarea>
    @endif

@endif
