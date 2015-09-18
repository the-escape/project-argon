@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Create Locale</h1>

        <form action="{{ route('cms:locales:create') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="languageCode">Language</label>
                        <input type="text" class="form-control" id="languageCode" name="languageCode" placeholder="Language" value="{{ old('languageCode') }}">
                    </div>
                    <div class="form-group">
                        <label for="region">Region</label>
                        <input type="text" class="form-control" id="region" name="region" placeholder="Region" value="{{ old('region') }}">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
