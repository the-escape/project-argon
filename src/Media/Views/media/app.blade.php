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
        {{-- <div style="width: 1140px; height: 920px; background-color: rebeccapurple">
            <div class="js-uppy" style="width: 1140px; height: 920px;"></div>
        </div>

        <div style="width: 500px; height: 500px; background-color: rebeccapurple">
            <div class="js-drag-drop" ></div>
        </div> --}}
    </main>

@stop

@section('styles')
@stop

@section('footer')
@stop
