@extends('argon::layout.master')

@section('content')
    <div class="main">

        <div class="row">
            <div class="col-md-9">
                <h1>Create Content</h1>
            </div>
            <div class="col-md-3">
                <a href="#" class="accordion-expand-collapse pull-right" data-expand="Expand All" data-collapse="Collapse All">Expand all</a>
            </div>
        </div>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:content:save', [$parentId, $type->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" id="name" class="form-control required" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="slug" class="required">URL Slug</label>
                        <input type="text" id="slug" class="form-control required" name="slug" value="{{ old('slug') }}">
                    </div>
                </div>
            </div>


            <div class="row subnav">
                <div class="col-md-12">
                    <a href="#" class="accordion-expand-collapse" data-expand="Expand All" data-collapse="Collapse All">Expand all</a>
                </div>
            </div>


            @foreach($groups as $group)
                <div class="card accordion">
                    <div class="card-header accordion-header">{{ $group->name }}</div>
                    <div class="card-block accordion-body">
                        @foreach ($group->fields as $field)

                            <div class="form-group">
                                @include('argon::fields.field', ['value'=>old("fields.{$field->id}")])
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


