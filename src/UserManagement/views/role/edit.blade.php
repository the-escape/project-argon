@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit User</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('cms:role:update', [$role->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="name" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $role->name) }}">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Permissions</div>
                <div class="card-block">
                    @foreach ($permissions->getDefinedPermissions() as $permission)
                        <div class="col-md-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="permissions[]" value="{{$permission}}" @if ($role->hasPermission($permission))checked="checked"@endif> {{$permission}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                        <div class="clearfix"></div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
