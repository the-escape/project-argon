@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Multi Domain</h1>

        <form action="{{ route('cms:multiDomain:edit', [$domain->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="domain_url">Domain Url</label>
                        <input type="text" class="form-control" id="domain_url" name="domain_url" placeholder="Domain URL" value="{{ old('domain_url', $domain->domain_url) }}">
                    </div>
                    <div class="form-group">
                        <label for="locale_id">Locale</label>
                        <select class="form-control" id="locale_id" name="locale_id" placeholder="Locale">
                            @foreach($locales as $locale)
                                <option value="{{ $locale->id }}"{{ ($locale->id == $locale->locale_id ? "selected":"") }}>{{ $locale->locale_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
