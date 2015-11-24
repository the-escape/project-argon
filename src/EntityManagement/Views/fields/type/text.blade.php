@if(@$field)

    @if(@$field->settings->multiple)

        @if(@$field->settings->required)
            <label for="field-{{ $field->id }}-0" class="required">{{ $field->name }}</label>
        @else
            <label for="field-{{ $field->id }}-0" class="required">{{ $field->name }}</label>
        @endif


        @if($submitted = old("fields.{$field->id}"))

            @foreach($submitted as $k => $v)

                <?php
                $idString = "fields-{$field->id}-{$k}"; // used by js too
                $camelString = str_replace('-', '.', $idString);
                $errorClass = '';

                if (isset($errors) && is_object($errors) && $errors instanceof \Illuminate\Support\ViewErrorBag && $errors->has($camelString))
                {
                   $errorClass = 'error';
                }
                ?>

                @if(@$field->settings->required)
                    <input type="text" id="{{ $idString }}" class="form-control required {{$errorClass}}" name="fields[{{ $field->id }}][]" value="{{ old($camelString, $v) }}">
                @else
                    <input type="text" id="{{ $idString }}" class="form-control {{$errorClass}}" name="fields[{{ $field->id }}][]" value="{{ old($camelString, $v) }}">
                @endif

            @endforeach

            <a href="#addField" class="btn btn-secondary-outline btn-sm add-field" data-clone="{{ $idString }}">Add Field</a>

        @else

            @if($fieldById = $page->fieldById($field->id))

                @foreach($fieldById as $k => $v)

                    <?php
                    $idString = "fields-{$field->id}-{$k}"; // used by js too
                    $camelString = str_replace('-', '.', $idString);
                    ?>

                    @if(@$field->settings->required)
                        <input type="text" id="{{ $idString }}" class="form-control required" name="fields[{{ $field->id }}][]" value="{{ old($camelString, $v) }}">
                    @else
                        <input type="text" id="{{ $idString }}" class="form-control" name="fields[{{ $field->id }}][]" value="{{ old($camelString, $v) }}">
                    @endif

                @endforeach

                <a href="#addField" class="btn btn-secondary-outline btn-sm add-field" data-clone="{{ $idString }}">Add Field</a>

            @else

                <?php
                $idString = "fields-{$field->id}-0"; // used by js too
                $camelString = str_replace('-', '.', $idString);
                ?>

                @if(@$field->settings->required)
                    <input type="text" id="{{ $idString }}" class="form-control required" name="fields[{{ $field->id }}][]" value="{{ old($camelString) }}">
                @else
                    <input type="text" id="{{ $idString }}" class="form-control" name="fields[{{ $field->id }}][]" value="{{ old($camelString) }}">
                @endif

                <a href="#addField" class="btn btn-secondary-outline btn-sm add-field" data-clone="{{ $idString }}">Add Field</a>

            @endif

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