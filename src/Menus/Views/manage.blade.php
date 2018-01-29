@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Menus</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="dashboard-actions dashboard-actions--top">
            <a href="{{ route('cms:menus:create') }}" class="btn btn-primary">Create</a>
        </div>

        <div class="dashboard-content">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($menus->all() as $menu)
                    <tr>
                        <td>{{$menu->name}}</td>
                        <td>{{$menu->slug}}</td>
                        <td>
                            <a href="{{ route('cms:locales:edit', ['localeId' => $menu->id]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                            <a href="{{ route('cms:locales:delete', ['localeId' => $menu->id]) }}" class="btn btn-danger-outline btn-sm">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
