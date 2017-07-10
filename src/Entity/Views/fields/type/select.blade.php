<label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>
@foreach ($value as $k => $v)
    <select id="fields-{{ $field->getId() }}-0" name="{{ $field->getFormFieldName($hash) }}" class="form__select">
        <option value="">Please select</option>
        @foreach ($field->getOptions() as $optionId => $optionValue)
            <option value="{{ $optionValue }}" {{ $optionValue === $v ? 'selected' : '' }}>{{ $optionValue }}</option>
        @endforeach
    </select>
@endforeach
