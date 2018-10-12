@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Users</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:user:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Users</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:user:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New user</span>
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
                'url' => route('cms:user:create'),
                'label' => 'Create User'
            ],
            'filters' => [
                'role' => $roles->lists('name','id')->all()
            ],
            'resetLinkUrl' => route('cms:user:manage')
        ])

        <div class="o-table o-table--3 l-full">

            @include('argon::inc.listing.table-headers', ['headers' => ['name', 'email', 'created_at', '', '']])

            @foreach ($users->all() as $i => $user)
                <div class="o-table__data">{{ $user->name }}</div>
                <div class="o-table__data">{{ $user->email }}</div>
                <div class="o-table__data">{{ $user->created_at->format('jS M Y') }}</div>
                <div class="o-table__data"></div>
                <div class="o-table__data">
                    <a href="{{ route('cms:user:edit', ['userId' => $user->id]) }}" class="o-btn o-btn--xs">edit user</a>
                </div>
            @endforeach

        </div>
    </main>

    @if($users->lastPage() > 1)
        <footer class="c-footer__wrapper">
            <div class="c-footer c-container"><!-- .c-footer--fixed -->
                <div class="c-footer__container ">
                    @include('argon::inc.listing.pagination', ['items' => $users])
                </div>
            </div>
        </footer>
    @endif

@stop

