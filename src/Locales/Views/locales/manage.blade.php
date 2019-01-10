@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Locales</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:locales:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Locales</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:locales:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New locale</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <main class="c-container c-container--main">
        @include('argon::inc.alerts')

        @include('argon::inc.listing.filters', [
            'createLink' => [
                'url' => route('cms:locales:create'),
                'label' => 'Create Locale'
            ],
            'filters' => [],
            'resetLinkUrl' => route('cms:locales:manage')
        ])

        <div class="o-table o-table--3 l-full">
            @include('argon::inc.listing.table-headers', ['headers' => ['name', 'languageCode', 'region', '', '']])

            @foreach ($locales->all() as $i => $locale)
                <div class="o-table__data">{{ $locale->name }}</div>
                <div class="o-table__data">{{ $locale->languageCode }}</div>
                <div class="o-table__data">{{ $locale->region }}</div>
                <div class="o-table__data">
                    @include('argon::inc.listing.confirm', [
                        'deleteUrl' => route('cms:locales:delete', ['id' => $locale->id])
                    ])
                </div>
                <div class="o-table__data">
                    <a href="{{ route('cms:locales:edit', ['id' => $locale->id]) }}" class="o-btn o-btn--xs">edit locale</a>
                </div>
            @endforeach
        </div>

        @if($locales->lastPage() > 1)
            <div class="l-full">
                @include('argon::inc.listing.pagination', ['items' => $locales])
            </div>
        @endif
    </main>
@stop
