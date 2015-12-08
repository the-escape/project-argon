@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Create Group</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:types:groups:save', [$type->id]) }}" method="POST" autocomplete="false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'name') }}" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:groups', [$type->id])}}">Back to manage groups</a>
            <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>
    </div>
@endsection