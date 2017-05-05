<div class="field field-item field-{{$field->getId()}}">
    <label>{{ $field->getFieldName() }}</label>

    <div class="field-values">

        @if ($field->allowMultiple())
            <input type="hidden" name="{{ $field->getFormFieldName($hash) }}">
        @endif

        <select name="{{ $field->getFormFieldName($hash) }}" class="form-control" @if ($field->allowMultiple()) multiple @endif>
            @if (!$field->allowMultiple())
                <option value="">Please select:</option>
            @endif
            @foreach($field->getOptions() as $entity)
                <option value="{{ $entity->id }}"@if($value->containsId($entity->id)) selected @endif>{{ $entity->name }}</option>
            @endforeach
        </select>

    </div>
</div>