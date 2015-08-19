@extends('argon::layout.master')

@section('content')
    <h1 class="page-header">Create Role</h1>

    <form action="{{ route('cms:role:create') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="card">
            <div class="card-header">Details</div>
            <div class="card-block">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="name" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
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
                                <input type="checkbox" name="permissions[]" value="{{$permission}}"> {{$permission}}
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
