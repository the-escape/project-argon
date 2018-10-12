@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
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
                    <a class="c-tab__btn" href="{{ route('cms:redirects:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New redirection</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:redirects:edit', [$redirect->id]) }}">
                        <div class="c-tab__btn-container">
                            <span>Edit redirection</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <form action="{{ route('cms:redirects:update', [$redirect->id]) }}" method="POST" autocomplete="off">

        <main class="c-container c-container--main">

            @include('argon::inc.new-alerts')

            <div class="o-form">
                <div class="o-form__title">Edit redirection</div>
                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="name">From*</label>
                            <input type="text" id="from" name="from" placeholder="From..." value="{{ old('from', $redirect->from) }}">
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
                            <input type="text" id="to" name="to" placeholder="To..." value="{{ old('to', $redirect->to) }}">
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
        </main>

        <footer class="c-footer__wrapper">
            <div class="c-footer c-container c-footer--fixed">
                <div class="c-footer__container">

                    <div class="c-footer__buttons">
                        <div>
                            <a href="{{ route('cms:redirects:delete', ['id' => $redirect->id]) }}" onclick="return confirm('Are you sure you want to delete this redirection?');" class="o-btn o-btn--sm o-btn--danger">Delete</a>
                        </div>
                        <div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <a href="{{ route('cms:redirects:manage') }}" class="o-btn o-btn--sm">Cancel</a>
                            <input type="submit" class="o-btn o-btn--sm o-btn--primary" value="Save">
                        </div>
                    </div>

                </div>
            </div>
        </footer>

    </form>

@endsection
