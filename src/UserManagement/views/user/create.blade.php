@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <a href="{{ route('cms:user:manage') }}" class="c-header__back">
                <svg>
                    <use xlink:href="/argon/images/svgicons.svg#arrow-left"></use>
                </svg>
            </a>
            <h1>User</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:user:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Users</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:user:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New user</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <main class="c-container c-container--main">
        <form action="{{ route('cms:user:create') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="c-actions__container">
                <div class="c-actions__content">
                    <div class="o-form">

                        <div class="o-form__title">Create new user</div>

                        <div class="o-form__group">
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
                                        <label for="name">Error Message</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="o-form__group">
                            <div class="o-form-status">
                                <div class="o-form-status__input">
                                    <label for="email">Email*</label>
                                    <input type="email" id="email" name="email" placeholder="Email..." value="{{ old('email') }}">
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
                                        <label for="email">Error Message</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="o-form__group">
                            <div class="o-form-status">
                                <div class="o-form-status__input">
                                    <label for="password">Password*</label>
                                    <input type="password" id="password" name="password" placeholder="Password..." value="{{ old('password') }}">
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
                                        <label for="password">Error Message</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="o-form__group">
                            <div class="o-form-status">
                                <div class="o-form-status__input">
                                    <label for="profile_image">Profile picture</label>

                                    <div class="o-file js-file">
                                        <div class="o-file__preview o-file__preview--small">
                                            <div class="o-file__preview-wrap">

                                                <div class="h-background--primary">
                                                    <img class="o-file__image-preview" src="/argon/images/user-icon.png">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="o-file__help-text">
                                            <p>
                                                Please upload your profile picture.
                                                <br><span class="h-text--grey-dark">Max file size: 1MB</span>
                                            </p>
                                            <label>
                                                <span class="o-btn o-btn--xs o-file__btn">select</span>
                                                <input type="file" class="o-file__input" name="profile_picture">
                                                <span class="o-file__name"></span>
                                            </label>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="c-actions">
                    <div class="c-actions__group">
                        <button type="submit" class="o-btn o-btn--primary">save</button>
                        <a href="{{ route('cms:user:manage') }}" class="o-btn o-btn--light-grey">cancel changes</a>
                    </div>
                </div>
            </div>
        </form>
    </main>

@endsection
