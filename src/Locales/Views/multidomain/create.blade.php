@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Add Referring Domain</h1>

        <form action="{{ route('cms:multiDomain:create') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="domain_url">Domain Url</label>
                        <input type="text" class="form-control" id="domain_url" name="domain_url" placeholder="Domain Url" value="{{ old('domain_url') }}">
                    </div>
                    <div class="form-group">
                        <label for="locale_id">Locale</label>
                        <select class="form-control" id="locale_id" name="locale_id" placeholder="Locale">
                            @foreach($locales as $locale)
                                <option value="{{ $locale->id }}"{{ (old("locale_id") == $locale->id ? "selected":"") }}>{{ $locale->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
