@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <div class="c-page">
        <header class="c-header c-container">
            <div class="c-header__title">
                <h1>Import Field Group</h1>
            </div>
        </header>
        <div class="c-tab-panel__list js-tabs-list">
            <div class="c-tab-panel active" data-tab="page-content">
                <main class="c-tab-panel__container c-container">
                    <script>
                        window.type = {!! $type !!}
                        window.blocks = {!! $blocks !!}
                        window.types = {!! $types !!}
                        window.smartImport = {{ (int) session()->get('smartImportFieldGroups')  }}
                    </script>
                    <div class="js-import-field-groups"></div>
                </main>
            </div>
        </div>
    </div>


    <script src="/argon/vendor/ace.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/vendor/theme-twilight.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/vendor/mode-json.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/vendor/mode-php.js" type="text/javascript" charset="utf-8"></script>

@stop

@section('styles')
@stop
