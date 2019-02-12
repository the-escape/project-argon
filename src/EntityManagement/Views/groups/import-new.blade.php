@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Import Field Group</h1>
        </div>
    </header>

    <main class="c-container c-container--main">
        <script>
            window.type = {!! $type !!}
            window.blocks = {!! $blocks !!};
            window.types = {!! $types !!};
        </script>
        <div class="js-import-field-groups"></div>
    </main>

    <script src="/argon/vendor/ace.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/vendor/theme-twilight.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/vendor/mode-json.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/vendor/mode-php.js" type="text/javascript" charset="utf-8"></script>

@stop

@section('styles')
@stop
