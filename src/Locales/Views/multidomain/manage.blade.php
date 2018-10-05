@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Regions</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="dashboard-actions dashboard-actions--top">
            <a href="{{ route('cms:multiDomain:create') }}" class="btn btn-primary">Create</a>
        </div>

        <div class="dashboard-content">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Domain Url</th>
                    <th>Locale Name</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($domains->all() as $domain)
                    <tr>
                        <td>{{ $domain->domain_url }}</td>
                        <td>{{ $domain->locale->locale_name }}</td>
                        <td>
                            <a href="{{ route('cms:multiDomain:edit', ['domainId' => $domain->id]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                            <a href="{{ route('cms:multiDomain:delete', ['domainId' => $domain->id]) }}" class="btn btn-danger-outline btn-sm">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
