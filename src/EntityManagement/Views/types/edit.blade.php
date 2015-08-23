@extends('argon::layout.master')

@section('content')
    <h1 class="page-header">Edit User</h1>

    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('cms:types:update', [$type->id]) }}" method="POST" autocomplete="false">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="card">
            <div class="card-header">User Details</div>
            <div class="card-block">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $type->name) }}">
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
                                <a class="btn btn-secondary-outline btn-sm" href="{{ route('cms:types:fields:edit', [$type->id, $field->id]) }}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <a href="{{ route('cms:types:fields:add', [$type->id]) }}" class="btn btn-primary-outline">Add</a>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
