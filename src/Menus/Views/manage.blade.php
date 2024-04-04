@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Menus</h1>

        @include('argon::inc.alerts', (array) $errors)

        <div class="dashboard-actions dashboard-actions--top">
            <a href="{{ route('cms:menus:create') }}" class="btn btn-primary">Create</a>
        </div>

        <div class="dashboard-content">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Locale</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($menus->all() as $menu)
                    <tr>
                        <td>{{$menu->name}}</td>
                        <td>{{$menu->slug}}</td>
                        <td>
                            @foreach($locales as $locale)
                                @if($locale->id == $menu->locale_id)
                                    {{ $locale->name }}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('cms:menus:edit', ['id' => $menu->id]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                            <a href="{{ route('cms:menus:delete', ['id' => $menu->id]) }}" class="btn btn-danger-outline btn-sm">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
