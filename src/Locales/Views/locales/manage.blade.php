@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Locales</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="dashboard-actions dashboard-actions--top">
            <a href="{{ route('cms:locales:create') }}" class="btn btn-primary">Create</a>
        </div>

        <div class="dashboard-content">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Language</th>
                    <th>Region</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($locales->all() as $locale)
                    <tr>
                        <td>{{$locale->name}}</td>
                        <td>{{$locale->languageCode}}</td>
                        <td>{{$locale->region}}</td>
                        <td>
                            <a href="{{ route('cms:locales:edit', ['localeId' => $locale->id]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                            @if (count($locales) > 1)
                                <a href="{{ route('cms:locales:delete', ['localeId' => $locale->id]) }}" class="btn btn-danger-outline btn-sm">Delete</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
