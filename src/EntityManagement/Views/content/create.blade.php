@extends('argon::layout.master')

@section('content')
    <h1>Create Content</h1>

    <form action="{{ route('cms:content:save', [$type->id]) }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="card">
            <div class="card-header">Details</div>
            <div class="card-block">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                </div>
                @foreach ($type->fields as $field)
                    <div class="form-group">
                        <label for="name">{{ $field->name }}</label>
                        <input type="text" class="form-control" name="{{ $field->name }}" value="{{ old($field->name) }}">
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop
