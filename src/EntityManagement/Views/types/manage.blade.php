@extends('argon::layout.master')

@section('content')
    <div class="main">

        <h1 class="page-header">Types</h1>

        @include('argon::inc.alerts', compact($errors))

        <a href="{{ route('cms:types:create') }}" class="btn btn-primary">Create</a>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($types->all() as $type)
                <tr>
                    <td>{{$type->name}}</td>
                    <td>{{$type->type}}</td>
                    <td>
                        <div class="pull-xs-right">
                            <a href="{{ route('cms:types:edit', ['typeId' => $type->id]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                            <a href="{{ route('cms:types:delete', ['typeId' => $type->id]) }}" class="btn btn-danger btn-sm confirm">Delete</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
