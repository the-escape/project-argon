@extends('argon::layout.master')

@section('content')
    <div class="main">

        <div class="row">
            <div class="col-md-9">
                <h1>Edit Page</h1>
            </div>
            <div class="col-md-3">
                @if(!$groups->isEmpty())
                    <a href="#" class="accordion-expand-collapse pull-right" data-expand="Expand All" data-collapse="Collapse All">Expand all</a>
                @endif
            </div>
        </div>


        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:pages:update', [$page->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" id="name" class="form-control required" name="name" value="{{ old('name', $page->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="slug" class="required">URL Slug</label>
                        <input type="text" id="slug" class="form-control required" name="slug" value="{{ old('slug', $page->slug) }}">
                    </div>
                </div>
            </div>

            @if(!$groups->isEmpty())

                <div class="row subnav">
                    <div class="col-md-12">
                        <a href="#" class="accordion-expand-collapse" data-expand="Expand All" data-collapse="Collapse All">Expand all</a>
                    </div>
                </div>

                @foreach($groups as $group)

                    <div class="card accordion">

                        <div class="card-header accordion-header">{{ $group->name }}</div>

                        <div class="card-block accordion-body">

                            <?php // echo "\n\n<pre>" . print_r($group->fields, TRUE) . "</pre>\n\n";?>

                            @foreach ($group->fields as $field)

                                <div class="form-group sortable">
                                    @include('argon::fields.field')
                                </div>

                            @endforeach

                        </div>

                    </div>

                @endforeach

            @endif

            <button type="submit" class="btn btn-primary">Save</button>

            <a href="{{ route('cms:pages:manage') }}" class="btn btn-link">Back to pages</a>
            
        </form>
    </div>
@stop
