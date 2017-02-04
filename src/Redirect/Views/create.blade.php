@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Create Redirect</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('cms:redirects:create') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="from">From</label>
                        <input type="text" class="form-control" id="from" name="from" placeholder="From" value="{{ old('from') }}">
                    </div>
                    <div class="form-group">
                        <label for="to">To</label>
                        <input type="text" class="form-control" id="to" name="to" placeholder="To" value="{{ old('to') }}">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
