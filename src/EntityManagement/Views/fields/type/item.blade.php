<div class="field field-item field-{{$field->getId()}}">
    <label>{{ $field->getFieldName() }}</label>

    <div class="field-values">
        <select name="{{ $field->getFormFieldName($hash) }}" class="form-control" @if ($field->allowMultiple()) multiple @endif>
            @if (!$field->allowMultiple())
                <option value="">Please select:</option>
            @endif
            @foreach($field->getOptions() as $entity)
                <option value="{{ $entity->id }}"@if(in_array($entity->id, $value->get()))) selected @endif>{{ $entity->name }}</option>
            @endforeach
        </select>
    </div>
</div>
