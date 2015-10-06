@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1>Edit Page</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:pages:update', [$page->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $page->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="name">URL Segment</label>
                        <input type="text" class="form-control" name="segment" value="{{ old('segment', $page->name) }}">
                    </div>
                </div>
            </div>

            @foreach($type->groups as $groupName => $fields)
                <div class="card">
                    <div class="card-header">{{ $groupName }}</div>
                    <div class="card-block">
                        @foreach ($fields as $field)
                            <div class="form-group">
                                <label for="name">{{ $field->name }}</label>
                                <input type="text" class="form-control" name="fields[{{ $field->id }}]" value="{{ old($field->name, $page->field($field->name)) }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@stop
