@if(!$isCloning)

    <div class="field field-combo field-{{ $field->getId() }}"
	 data-field="{{$field->getId()}}">

	<label>{{ $field->getFieldName() }}</label>

	<div class="field-values">
@endif

    @foreach ($value as $hash => $v)

	<div class="input-group sortable-item">

	    @if($field->allowMultiple())
		<div class="input-group-addon sortable-handle">&#8645;</div>
            @endif

	    <div class="form-control">
		@foreach($field->getSubFields() as $subField)

		    {!! $subField->render($value->getValueForSubField($hash, $subField->getId()), ['hash' => $hash]) !!}

		@endforeach
	    </div>

            @if($field->allowMultiple())
		<div class="input-group-addon field-remove">&#10005;</div>
            @endif
	</div>

    @endforeach

@if(!$isCloning)
	</div>
	@if($field->allowMultiple())
		<a href="#addField" class="btn btn-secondary-outline btn-sm field-clone" data-field="{{$field->getId()}}">Add Field</a>
	@endif
    </div>
@endif
