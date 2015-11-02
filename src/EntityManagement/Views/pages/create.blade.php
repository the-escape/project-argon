@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1>Create Content</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:content:save', [$parentId, $type->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="slug">URL Slug</label>
                        <input type="text" class="form-control" name="slug" value="{{ old('slug') }}">
                    </div>
                </div>
            </div>

            @foreach($type->groups as $groupId => $fields)
                <div class="card">
                    <div class="card-header">{{ @$groups->find($groupId)->name }}</div>
                    <div class="card-block">
                        @foreach ($fields as $field)
                            <div class="form-group">
                                <label for="name">{{ $field->name }}</label>
                                <input type="text" class="form-control" name="fields[{{ $field->id }}]" value="{{ old($field->name) }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@stop


