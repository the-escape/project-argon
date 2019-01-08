@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Content Types</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:types:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Types</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:types:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New type</span>
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
                'url' => route('cms:types:create'),
                'label' => 'Create Type'
            ],
            'filters' => [],
            'resetLinkUrl' => route('cms:types:manage')
        ])

        <div class="o-table o-table--3 l-full">
            @include('argon::inc.listing.table-headers', ['headers' => ['name', 'type', '', '', '']])

            @foreach ($types->all() as $i => $type)
                <div class="o-table__data">{{ $type->name }}</div>
                <div class="o-table__data">{{ $type->type }}</div>
                <div class="o-table__data"></div>
                <div class="o-table__data"></div>
                <div class="o-table__data">
                    <a href="{{ route('cms:types:edit', ['id' => $type->id]) }}" class="o-btn o-btn--xs">edit type</a>
                </div>
            @endforeach
        </div>
    </main>

@stop
