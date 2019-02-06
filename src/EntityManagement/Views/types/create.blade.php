@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Content Type</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:types:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Types</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:types:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New type</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <form action="{{ route('cms:types:create') }}" method="POST" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <main class="c-container c-container--main">

            @include('argon::inc.alerts')

            <div class="c-actions__container">
                <div class="c-actions__content">
                    <div class="o-form">

                        <div class="o-form__title">Create new content type</div>

                        <div class="o-form__group {{ hasError($errors, 'name') ? 'has-error' : '' }}">
                            <div class="o-form-status">
                                <div class="o-form-status__input">
                                    <label for="name">Name*</label>
                                    <input type="text" id="name" name="name" placeholder="Name..." value="{{ old('name') }}">
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
                                        <label for="name">{{ getError($errors, 'name') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br><br>
                </div>
                <div class="c-actions">
                     <div class="c-actions__group">
                        <button type="submit" class="o-btn o-btn--primary">Save</button>
                        <a href="{{ route('cms:types:manage') }}" class="o-btn ">Cancel</a>
                    </div>
                </div>
            </div>
        </main>
    </form>

@endsection
