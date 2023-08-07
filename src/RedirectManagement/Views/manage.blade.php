@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Redirect Managment</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <a href="{{ route('cms:redirects:create') }}" class="btn btn-primary">Create</a>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>From</th>
                <th>To</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($redirects->all() as $redirect)
                <tr>
                    <td>{{$redirect->from}}</td>
                    <td>{{$redirect->to}}</td>
                    <td>
                        <a href="{{ route('cms:redirects:edit', [$redirect->id]) }}" class="btn btn-primary-outline btn-sm">Edit</a>

                        <form action="{{ route('cms:redirects:delete', $redirect->id) }}" method="POST" style="display: inline;">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm confirm" data-confirm="Are you sure you want to delete?">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
