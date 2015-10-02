@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Manage Type Groups</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @include('argon::inc.errors', compact($errors))

        <div class="card">
            <div class="card-header">Groups</div>
            <div class="card-block">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Order</th>
                        <th></th>
                    </tr>
                    </thead>
                    @foreach ($groups as $group)
                        <tr>
                            <td>
                                {{ $group->name }}
                            </td>
                            <td>
                                {{ $group->order }}
                            </td>
                            <td>
                                <a class="btn btn-secondary-outline btn-sm" href="{{route('cms:types:groups:edit', [$type->id, $group->id])}}">Edit</a>
                                <a class="btn btn-link btn-sm confirm" href="{{route('cms:types:groups:delete', [$type->id, $group->id])}}">Remove</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <a href="{{ route('cms:types:groups:create', [$type->id]) }}" class="btn btn-primary-outline">Add Group</a>
            </div>
        </div>
        <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
        <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>

    </div>
@endsection
