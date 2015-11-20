@if(@$field)

    @if(@$field->settings->multiline)

        @if(@$field->settings->required)
            <label for="field-{{ $field->id }}" class="required">{{ $field->name }}</label>
            <textarea name="fields[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control required">{{ @$value }}</textarea>
        @else
            <label for="field-{{ $field->id }}" class="required">{{ $field->name }}</label>
            <textarea name="fields[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control">{{ @$value }}</textarea>
        @endif

    @else

        @if(@$field->settings->required)
            <label for="field-{{ $field->id }}" class="required">{{ $field->name }}</label>
            <input type="text" id="field-{{ $field->id }}" class="form-control required" name="fields[{{ $field->id }}]" value="{{ @$value }}">
        @else
            <label for="field-{{ $field->id }}" class="required">{{ $field->name }}</label>
            <input type="text" id="field-{{ $field->id }}" class="form-control" name="fields[{{ $field->id }}]" value="{{ @$value }}">
        @endif

    @endif

@endif