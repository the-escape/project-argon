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
                    <th>Country</th>
                    <th>Code</th>
                    <th>Region</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($locales->all() as $locale)
                    <tr>
                        <td>{{$locale->name}}</td>
                        <td>{{$locale->language->language_name}} ({{ $locale->language->language_code }})</td>
                        <td>{{$locale->country->country_name}} ({{ $locale->country->iso_code }})</td>
                        <td>{{$locale->locale_slug}}</td>
                        <td>
                            @if($locale->region)
                                {{$locale->region->region_name}} ({{ $locale->region->display_name }})
                            @endif
                        </td>
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
