@extends ('argon.auth::layouts.main')
@section ('body')
    <div class="login">
        <div class="container full-height">
            <div class="row full-height">
                <div class="col-sm-6 col-sm-offset-3 full-height">
                    <div class="login__box">
                        <img class="login__logo" src="/argon/assets/img/e.png" width="38" height="63" alt="logo">
                        <form action="/admin/forgot-password" method="POST" class="login__form">
                            {{ csrf_field() }}
                            <div class="login__group">
                                <input type="text" name="email" placeholder="Email*" class="form__text form__text--borderless" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <div class="form__alert form__alert--error">{{ $errors->first('email') }}</div>
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
