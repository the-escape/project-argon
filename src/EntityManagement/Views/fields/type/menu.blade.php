<?php
if (!isset($hash)) {
    $hash = '';
}
?>

@if (!$isCloning)
    <div class="field field-select field-{{ $field->getId() }} @if($field->isRequired()) required @endif"
         data-field="{{$field->getId()}}"
         data-hash="{{$hash}}">

        <label for="fields-{{ $field->getId() }}-0">{{ $field->getFieldName() }}</label>

        <div class="field-values">
            @endif


            @if($field->allowMultiple())


                @if($value->isEmpty())

                    <div class="input-group sortable-item">
                        <div class="input-group-addon sortable-handle">&#8645;</div>

                        <select name="{{ $field->getFormFieldName($hash) }}" class="form-control">
                            <option value="">Please select:</option>

                            @foreach($field->getOptions() as $option)
                                <option value="{{ $option->slug }}"@if($value->containsSlug($option->slug)) selected @endif>{{ $option->name }}</option>
                            @endforeach

                        </select>

                        <div class="input-group-addon field-remove">&#10005;</div>
                    </div>

                @else

                    @foreach($value->getSlugs() as $selectedSlug)

                        <div class="input-group sortable-item">
                            <div class="input-group-addon sortable-handle">&#8645;</div>

                            <select name="{{ $field->getFormFieldName($hash) }}" class="form-control">

                                <option value="">Please select:</option>

                                @foreach($field->getOptions() as $option)
                                    <option value="{{ $option->slug }}"@if($selectedSlug == $option->slug)) selected @endif>{{ $option->name }}</option>
                                @endforeach

                            </select>

                            <div class="input-group-addon field-remove">&#10005;</div>
                        </div>

                    @endforeach

                @endif

            @else

                <select name="{{ $field->getFormFieldName($hash) }}" class="form-control">
                    <option value="">Please select:</option>
                    @foreach($field->getOptions() as $option)
                        <option value="{{ $option->slug }}"@if($value->containsSlug($option->slug)) selected @endif>{{ $option->name }}</option>
                    @endforeach
                </select>

            @endif

            @if(!$isCloning)
        </div>
        @if ($field->allowMultiple())
            <a href="#addField" class="btn btn-secondary-outline btn-sm field-clone">Add Field</a>
        @endif
    </div>
@endif
