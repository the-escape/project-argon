@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <a href="{{ route('cms:redirects:manage') }}" class="c-header__back">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#arrow-left"></use>
                </svg>
            </a>
            <h1>Redirection</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:redirects:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Redirections</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:redirects:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New redirection</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <main class="c-container c-container--main">
        <form action="{{ route('cms:redirects:create') }}" method="POST" autocomplete="off">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('argon::inc.alerts')

            <div class="c-actions__container">
                <div class="c-actions__content">
                    <div class="o-form">
                        <div class="o-form__title">Create new redirection</div>
                        <div class="o-form__group">
                            <div class="o-form-status">
                                <div class="o-form-status__input">
                                    <label for="name">From*</label>
                                    <input type="text" id="from" name="from" placeholder="From..." value="{{ old('from') }}">
                                </div>
                                <div class="o-form-status__message">
                                    <div class="o-form-status__icon">
                                        <div class="o-form-status__icon--error">
                                            <svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
                                        </div>
                                        <div class="o-form-status__icon--success">
                                            <svg><use xlink:href="/argon/images/svgicons.svg#success"></use></svg>
                                        </div>
                                    </div>
                                    <div class="o-form-status__message-bar">
                                        <label for="from">Error Message</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="o-form__group">
                            <div class="o-form-status">
                                <div class="o-form-status__input">
                                    <label for="to">To*</label>
                                    <input type="text" id="to" name="to" placeholder="To..." value="{{ old('to') }}">
                                </div>
                                <div class="o-form-status__message">
                                    <div class="o-form-status__icon">
                                        <div class="o-form-status__icon--error">
                                            <svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
                                        </div>
                                        <div class="o-form-status__icon--success">
                                            <svg><use xlink:href="/argon/images/svgicons.svg#success"></use></svg>
                                        </div>
                                    </div>
                                    <div class="o-form-status__message-bar">
                                        <label for="to">Error Message</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="c-actions">
                    <div class="c-actions__group">
                        <button type="submit" class="o-btn o-btn--primary">save</button>
                        <a href="{{ route('cms:redirects:manage') }}" class="o-btn o-btn--light-grey">cancel changes</a>
                    </div>
                </div>
            </div>
        </form>
    </main>

@endsection
