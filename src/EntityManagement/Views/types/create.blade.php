@extends('argon::layout.master')

@section('content')
    <h1 class="page-header">Create Type</h1>

    <form action="{{ route('cms:types:create') }}" method="POST">
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
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
