@extends('argon::layout.master')
@section('body')
    <div class="actions">
        <span>Create new user</span>
    </div>
    <div class="row">
        <div class="col-xs-5">
            <div class="form__group">
                <label for="name">Name*</label>
                <input id="name" type="text" class="form__text">
            </div>
            <div class="form__group">
                <label for="email">Email*</label>
                <input id="email" type="text" class="form__text">
            </div>
            <div class="form__group">
                <label for="password">Password*</label>
                <input id="password" type="text" class="form__text">
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    <div class="footer__container">
                        <div class="footer__right">
                            <a href="#" class="form__btn form__btn--grey">CANCEL</a><a href="#" class="form__btn">SAVE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
