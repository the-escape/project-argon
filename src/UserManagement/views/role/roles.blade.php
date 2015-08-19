@extends('argon::layout.master')

@section('content')
    <h1 class="page-header">Roles</h1>

    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <a href="{{ route('cms:role:create') }}" class="btn btn-primary">Create</a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($roles->all() as $role)
            <tr>
                <td>{{$role->name}}</td>
                <td>
                    <a href="{{ route('cms:role:edit', ['roleId' => $role->id]) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('cms:role:delete', ['roleId' => $role->id]) }}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop