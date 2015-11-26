@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Type</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:types:update', [$type->id]) }}" method="POST" autocomplete="false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $type->name) }}">
                    </div>

                    <div class="form-group">
                        <label>Type</label>
                        <div>
                            <label class="checkbox-inline"><input type="radio" class="" id="type-page" name="type" value="page"> Page</label>
                            <label class="checkbox-inline"><input type="radio" class="" id="type-object" name="type" value="block"> Block</label>
                            <label class="checkbox-inline"><input type="radio" class="" id="type-object" name="type" value="email"> Email</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Fields</div>
                <div class="card-block">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Group</th>
                                <th></th>
                            </tr>
                        </thead>
                        @foreach ($type->fields as $field)
                            <tr>
                                <td>
                                    <span data-toggle="tooltip" data-placement="left" title="Field ID: {{ $field->id }}">{{ $field->name }}</span>
                                </td>
                                <td>
                                    {{ $field->field_type }}
                                </td>
                                <td>
                                    {{ @$field->group->name }}
                                </td>
                                <td>
                                    @if($field->field_type == $comboFieldType->getKey())
                                        <a class="btn btn-secondary-outline btn-sm" href="{{ route('cms:types:combos:edit', [$type->id, $field->id]) }}">Edit</a>
                                        <a class="btn btn-link btn-sm confirm" href="{{ route('cms:types:combos:delete', [$type->id, $field->id]) }}">Remove</a>
                                    @else
                                        <a class="btn btn-secondary-outline btn-sm" href="{{ route('cms:types:fields:edit', [$type->id, $field->id]) }}">Edit</a>
                                        <a class="btn btn-link btn-sm confirm" href="{{ route('cms:types:fields:delete', [$type->id, $field->id]) }}">Remove</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <a href="{{ route('cms:types:fields:add', [$type->id]) }}" class="btn btn-primary-outline">Add Field</a>
                    <a href="{{ route('cms:types:combos:add', [$type->id]) }}" class="btn btn-primary-outline">Add Combo</a>
                    <a href="{{ route('cms:types:groups', [$type->id]) }}" class="btn btn-primary-outline">Manage Groups</a>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>
    </div>
@endsection
