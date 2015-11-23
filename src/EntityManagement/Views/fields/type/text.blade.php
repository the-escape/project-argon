@if(@$field)

    @if(@$field->settings->multiline)

        @if(@$field->settings->required)
            <label for="field-{{ $field->id }}" class="required">{{ $field->name }}</label>
            <textarea name="fields[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control required">{{ old("fields.{$field->id}", $page->fieldById($field->id)) }}</textarea>
        @else
            <label for="field-{{ $field->id }}" class="required">{{ $field->name }}</label>
            <textarea name="fields[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control">{{ old("fields.{$field->id}", $page->fieldById($field->id)) }}</textarea>
        @endif

    @else

        @if(@$field->settings->multiple)

            @if(@$field->settings->required)
                <label for="field-{{ $field->id }}-0" class="required">{{ $field->name }}</label>
            @else
                <label for="field-{{ $field->id }}-0" class="required">{{ $field->name }}</label>
            @endif

            @if($fieldById = $page->fieldById($field->id))

                @foreach($fieldById as $k => $v)

                    @if(@$field->settings->required)
                        <input type="text" id="field-{{ $field->id }}-{{ $k }}" class="form-control required" name="fields[{{ $field->id }}][{{ $k }}]" value="{{ old("fields.{$field->id}.{$k}", $page->fieldById($field->id)[$k]) }}">
                    @else
                        <input type="text" id="field-{{ $field->id }}-{{ $k }}" class="form-control" name="fields[{{ $field->id }}][{{ $k }}]" value="{{ old("fields.{$field->id}.{$k}", $page->fieldById($field->id)[$k]) }}">
                    @endif

                @endforeach

                <a href="#addField" class="btn btn-secondary-outline btn-sm add-field" data-clone="#field-{{ $field->id }}-{{ $k }}" data-clone_field="{{ $field->id }}" data-clone_subfield="{{ $k }}">Add Field</a>

            @else

                @if(@$field->settings->required)
                    <input type="text" id="field-{{ $field->id }}-0" class="form-control required" name="fields[{{ $field->id }}][]" value="{{ old("fields.{$field->id}.0", $page->fieldById($field->id)[0]) }}">
                @else
                    <input type="text" id="field-{{ $field->id }}-0" class="form-control" name="fields[{{ $field->id }}][]" value="{{ old("fields.{$field->id}.0", $page->fieldById($field->id)[0]) }}">
                @endif

                <a href="#addField" class="btn btn-secondary-outline btn-sm add-field" data-clone="#field-{{ $field->id }}-0" data-clone_field="{{ $field->id }}" data-clone_subfield="{{ $k }}">Add Field</a>

            @endif

        @else

            @if(@$field->settings->required)
                <label for="field-{{ $field->id }}" class="required">{{ $field->name }}</label>
                <input type="text" id="field-{{ $field->id }}" class="form-control required" name="fields[{{ $field->id }}]" value="{{ old("fields.{$field->id}", $page->fieldById($field->id)) }}">
            @else
                <label for="field-{{ $field->id }}" class="required">{{ $field->name }}</label>
                <input type="text" id="field-{{ $field->id }}" class="form-control" name="fields[{{ $field->id }}]" value="{{ old("fields.{$field->id}", $page->fieldById($field->id)) }}">
            @endif

        @endif

    @endif

@endif