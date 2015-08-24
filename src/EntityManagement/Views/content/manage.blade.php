@extends('argon::layout.master')

@section('content')
    <h1>Manage Content</h1>

    <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Create</button>
        <div class="dropdown-menu">
            @foreach ($types as $type)
                <a class="dropdown-item" href="{{ route('cms:content:create', [$type->name]) }}">{{ $type->name }}</a>
            @endforeach
        </div>
    </div>
@stop
