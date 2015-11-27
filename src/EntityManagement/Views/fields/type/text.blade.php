@if(@$field)

    @if(@$field->settings->multiple)

        @if(@$field->settings->required)
            <label for="fields-{{ $field->id }}-0" class="required">{{ $field->name }}</label>
        @else
            <label for="fields-{{ $field->id }}-0" class="required">{{ $field->name }}</label>
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

                <div class="input-group sortable-item">
                    <div class="input-group-addon sortable-handle">&#8645;</div>

                    @if(@$field->settings->required)
                        <input type="text" id="{{ $idString }}" class="form-control required {{$errorClass}}" name="fields[{{ $field->id }}][]" value="{{ old($camelString, $v) }}">
                    @else
                        <input type="text" id="{{ $idString }}" class="form-control {{$errorClass}}" name="fields[{{ $field->id }}][]" value="{{ old($camelString, $v) }}">
                    @endif

                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>

            @endforeach

            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>

        @else

            @if($fieldById = $page->fieldById($field->id))

                @foreach($fieldById as $k => $v)

                    <?php
                    $idString = "fields-{$field->id}-{$k}"; // used by js too
                    $camelString = str_replace('-', '.', $idString);
                    ?>

                    <div class="input-group sortable-item">
                        <div class="input-group-addon sortable-handle">&#8645;</div>

                        @if(@$field->settings->required)
                            <input type="text" id="{{ $idString }}" class="form-control required" name="fields[{{ $field->id }}][]" value="{{ old($camelString, $v) }}">
                        @else
                            <input type="text" id="{{ $idString }}" class="form-control" name="fields[{{ $field->id }}][]" value="{{ old($camelString, $v) }}">
                        @endif

                        <div class="input-group-addon field-remove">&#10005;</div>
                    </div>

                @endforeach

                <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>

            @else

                <?php
                $idString = "fields-{$field->id}-0"; // used by js too
                $camelString = str_replace('-', '.', $idString);
                ?>

                <div class="input-group sortable-item">
                    <div class="input-group-addon sortable-handle">&#8645;</div>

                    @if(@$field->settings->required)
                        <input type="text" id="{{ $idString }}" class="form-control required" name="fields[{{ $field->id }}][]" value="{{ old($camelString) }}">
                    @else
                        <input type="text" id="{{ $idString }}" class="form-control" name="fields[{{ $field->id }}][]" value="{{ old($camelString) }}">
                    @endif

                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>

                <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>

            @endif

        @endif

    @else

        <?php
        $idString = "fields-{$field->id}";
        $camelString = str_replace('-', '.', $idString);
        $errorClass = '';

        if (isset($errors) && is_object($errors) && $errors instanceof \Illuminate\Support\ViewErrorBag && $errors->has($camelString))
        {
            $errorClass = 'error';
        }
        ?>

        @if(@$field->settings->required)
            <label for="{{ $idString }}" class="required">{{ $field->name }}</label>
            <input type="text" id="{{ $idString }}" class="form-control required {{ $errorClass }}" name="fields[{{ $field->id }}]" value="{{ old($camelString, $page->fieldById($field->id)) }}">
        @else
            <label for="{{ $idString }}" class="required {{ $errorClass }}">{{ $field->name }}</label>
            <input type="text" id="{{ $idString }}" class="form-control" name="fields[{{ $field->id }}]" value="{{ old($camelString, $page->fieldById($field->id)) }}">
        @endif

    @endif

@endif