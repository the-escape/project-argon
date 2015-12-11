@if(@$field)

    <?php
    // get the value
    $page_fieldById = isset($page)
            ? isset($fieldDataIds)
                    ? $page->fieldById($field->id, $fieldDataIds)
                    : $page->fieldById($field->id)
            : '';

    $isComboParent = $field->parent_field_id;
    ?>

    @if(@$field->settings->multiple)

        @if(@$field->settings->required)
            <label for="fields-{{ $field->id }}-0" class="required">{{ $field->name }}</label>
        @else
            <label for="fields-{{ $field->id }}-0" class="required">{{ $field->name }}</label>
        @endif

        {{-- Attempt to build fields from submitted fields array first. Note variable fields number--}}
        @if($submitted = old("fields.{$field->id}"))

            <?php $i = 0; ?>

            @foreach($submitted as $k => $v)

                <?php
                $idString = "fields-{$field->id}-{$k}"; // used by js too
                $name = ($isComboParent) ? "combo[{$isComboParent}][$hash][fields][{$field->id}][]" : "fields[{$field->id}][]";
                $camelString = ($isComboParent) ? "combo.{$isComboParent}.{$hash}.fields.{$field->id}.{$i}" : "fields.{$field->id}.{$i}";
                $errorClass = Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, $camelString);
                ?>

                <div class="input-group sortable-item">
                    <div class="input-group-addon sortable-handle">&#8645;</div>

                    @if(@$field->settings->required)
                        <select name="{{ $name }}" id="{{$idString}}" class="form-control required {{ $errorClass }}">
                    @else
                        <select name="{{ $name }}" id="{{$idString}}" class="form-control {{ $errorClass }}">
                    @endif
                            <option value="">Please select:</option>

                            @if(@$field->settings->options)
                                @foreach($field->settings->options as $opt_id => $opt_value)
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
            @if($page_fieldById)

                <?php $i = 0; ?>

                @foreach($page_fieldById as $k => $v)

                    <?php
                    $idString = "fields-{$field->id}-{$k}"; // used by js too
                    $name = ($isComboParent) ? "combo[{$isComboParent}][$hash][fields][{$field->id}][]" : "fields[{$field->id}][]";
                    $camelString = ($isComboParent) ? "combo.{$isComboParent}.{$hash}.fields.{$field->id}.{$i}" : "fields.{$field->id}.{$i}";
                    ?>

                    <div class="input-group sortable-item">
                        <div class="input-group-addon sortable-handle">&#8645;</div>

                        @if(@$field->settings->required)
                            <select name="{{ $name }}" id="{{$idString}}" class="form-control required">
                        @else
                            <select name="{{ $name }}" id="{{$idString}}" class="form-control">
                        @endif
                                <option value="">Please select:</option>

                                @if(@$field->settings->options)
                                    @foreach($field->settings->options as $opt_id => $opt_value)
                                        <option value="{{ $opt_id }}" @if($v !== '' && $opt_id == $v)) selected @endif>{{ $opt_value }}</option>
                                    @endforeach
                                @endif

                            </select>

                        <div class="input-group-addon field-remove">&#10005;</div>
                    </div>

                    <?php $i++; ?>

                @endforeach

                <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>

            @else

                {{-- Build initial multiple type field..--}}
                <?php
                $idString = "fields-{$field->id}-0"; // used by js too
                $name = ($isComboParent) ? "combo[{$isComboParent}][$hash][fields][{$field->id}][]" : "fields[{$field->id}][]";
                $camelString = ($isComboParent) ? "combo.{$isComboParent}.{$hash}.fields.{$field->id}.0" : "fields.{$field->id}.0";
                ?>

                <div class="input-group sortable-item">
                    <div class="input-group-addon sortable-handle">&#8645;</div>

                    @if(@$field->settings->required)
                        <select name="{{ $name }}" id="{{$idString}}" class="form-control required">
                    @else
                        <select name="{{ $name }}" id="{{$idString}}" class="form-control">
                    @endif
                            <option value="">Please select:</option>

                            @if(@$field->settings->options)
                                @foreach($field->settings->options as $opt_id => $opt_value)
                                    <option value="{{ $opt_id }}">{{ $opt_value }}</option>
                                @endforeach
                            @endif

                        </select>

                    <div class="input-group-addon field-remove">&#10005;</div>
                </div>

                <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>

            @endif

        @endif

    @else

        {{-- Build initial single type field..--}}
        <?php
        $idString = "fields-{$field->id}";
        $name = ($isComboParent) ? "combo[{$isComboParent}][$hash][fields][{$field->id}]" : "fields[{$field->id}]";
        $camelString = ($isComboParent) ? "combo.{$isComboParent}.{$hash}.fields.{$field->id}" : "fields.{$field->id}";
        $value = old($camelString, $page_fieldById);
        $errorClass = Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, $camelString);
        ?>

        @if(@$field->settings->required)
            <label for="{{ $idString }}" class="required">{{ $field->name }}</label>
            <select name="{{$name}}" id="{{$idString}}" class="form-control required {{ $errorClass }}">
        @else
            <label for="{{ $idString }}">{{ $field->name }}</label>
            <select name="{{ $name }}" id="{{$idString}}" class="form-control {{ $errorClass }}">
        @endif
                <option value="">Please select:</option>

                @if(@$field->settings->options)
                    @foreach($field->settings->options as $opt_id => $opt_value)
                        <option value="{{ $opt_id }}" @if($value != '' && $opt_id == $value) selected @endif>{{ $opt_value }}</option>
                    @endforeach
                @endif

            </select>

    @endif

@endif