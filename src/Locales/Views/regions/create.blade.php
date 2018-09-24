@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Create Region</h1>

        <form action="{{ route('cms:regions:create') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="region_name">Region Name</label>
                        <input type="text" class="form-control" id="region_name" name="region_name" placeholder="Region Name" value="{{ old('region_name') }}">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
