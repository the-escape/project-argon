@extends ('argon.auth::layouts.master')
@section ('class', 'bg')
@section ('body')
    <div class="login">
        <div class="container full-height">
            <div class="row full-height">
                <div class="col-sm-6 col-sm-offset-3 full-height">
                    <div class="login__box">
                        <img class="login__logo" src="/argon/assets/img/e.png" width="38" height="63" alt="logo">
                        <form action="/admin/reset-password" method="POST" class="login__form">
                            {{ csrf_field() }}
                            @if ($errors->has('invalid'))
                                <div class="form__alert form__alert--error form__alert--overview">{{ $errors->first('invalid') }}</div>
                            @endif
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="login__group">
                                <input type="text" name="email" placeholder="Email*" class="form__text form__text--borderless" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <div class="form__alert form__alert--error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="login__group">
                                <input type="password" name="password" placeholder="Password*" class="form__text form__text--borderless">
                                @if ($errors->has('password'))
                                    <div class="form__alert form__alert--error">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                            <div class="login__group">
                                <input type="password" name="password_confirmation" placeholder="Password confirmation*" class="form__text form__text--borderless">
                                @if ($errors->has('password_confirmation'))
                                    <div class="form__alert form__alert--error">{{ $errors->first('password_confirmation') }}</div>
                                @endif
                            </div>
                            <button type="submit" class="form__btn">SUBMIT</button>
                        </form>
                        <a href="/admin/login" class="login__link">Back to login?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
