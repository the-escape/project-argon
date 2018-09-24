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
            <a href="{{ route('cms:regions:create') }}" class="btn btn-primary">Create</a>
        </div>

        <div class="dashboard-content">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Region Name</th>
                    <th>Display Name</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($regions->all() as $region)
                    <tr>
                        <td>{{$region->region_name}}</td>
                        <td>{{$region->display_name}}</td>
                        <td>
                            <a href="{{ route('cms:regions:edit', ['regionId' => $region->id]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                            @if (count($regions) > 1)
                                <a href="{{ route('cms:regions:delete', ['regionId' => $region->id]) }}" class="btn btn-danger-outline btn-sm">Delete</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
