<?php
    $isInCombo = $field->getParentId() !== 0;

    if ($isInCombo) {
        if (!isset($value)) {
            $value = null;
        } else {
            $value = new \Escape\Argon\EntityManagement\FieldValues\SelectFieldValue($value);
        }
    } else {
        if (isset($latest)) {
            $value = $latest->getField($field->getId());
        } else {
            $value = null;
        }
    }

    if ($value === null) {
        $value = new \Escape\Argon\EntityManagement\FieldValues\SelectFieldValue();
    }

?>

@if($field->allowMultiple())

    @if($field->isRequired())
        <label for="fields-{{ $field->getId() }}-0" class="required">{{ $field->getFieldName() }}</label>
    @else
        <label for="fields-{{ $field->getId() }}-0" class="required">{{ $field->getFieldName() }}</label>
    @endif

    {{-- Attempt to build fields from submitted fields array first. Note variable fields number--}}
    @if($submitted = old("fields.{$field->getId()}"))

        <?php $i = 0; ?>

        @foreach($submitted as $k => $v)

            <?php
            $idString = "fields-{$field->getId()}-{$k}"; // used by js too
            $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}][]" : "fields[{$field->getId()}][]";
            $camelString = ($isInCombo) ? "combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}.{$i}" : "fields.{$field->getId()}.{$i}";
            $errorClass = Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, $camelString);
            ?>

            <div class="input-group sortable-item">
                <div class="input-group-addon sortable-handle">&#8645;</div>

                @if($field->isRequired())
                    <select name="{{ $name }}" id="{{$idString}}" class="form-control required {{ $errorClass }}">
                @else
                    <select name="{{ $name }}" id="{{$idString}}" class="form-control {{ $errorClass }}">
                @endif
                        <option value="">Please select:</option>

                        @if($field->getOptions())
                            @foreach($field->getOptions() as $opt_id => $opt_value)
                                <option value="{{ $opt_id }}" @if($v !== '' && $opt_id == $v) selected @endif>{{ $opt_value }}</option>
                            @endforeach
                        @endif

                    </select>

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
                $idString = "fields-{$field->getId()}-{$k}"; // used by js too
                $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}][]" : "fields[{$field->getId()}][]";
                $camelString = ($isInCombo) ? "combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}.{$i}" : "fields.{$field->getId()}.{$i}";
                ?>

                <div class="input-group sortable-item">
                    <div class="input-group-addon sortable-handle">&#8645;</div>

                    @if($field->isRequired())
                        <select name="{{ $name }}" id="{{$idString}}" class="form-control required">
                    @else
                        <select name="{{ $name }}" id="{{$idString}}" class="form-control">
                    @endif

                        <option value="">Please select:</option>

                        @foreach($field->getOptions() as $optionId => $optionValue)
                            <option value="{{ $optionId }}" @if($optionId === $v)) selected @endif>{{ $optionValue }}</option>
                        @endforeach

                    </select>

                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>

                <?php $i++; ?>

            @endforeach

            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>

    @endif

@else

    {{-- Build initial single type field..--}}
    <?php
    $idString = "fields-{$field->getId()}";
    $name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}][]" : "fields[{$field->getId()}][]";
    $camelString = ($isInCombo) ? "combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}.0" : "fields.{$field->getId()}.0";
    $value = old($camelString, $value);
    $errorClass = Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, $camelString);
    ?>


        @if($field->isRequired())
        <label for="{{ $idString }}" class="required">{{ $field->getFieldName() }}</label>
        <select name="{{$name}}" id="{{$idString}}" class="form-control required {{ $errorClass }}">
    @else
        <label for="{{ $idString }}">{{ $field->getFieldName() }}</label>
        <select name="{{ $name }}" id="{{$idString}}" class="form-control {{ $errorClass }}">
    @endif
            <option value="">Please select:</option>

            @foreach($field->getOptions() as $optionId => $optionValue)

                <option value="{{ $optionId }}" @if($optionId === $value->getSelectedIndex()) selected @endif>{{ $optionValue }}</option>
            @endforeach

        </select>

@endif
