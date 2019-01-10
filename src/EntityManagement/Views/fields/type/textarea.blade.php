@if(!$isCloning)
    <div class="field field-text field-{{ $field->getId() }} @if($field->isRequired()) required @endif"
         data-field="{{$field->getId()}}"
         data-hash="{{$hash}}">

        <label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>

        <div class="field-values">
            @endif

            @foreach($value as $k => $v)

                @if($field->allowMultiple())
                    <div class="input-group sortable-item">
                        <div class="input-group-addon sortable-handle">&#8645;</div>
                        @endif

                        <textarea class="form-control" name="{{ $field->getFormFieldName($hash) }}">{{$v}}</textarea>

                        @if($field->allowMultiple())
                            <div class="input-group-addon field-remove">&#10005;</div>
                    </div>
                @endif

            @endforeach


            @if(!$isCloning)
        </div>
        @if ($field->allowMultiple())
            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>
        @endif
    </div>
@endif