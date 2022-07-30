@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Add Subfield</h1>

        @include('argon::inc.alerts', compact('errors'))

        <form action="{{ route('cms:types:combos:fields:save', [$type->id, $combo->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'name') }}" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="field_slug" class="required">Slug</label>
                        <input type="text" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'field_slug') }}" id="field_slug" name="field_slug" placeholder="Slug" value="{{ old('field_slug') }}">
                    </div>

                    <div class="form-group">
                        <label for="name" class="required">Type</label>
                        <select class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'field_type') }}" name="field_type">
                            <option value="">Choose one...</option>
                            @foreach ($fieldTypes as $fieldType)
                                <option value="{{$fieldType->getKey()}}" @if($fieldType->getKey() == old('field_type')) selected="selected" @endif>{{$fieldType->getName()}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:combos:edit', [$type->id, $combo->id])}}">Back to edit combo</a>
            <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>

    </div>
@endsection
