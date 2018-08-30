@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Locale</h1>

        <form action="{{ route('cms:locales:edit', [$locale->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $locale->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="language_id">Language</label>
                        <select class="form-control" id="language_id" name="language_id" placeholder="Language">
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}"{{ ($language->id == $locale->id ? "selected":"") }}>{{ $language->language_name }} ({{ $language->language_code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="country_id">Country</label>
                        <select class="form-control" id="country_id" name="country_id" placeholder="Country">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}"{{ ($country->id == $locale->id ? "selected":"") }}>{{ $country->country_name }} ({{ $country->iso_code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="region">Slug</label>
                        <input type="text" class="form-control" id="slug" name="locale_slug" placeholder="Slug" value="{{ old('locale_slug', $locale->locale_slug) }}">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
