<?php

$isInCombo = $field->getParentId() !== 0;

$name = ($isInCombo) ? "combo[{$field->getParentId()}][$hash][fields][{$field->getId()}]" : "fields[{$field->getId()}]";
$camelString = ($isInCombo) ? "combo.{$field->getParentId()}.{$hash}.fields.{$field->getId()}" : "fields.{$field->getId()}";



if ($isInCombo) {
    if (!isset($value)) {
        $value = null;
    } else {
        $value = new \Escape\Argon\EntityManagement\FieldValues\DatetimeFieldValue($value);
    }

} else {
    if (isset($latest)) {
        $value = $latest->getField($field->getId());
    } else {
        $value = null;
    }
}

if ($value === null) {
    $value = new \Escape\Argon\EntityManagement\FieldValues\DatetimeFieldValue();
}

// retain submitted value if validation fails on submission
$value = old($camelString, $value);

if (is_scalar($value)) {
    $value = new \Escape\Argon\EntityManagement\FieldValues\DatetimeFieldValue($value);
}


$requiredClass = $field->isRequired() ? 'required' : '';



?>

<div class="field-{{ $field->getId() }} field-datetime @if ($field->isRequired()) {{ $requiredClass }} @endif"
     data-time-enabled="{{ $field->timeEnabled() ? 'true' : 'false' }}"
     data-seconds-enabled="{{ $field->timeEnabled() && $field->secondsEnabled() ? 'true' : 'false' }}"
>
    <label class="{{ $requiredClass }}">{{ $field->getFieldName() }}</label>

    <div class="calendar" data-datetime="{{ $value->format('Y-m-d') }}">
    </div>

    @if ($field->timeEnabled())
        <select class="hours">
            @foreach (range(0, 23) as $h)
                <option value="{{ sprintf('%02d', $h) }}" @if($value->hour == $h) selected @endif>{{ sprintf('%02d', $h) }}</option>
            @endforeach
        </select>
        :
        <select class="minutes">
            @foreach (range(0, 59) as $m)
                <option value="{{ sprintf('%02d', $m) }}" @if($value->minute == $m) selected @endif>{{ sprintf('%02d', $m) }}</option>
            @endforeach
        </select>
        @if ($field->secondsEnabled())
            :
            <select class="seconds">
                @foreach (range(0, 59) as $s)
                    <option value="{{ sprintf('%02d', $s) }}" @if($value->second == $s) selected @endif>{{ sprintf('%02d', $s) }}</option>
                @endforeach
            </select>
        @endif

    @endif
    <input type="text" class="value" id="field-{{ $field->getId() }}" name="{{ $name }}" value="{{$value->format('Y-m-d H:i:s')}}">
</div>
