@if(@$field)

    <?php
    $page_fieldById = isset($page) ? $page->fieldById($field->id) : '';
    ?>

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
                        <textarea name="fields[{{ $field->id }}][]" id="{{ $idString }}" class="form-control required {{$errorClass}}">{{ old($camelString, $v) }}</textarea>
                    @else
                        <textarea name="fields[{{ $field->id }}][]" id="{{ $idString }}" class="form-control {{$errorClass}}">{{ old($camelString, $v) }}</textarea>
                    @endif

                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>

            @endforeach

            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>

        @else

            @if($page_fieldById)

                @foreach($page_fieldById as $k => $v)

                    <?php
                    $idString = "fields-{$field->id}-{$k}"; // used by js too
                    $camelString = str_replace('-', '.', $idString);
                    ?>

                    <div class="input-group sortable-item">
                        <div class="input-group-addon sortable-handle">&#8645;</div>

                        @if(@$field->settings->required)
                            <textarea name="fields[{{ $field->id }}][]" id="{{ $idString }}" class="form-control required">{{ old($camelString, $v) }}</textarea>
                        @else
                            <textarea name="fields[{{ $field->id }}][]" id="{{ $idString }}" class="form-control">{{ old($camelString, $v) }}</textarea>
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
                        <textarea name="fields[{{ $field->id }}][]" id="{{ $idString }}" class="form-control required">{{ old($camelString) }}</textarea>
                    @else
                        <textarea name="fields[{{ $field->id }}][]" id="{{ $idString }}" class="form-control">{{ old($camelString) }}</textarea>
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
            <label for="field-{{ $field->id }}" class="required">{{ $field->name }}</label>
            <textarea name="fields[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control required {{$errorClass}}">{{ old("fields.{$field->id}", $page_fieldById) }}</textarea>
        @else
            <label for="field-{{ $field->id }}" class="required">{{ $field->name }}</label>
            <textarea name="fields[{{ $field->id }}]" id="field-{{ $field->id }}" class="form-control {{$errorClass}}">{{ old("fields.{$field->id}", $page_fieldById) }}</textarea>
        @endif

    @endif

@endif