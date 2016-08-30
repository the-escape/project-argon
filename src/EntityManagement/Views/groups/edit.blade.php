@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Group</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:types:groups:update', [$type->id, $group->id]) }}" method="POST" autocomplete="false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'name') }}" id="name" name="name" placeholder="Name" value="{{ old('name', $group->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="sortable">
                            <input type="hidden" value="0" name="sortable">
                            <input type="checkbox" class="{{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'sortable') }}" @if($group->sortable) checked @endif id="sortable" name="sortable" value="1">
                            Sortable
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="renderable">
                            <input type="hidden" value="0" name="renderable">
                            <input type="checkbox" class="{{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'renderable') }}" @if($group->renderable) checked @endif id="renderable" name="renderable" value="1">
                            Renderable
                        </label>
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
