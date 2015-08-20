@extends('argon::layout.master')

@section('content')
    <h1 class="page-header">Edit User</h1>

    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('cms:types:update', [$type->id]) }}" method="POST" autocomplete="false">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="card">
            <div class="card-header">User Details</div>
            <div class="card-block">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $type->name) }}">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Roles</div>
            <div class="card-block">
                <table>
                    <thead>
                        <th>Name</th>
                        <th>Type</th>
                        <th></th>
                    </thead>
                    @foreach ($type->fields as $field)
                        <tr>
                            <td>
                                {{ json_encode($field) }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
