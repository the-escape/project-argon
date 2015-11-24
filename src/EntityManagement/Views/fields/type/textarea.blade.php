@if(@$field)

    @if(@$field->settings->required)
        <label for="field-{{ $field->id }}" class="required">{{ $field->name }}</label>
        <textarea name="fields[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control required">{{ old("fields.{$field->id}", $page->fieldById($field->id)) }}</textarea>
    @else
        <label for="field-{{ $field->id }}" class="required">{{ $field->name }}</label>
        <textarea name="fields[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control">{{ old("fields.{$field->id}", $page->fieldById($field->id)) }}</textarea>
    @endif

@endif