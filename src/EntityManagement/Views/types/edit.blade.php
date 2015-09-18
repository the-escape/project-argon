@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Type</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

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
                            <label class=""checkbox-inline"><input type="radio" class="" id="type-page" name="type" value="page"> Page</label>
                            <label class=""checkbox-inline"><input type="radio" class="" id="type-object" name="type" value="page"> Block</label>
                            <label class=""checkbox-inline"><input type="radio" class="" id="type-object" name="type" value="page"> Email</label>
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
                                    {{ $field->name }}
                                </td>
                                <td>
                                    {{ $field->field_type }}
                                </td>
                                <td>
                                    {{ $field->group }}
                                </td>
                                <td>
                                    <a class="btn btn-secondary-outline btn-sm" href="{{ route('cms:types:fields:edit', [$type->id, $field->id]) }}">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <a href="{{ route('cms:types:fields:add', [$type->id]) }}" class="btn btn-primary-outline">Add</a>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>
    </div>
@endsection
