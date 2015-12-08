@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Subfield</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:types:combos:fields:update', [$type->id, $combo->id, $field->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $field->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="field_type" class="required">Type</label>
                        <select class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'field_type') }}" name="field_type" id="field_type">
                            <option value="">Choose one...</option>
                            @foreach ($fieldTypes as $fieldType)
                                <option value="{{$fieldType->getKey()}}" @if (old('field_type', $field->field_type) == $fieldType->getKey()) selected="selected" @endif >{{$fieldType->getName()}}</option>
                            @endforeach
                        </select>
                    </div>

                    @include('argon::types.fields.loop', ['items'=>$field->type->getProperties()])

                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:combos:edit', [$type->id, $combo->id])}}">Back to edit combo</a>
            <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>
    </div>
@endsection
