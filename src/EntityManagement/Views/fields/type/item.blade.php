@if(!$isCloning)
    <div class="field field-item field-{{$field->getId()}} @if($field->isRequired()) required @endif"
         data-field="{{$field->getId()}}"
         data-hash="{{$hash}}">

        <label>{{ $field->getFieldName() }}</label>

        <div class="field-values">
            @endif

            @if ($field->allowMultiple())
                <input type="hidden" name="{{ $field->getFormFieldName($hash) }}">
            @endif

            @if($field->allowMultipleInstances())

                @if($value->isEmpty())

                    <div class="input-group sortable-item">
                        <div class="input-group-addon sortable-handle">&#8645;</div>

                        <select name="{{ $field->getFormFieldName($hash) }}" class="form-control">
                            <option value="">Please select:</option>

                            @foreach($field->getOptions() as $entity)
                                <option value="{{ $entity->id }}"@if($value->containsId($entity->id)) selected @endif>{{ $entity->name }}</option>
                            @endforeach

                        </select>

                        <div class="input-group-addon field-remove">&#10005;</div>
                    </div>

                @else

                    @foreach($value->getIds() as $selectedId)

                        <div class="input-group sortable-item">
                            <div class="input-group-addon sortable-handle">&#8645;</div>

                            <select name="{{ $field->getFormFieldName($hash) }}" class="form-control">
                                <option value="">Please select:</option>

                                @foreach($field->getOptions() as $entity)
                                    <option value="{{ $entity->id }}"@if($selectedId == $entity->id) selected @endif>{{ $entity->name }}</option>
                                @endforeach

                            </select>

                            <div class="input-group-addon field-remove">&#10005;</div>
                        </div>

                    @endforeach


                @endif


            @else

                <select name="{{ $field->getFormFieldName($hash) }}" class="form-control" @if($field->allowMultiple()) multiple @endif>
                    @if (!$field->allowMultiple())
                        <option value="">Please select:</option>
                    @endif
                    @foreach($field->getOptions() as $entity)
                        <option value="{{ $entity->id }}"@if($value->containsId($entity->id)) selected @endif>{{ $entity->name }}</option>
                    @endforeach
                </select>

            @endif

            @if(!$isCloning)
        </div>
        @if ($field->allowMultipleInstances())
            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>
        @endif
    </div>
@endif
