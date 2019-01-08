@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Redirect Management</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:redirects:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Redirects</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:redirects:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New Redirect</span>
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
                'url' => route('cms:redirects:create'),
                'label' => 'Create Redirect'
            ],
            'filters' => [],
            'resetLinkUrl' => route('cms:redirects:manage')
        ])

        <div class="o-table o-table--2 l-full">
            @include('argon::inc.listing.table-headers', ['headers' => ['from', 'to', '', '']])

            @foreach ($redirects->all() as $i => $redirect)
                <div class="o-table__data">{{ $redirect->from }}</div>
                <div class="o-table__data">{{ $redirect->to }}</div>
                <div class="o-table__data">
                    @include('argon::inc.listing.confirm', [
                        'deleteUrl' => route('cms:redirects:delete', ['id' => $redirect->id])
                    ])
                </div>
                <div class="o-table__data">
                    <a href="{{ route('cms:redirects:edit', ['userId' => $redirect->id]) }}" class="o-btn o-btn--xs">edit redirect</a>
                </div>
            @endforeach
        </div>

        @if($redirects->lastPage() > 1)
            <div class="l-full">
                @include('argon::inc.listing.pagination', ['items' => $redirects])
            </div>
        @endif
    </main>
@stop
