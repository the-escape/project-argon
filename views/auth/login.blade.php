@extends('argon::layout.login')

@section('content')
    <main class="c-login">

        <div class="c-login__big-logo">
            <img alt="logo" src="{{ config('argon.login_logo', '/argon/images/e.png') }}">
        </div>

        @if(isset($errors) && !$errors->isEmpty())
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                {{$errors->get('email')[0]}}
            </div>
        @endif

        <form action="/admin/login" method="post" class="o-form c-login__form l-full">
            {!! csrf_field() !!}
            <div class="o-form__group">
                <input type="text" name="email" placeholder="Email*" class="form-control" required>
            </div>
            <div class="o-form__group">
                <input type="password" name="password" placeholder="Password*" class="form-control" required>
            </div>
            <div class="o-form__group">
                <button type="submit" class="o-btn o-btn--primary">Sign in</button>
            </div>
        </form>

    </main>
@stop
