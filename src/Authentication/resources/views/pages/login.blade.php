@extends ('argon.auth::layouts.master')
@section ('body')
    <div class="login">
        <div class="container full-height">
            <div class="row full-height">
                <div class="col-sm-6 col-sm-offset-3 full-height">
                    <div class="login__box">
                        <img class="login__logo" src="/argon/assets/img/e.png" width="38" height="63" alt="logo">
                        <form action="/admin/login" method="POST" class="login__form">
                            {{ csrf_field() }}
                            @if (session()->has('success'))
                                <div class="form__alert form__alert--success form__alert--overview">{{ session()->get('success') }}</div>
                            @endif
                            @if ($errors->has('auth'))
                                <div class="form__alert form__alert--error form__alert--overview">{{ $errors->first('auth') }}</div>
                            @endif
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
                            <button type="submit" class="form__btn">SIGN IN</button>
                        </form>
                        <a href="/admin/forgot-password" class="login__link">Forgotten your password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
