@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">

        <div class="c-header__title">
            <h1 class="page-header">Media</h1>
        </div>

    </header>

    <main class="c-container c-container--main">

        @include('argon::inc.new-alerts')

        <div id="medialibapp">Loading media library...</div>

    </main>

@stop

@section('styles')
@stop

@section('footer')
@stop
