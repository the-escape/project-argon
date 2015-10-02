@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Field</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @include('argon::inc.errors', compact($errors))

        <form action="{{ route('cms:types:fields:update', [$type->id, $field->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $field->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="field_type">Type</label>
                        <select class="form-control" name="field_type" id="field_type">
                            <option value="">Choose one...</option>
                            @foreach ($fieldTypes as $fieldType)
                                <option value="{{$fieldType->getKey()}}" @if ($field->field_type == $fieldType->getKey()) selected="selected" @endif >{{$fieldType->getName()}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="group">Field Group</label>
                        <select class="form-control" name="group" id="group" onchange="if(this.options[this.selectedIndex].text == 'Create new') var g = prompt('Please enter group name');  if (g != null){this.appendChild(new Option(g, g)); this.value=g;}">
                            <option value="">Choose one...</option>
                            @foreach ($fieldGroups as $fieldGroup)
                                <option value="{{$fieldGroup->id}}" @if ($field->entity_group_id == $fieldGroup->id) selected="selected" @endif >{{$fieldGroup->name}}</option>
                            @endforeach
                            <option class="create-new" value="">Create new</option>
                        </select>
                    </div>

                    @foreach ($field->type->getProperties() as $name => $property)
                        @if ($property->type == 'boolean')
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" value="0" name="{{$name}}">
                                    <input type="checkbox" value="1" name="{{$name}}" @if ($field->settings->$name) checked="checked" @endif>
                                    {{ $property->label }}
                                </label>
                                @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                            </div>
                        @elseif ($property->type == 'integer')
                            <div class="form-group">
                                <label for="{{$name}}">{{$property->label}}</label>
                                <input id="{{$name}}" type="number" class="form-control" name="{{$name}}" value="{{ old($name, $field->settings->$name) }}">
                                @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                            </div>
                        @elseif ($property->type == 'text')
                            <div class="form-group">
                                <label for="{{$name}}">{{$property->label}}</label>
                                <input id="{{$name}}" type="text" class="form-control" name="{{$name}}" value="{{ old($name, $field->settings->$name) }}">
                                @if (!empty($property->help)) <p class="help-block">{{$property->help}}</p>@endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>
    </div>
@endsection
