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

        @include('argon::inc.new-alerts')

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
                <div class="o-table__data"></div>
                <div class="o-table__data">
                    <a href="{{ route('cms:locales:edit', ['id' => $locale->id]) }}" class="o-btn o-btn--xs">edit locale</a>
                </div>
            @endforeach

        </div>
    </main>

    @if($locales->lastPage() > 1)
        <footer class="c-footer__wrapper">
            <div class="c-footer c-container"><!-- .c-footer--fixed -->
                <div class="c-footer__container ">
                    @include('argon::inc.listing.pagination', ['items' => $locales])
                </div>
            </div>
        </footer>
    @endif











<?php /*
    <div class="main">
        <h1 class="page-header">Locales</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="dashboard-actions dashboard-actions--top">
            <a href="{{ route('cms:locales:create') }}" class="btn btn-primary">Create</a>
        </div>

        <div class="dashboard-content">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Language</th>
                    <th>Region</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($locales->all() as $locale)
                    <tr>
                        <td>{{$locale->name}}</td>
                        <td>{{$locale->languageCode}}</td>
                        <td>{{$locale->region}}</td>
                        <td>
                            <a href="{{ route('cms:locales:edit', ['localeId' => $locale->id]) }}" class="btn btn-primary-outline btn-sm">Edit</a>
                            @if (count($locales) > 1)
                                <a href="{{ route('cms:locales:delete', ['localeId' => $locale->id]) }}" class="btn btn-danger-outline btn-sm">Delete</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

 */ ?>
@stop
