@extends('argon::layout.master')

@section('content')
    <h1 class="page-header">Create User</h1>

    <form action="{{ route('cms:user:create') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="card">
            <div class="card-header">User Details</div>
            <div class="card-block">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="name" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="password">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
