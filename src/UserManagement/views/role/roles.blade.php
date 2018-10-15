@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Roles</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:role:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Roles</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:role:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New role</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <main class="c-container c-container--main">

        @include('argon::inc.new-alerts')

        @include('argon::inc.listing.filters', [
            'createLink' => [
                'url' => route('cms:role:create'),
                'label' => 'Create Role'
            ],
            'filters' => [],
            'resetLinkUrl' => route('cms:role:manage')
        ])

        <div class="o-table o-table--2 l-full">

            @include('argon::inc.listing.table-headers', ['headers' => ['name', 'created_at', '', '']])

            @foreach ($roles->all() as $i => $role)
                <div class="o-table__data">{{ $role->name }}</div>
                <div class="o-table__data">{{ $role->created_at->format('jS M Y') }}</div>
                <div class="o-table__data"></div>
                <div class="o-table__data">
                    <a href="{{ route('cms:role:edit', ['id' => $role->id]) }}" class="o-btn o-btn--xs">edit role</a>
                </div>
            @endforeach

        </div>
    </main>

    @if($roles->lastPage() > 1)
        <footer class="c-footer__wrapper">
            <div class="c-footer c-container"><!-- .c-footer--fixed -->
                <div class="c-footer__container ">
                    @include('argon::inc.listing.pagination', ['items' => $roles])
                </div>
            </div>
        </footer>
    @endif
@stop
