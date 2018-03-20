@if(!$isCloning)
    <div class="field field-button field-{{ $field->getId() }} @if($field->isRequired()) required @endif"
         data-field="{{$field->getId()}}"
         data-hash="{{$hash}}">

        <label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>

        <div class="field-values field--options-parent">
            @endif

            @foreach($value as $k => $v)

                @if($field->allowMultiple())
                    <div class="input-group sortable-item">
                        <div class="input-group-addon sortable-handle">&#8645;</div>
                        <div class="form-control field--options-parent">
                            @endif
                            <?php
                            if (!$field->isInCombo()) $hash = guid();
                            $name = $field->getFormFieldName($hash);
                            if ($field->isInCombo()) $name = $name.'['.guid().']';
                            ?>
                            <input type="text" class="form-control" name="{{ $name }}[label]" placeholder="Label" value="{{@$v->label}}">
                            <input type="text" class="form-control" name="{{ $name }}[url]" placeholder="Url" value="{{@$v->url}}">

                            <div class="field--options" style="display: none;">
                                <input type="text" class="form-control" name="{{ $name }}[class]" placeholder="Class(es)" value="{{@$v->class}}">
                                <input type="text" class="form-control" name="{{ $name }}[id]" placeholder="ID" value="{{@$v->id}}">
                                <input type="text" class="form-control" name="{{ $name }}[target]" placeholder="Target" value="{{@$v->target}}">
                            </div>

                            <div class="field--options-controls">
                                <button type="button" class="field--options-toggle btn btn-primary-outline btn-sm">Toggle more options</button>
                            </div>

                            @if($field->allowMultiple())
                        </div>
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

