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
                        <label for="name" class="required">Name</label>
                        <input type="text" class="form-control required" name="name" value="{{ old('name', $page->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="slug" class="required">URL Slug</label>
                        <input type="text" class="form-control required" name="slug" value="{{ old('slug', $page->slug) }}">
                    </div>
                </div>
            </div>


            @foreach($groups as $group)

                <div class="card accordion">

                    <div class="card-header accordion-header">{{ $group->name }}</div>

                    <div class="card-block accordion-body">

                        @foreach ($group->fields as $field)

                            <div class="form-group">
                                @include('argon::fields.field', ['value'=>old("fields.{$field->id}", $page->fieldById($field->id))])
                            </div>

                        @endforeach

                    </div>

                </div>

            @endforeach

            <button type="submit" class="btn btn-primary">Save</button>

            <a href="{{ route('cms:pages:manage') }}" class="btn btn-link">Back to pages</a>
            
        </form>
    </div>
@stop
