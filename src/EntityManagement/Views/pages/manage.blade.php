@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Pages</h1>
        </div>
    </header>

    <main class="c-container c-container--main">
        <script>
            window.sitemap = {!! $sitemapJson !!};
            window.types = {!! $typesJson !!};
        </script>
        <div class="js-site-tree"></div>
    </main>

@stop

@section('styles')
@stop
