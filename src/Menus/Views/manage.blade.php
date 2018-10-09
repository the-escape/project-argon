@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Menus</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:menus:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Menus</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:menus:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New Menu</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <main class="c-container c-container--main">
        {{-- this needs changing --}}
        @include('argon::inc.new-alerts')

        @include('argon::inc.listing.filters', [
            'createLink' => [
                'url' => route('cms:menus:create'),
                'label' => 'Create Menu'
            ],
            'filters' => [],
            'resetLinkUrl' => route('cms:menus:manage')
        ])

        <div class="o-table o-table--2 l-full">

            @include('argon::inc.listing.table-headers', ['headers' => ['name', 'slug', '', '']])

            @foreach ($menus->all() as $i => $menu)
                <div class="o-table__data">{{ $menu->name }}</div>
                <div class="o-table__data">{{ $menu->slug }}</div>
                <div class="o-table__data"></div>
                <div class="o-table__data">
                    <a href="{{ route('cms:menus:edit', ['userId' => $menu->id]) }}" class="o-btn o-btn--xs">edit menu</a>
                </div>
            @endforeach

        </div>
    </main>

    <footer class="c-footer__wrapper">
        <div class="c-footer c-container"><!-- .c-footer--fixed -->
            <div class="c-footer__container ">
                @include('argon::inc.listing.pagination', ['items' => $menus])
            </div>
        </div>
    </footer>

@stop
