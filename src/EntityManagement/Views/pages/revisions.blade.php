@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Revisions</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($revisions as $revision)
                    <tr>
                        <td>{{ $revision->id }}</td>
                        <td>{{ $revision->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>
                            <a href="" class="btn btn-primary">Preview</a>
                            <a href="" class="btn btn-primary">Restore</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
