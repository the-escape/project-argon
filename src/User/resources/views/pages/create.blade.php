@extends('argon::layouts.master')
@section('body')
    <div class="actions">Create new user</div>
    <form class="form" action="{{ route('cms:user:store') }}" method="post">
        {{ csrf_field() }}
        <div class="form__group">
            <label for="name">Name*</label>
            <input id="name" name="name" type="text" class="form__text">
            @if ($errors->has('name'))
                <div class="form__error">
                    <div class="form__alert form__alert--error">{{ $errors->first('name') }}</div>
                </div>
            @endif
        </div>
        <div class="form__group">
            <label for="email">Email*</label>
            <input id="email" name="email" type="text" class="form__text">
            @if ($errors->has('email'))
                <div class="form__error">
                    <div class="form__alert form__alert--error">{{ $errors->first('email') }}</div>
                </div>
            @endif
        </div>
        <div class="form__group">
            <label for="password">Password*</label>
            <input id="password" name="password" type="password" class="form__text">
            @if ($errors->has('password'))
                <div class="form__error">
                    <div class="form__alert form__alert--error">{{ $errors->first('password') }}</div>
                </div>
            @endif
        </div>
        <div class="form__group">
            <label for="password_confirmation">Password confirmation*</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form__text">
            @if ($errors->has('password_confirmation'))
                <div class="form__error">
                    <div class="form__alert form__alert--error">{{ $errors->first('password_confirmation') }}</div>
                </div>
            @endif
        </div>
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1">
                        <div class="footer__container">
                            <a href="{{ route('cms:user:manage') }}" class="form__btn form__btn--grey">CANCEL</a>
                            <div class="footer__right">
                                <button type="submit" class="form__btn">SAVE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
