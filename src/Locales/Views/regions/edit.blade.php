@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Region</h1>

        <form action="{{ route('cms:regions:edit', [$region->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name">Region Name</label>
                        <input type="text" class="form-control" id="region_name" name="region_name" placeholder="Region Name" value="{{ old('region_name', $region->region_name) }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Display Name</label>
                        <input type="text" class="form-control" id="display_name" name="display_name" placeholder="Display Name" value="{{ old('display_name', $region->display_name) }}">
                    </div>
                    <div class="form-group">
                        <label for="language_id">Locales</label>
                        <select class="form-control" id="locale_id" name="locale_id[]" placeholder="Language" multiple="multiple">
                            @foreach($locales as $locale)
                                <option value="{{ $locale->id }}"{{ (in_array($locale->id, $region->locale) ? "selected":"") }}>{{ $language->language_name }} ({{ $language->language_code }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
