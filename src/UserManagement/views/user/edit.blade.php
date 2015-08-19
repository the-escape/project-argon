@extends('argon::layout.master')

@section('content')
    <h1 class="page-header">Edit User</h1>

    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('cms:user:update', [$user->id]) }}" method="POST" autocomplete="false">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="card">
            <div class="card-header">User Details</div>
            <div class="card-block">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $user->name) }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="email" value="{{ old('email', $user->email) }}">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Change Password (optional)</div>
            <div class="card-block">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="password">
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header">Roles</div>
            <div class="card-block">
                @foreach ($roles as $role)
                    <div class="col-md-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="roles[]" value="{{$role->id}}" @if ($user->hasRole($role->name))checked="checked"@endif> {{$role->name}}
                            </label>
                        </div>
                    </div>
                @endforeach
                <div class="clearfix"></div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
