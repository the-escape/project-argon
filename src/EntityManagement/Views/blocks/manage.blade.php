@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Blocks</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:blocks:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Blocks</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:blocks:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New block</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <main class="c-container c-container--main">

        @include('argon::inc.alerts')

        @include('argon::inc.listing.filters', [
            'filters' => [
                'types' => legacyLv() ? $types->lists('name','id')->all() : $types->pluck('name','id')->all()
            ],
            'resetLinkUrl' => route('cms:blocks:manage'),
            'createLink' => [
                'url' => route('cms:blocks:create'),
                'label' => 'Create Block'
            ]
        ])

        <div class="o-table o-table--3 l-full">
            @include('argon::inc.listing.table-headers', ['headers' => ['name', 'type', 'created_at', '', '']])

            @foreach ($blocks->all() as $i => $block)
                <div class="o-table__data">{{ $block->name }}</div>
                <div class="o-table__data">{{ $block->type->name }}</div>
                <div class="o-table__data">{{ $block->created_at->format('jS M Y') }}</div>
                <div class="o-table__data">
                    @include('argon::inc.listing.confirm', [
                        'deleteUrl' => route('cms:blocks:delete', ['id' => $block->id])
                    ])
                </div>
                <div class="o-table__data">
                    <a href="{{ route('cms:blocks:edit', ['id' => $block->id]) }}" class="o-btn o-btn--xs">edit block</a>
                </div>
            @endforeach
        </div>

        @if($blocks->lastPage() > 1)
            <div class="l-full">
                @include('argon::inc.listing.pagination', ['items' => $blocks])
            </div>
        @endif
    </main>

@stop
