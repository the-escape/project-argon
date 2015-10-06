@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Add Field</h1>

        @include('argon::inc.alerts', compact($errors))

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
                                <option value="{{$fieldType->getKey()}}" @if($fieldType->getKey() == old('field_type')) selected="selected" @endif>{{$fieldType->getName()}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="group">Field Group</label>
                        <select class="form-control groupCreate" name="group" id="group">
                            <option value="">Choose one...</option>

                            <?php
                                $submittedGroup = old('group');
                                $selected = '';
                            ?>
                            @foreach ($fieldGroups as $fieldGroup)
                                <?php if ($fieldGroup->id == $submittedGroup) $selected = 'selected="selected"'; ?>
                                <option value="{{$fieldGroup->id}}" {{$selected}}>{{$fieldGroup->name}}</option>
                            @endforeach

                            @if($submittedGroup && !$selected)
                                <option value="{{$submittedGroup}}" selected="selected">{{$submittedGroup}}</option>
                            @endif

                            <option class="create-new" value="">Create new</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>

    </div>
@endsection
