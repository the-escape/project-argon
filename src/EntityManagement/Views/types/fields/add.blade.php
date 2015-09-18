@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Add Field</h1>

        <form action="{{ route('cms:types:fields:save', [$type->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Type</label>
                        <select class="form-control" name="field_type">
                            <option value="">Choose one...</option>
                            @foreach ($fieldTypes as $fieldType)
                                <option value="{{$fieldType->getKey()}}">{{$fieldType->getName()}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Field Group</label>
                        <input type="text" class="form-control" id="group" name="group" placeholder="Group name" value="{{ old('group') }}">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
