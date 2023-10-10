@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Field</h1>

        @include('argon::inc.alerts', (array) $errors)

        <form action="{{ route('cms:types:fields:update', [$type->id, $field->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'name') }}" id="name" name="name" placeholder="Name" value="{{ old('name', $field->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="field_slug" class="required">Slug</label>
                        <input type="text" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'field_slug') }}" id="field_slug" name="field_slug" placeholder="Slug" value="{{ old('field_slug', $field->field_slug) }}">
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

                    <div class="form-group">
                        <label for="group" class="required">Field Group</label>
                        <select class="form-control groupCreate required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'group') }}" name="group" id="group">
                            <option value="">Choose one...</option>

                            <?php
                                $submittedGroup = old('group', $field->entity_group_id);
                                $selected = 0;
                            ?>
                            @foreach ($fieldGroups as $fieldGroup)
                                @if($fieldGroup->id == $submittedGroup)
                                    <?php $selected = 1;?>
                                    <option value="{{$fieldGroup->id}}" selected>{{$fieldGroup->name}}</option>
                                @else
                                    <option value="{{$fieldGroup->id}}">{{$fieldGroup->name}}</option>
                                @endif
                            @endforeach

                            @if($submittedGroup && !$selected)
                                <option value="{{$submittedGroup}}" selected="selected">{{$submittedGroup}}</option>
                            @endif

                            <option class="create-new" value="">Create new</option>
                        </select>
                    </div>

                    @include('argon::types.fields.loop', ['items'=>$field->type->getProperties()])

                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>
    </div>
@endsection
