@if(!$isCloning)
    <div class="field field-location field-{{ $field->getId() }} @if($field->isRequired()) required @endif"
	 data-field="{{$field->getId()}}"
	 data-hash="{{$hash}}">

	<label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>

	<div class="field-values">
@endif

	@foreach($value as $k => $v)

	    @if($field->allowMultiple())
                <div class="input-group sortable-item">
                    <div class="input-group-addon sortable-handle">&#8645;</div>
                    <div class="form-control">


	    @endif
						<?php
                        if (!$field->isInCombo()) $hash = guid();
                        $name = $field->getFormFieldName($hash);
                        if ($field->isInCombo()) $name = $name.'['.guid().']';
                        ?>
                        <input type="text" class="form-control" name="{{ $name }}[longitude]" placeholder="Longitude" value="{{@$v->longitude}}">
                        <input type="text" class="form-control" name="{{ $name }}[latitude]" placeholder="Latitude" value="{{@$v->latitude}}">

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

