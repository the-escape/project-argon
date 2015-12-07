@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Option</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:types:fields:options:update', [$type->id, $field->id, $option->id]) }}" method="POST" autocomplete="false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $option->name) }}">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:fields:edit', [$type->id, $field->id])}}">Back to field options</a>
            <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>
    </div>
@endsection
