@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Locale</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:locales:manage') }}">
                        <div class="c-tab__btn-container">
                            <span>All Locales</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn" href="{{ route('cms:locales:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New locale</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:locales:edit', [$locale->id]) }}">
                        <div class="c-tab__btn-container">
                            <span>Edit {{ $locale->name }}</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <form action="{{ route('cms:locales:edit', [$locale->id]) }}" method="POST" autocomplete="false">

        <main class="c-container c-container--main">

            @include('argon::inc.new-alerts')

            <div class="o-form">
                <div class="o-form__title">Edit locale</div>
                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="name">Name*</label>
                            <input type="text" id="name" name="name" placeholder="Name..." value="{{ old('name', $locale->name) }}">
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
                            <label for="email">Language Code*</label>
                            <input type="text" id="languageCode" name="languageCode" placeholder="Language Code..." value="{{ old('languageCode', $locale->languageCode) }}">
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
                                <label for="languageCode">Error Message</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="region">Region*</label>
                            <input type="text" id="region" name="region" placeholder="Region..." value="{{ old('region', $locale->region) }}">
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
                                <label for="region">Error Message</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="locale_slug">Slug*</label>
                            <input type="text" id="locale_slug" name="locale_slug" placeholder="Slug..." value="{{ old('locale_slug', $locale->locale_slug) }}">
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
                                <label for="locale_slug">Error Message</label>
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
                            <a href="{{ route('cms:locales:delete', ['id' => $locale->id]) }}" onclick="return confirm('Are you sure you want to delete this locale?');" class="o-btn o-btn--sm o-btn--danger">Delete</a>
                        </div>
                        <div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a href="{{ route('cms:locales:manage') }}" class="o-btn o-btn--sm">Cancel</a>
                            <input type="submit" class="o-btn o-btn--sm o-btn--primary" value="Save">
                        </div>
                    </div>

                </div>
            </div>
        </footer>

    </form>
@endsection
