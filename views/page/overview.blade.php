@extends('argon::layout.login')

@section('header')
    @include('argon::inc.nav')
@stop

@section('content')

    <div class="c-dashboard c-container">

        <div class="c-dashboard__welcome-msg">
            <h1>Hi {{ auth()->user()->name }}</h1>
            <p>Welcome to your dashboard</p>

            <a class="c-dashboard__logo" href="/" target="_blank">
                <img class="logo-admin" src="{{config('argon.client_logo_light', '/argon/images/logo.png')}}" alt="{{config('argon.client_name', 'Argon')}}">
            </a>
        </div>

        <div class="c-dashboard__widgets">
            @foreach($widgets as $widgetView)

                @if(view()->exists('argon::inc.widgets.'.$widgetView))

                    @include('argon::inc.widgets.'.$widgetView, compact('widgetData'))

                @endif

            @endforeach
        </div>

    </div>

@stop
