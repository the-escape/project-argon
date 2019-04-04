@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <div class="c-page">
        <header class="c-header c-container">
            <div class="c-header__title">
                <h1>Menu</h1>
            </div>
            <div class="c-tab__nav">
                <ul>
                    <li>
                        <a class="c-tab__btn" href="{{ route('cms:menus:manage') }}">
                            <div class="c-tab__btn-container">
                                <span>All Menus</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="c-tab__btn active" href="{{ route('cms:menus:create') }}">
                            <div class="c-tab__btn-container">
                                <span>New menu</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </header>
        <div class="c-tab-panel__list js-tabs-list">
            <div class="c-tab-panel active" data-tab="page-content">
                <main class="c-tab-panel__container c-container">
                    <script>
                        window.menuJson = {!! $menuJson !!}
                        window.pagesJson = {!! $pagesJson !!}
                    </script>
                    <form action="{{ route('cms:menus:save') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('argon::inc.alerts', compact($errors))

                        <div class="c-actions__container">
                            <div class="c-actions__content">
                                <div class="o-form">
                                    <div class="o-form__title">Create new menu</div>
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
                                                <label for="slug">Slug*</label>
                                                <input type="text" id="slug" name="slug" placeholder="Slug..." value="{{ old('slug') }}">
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
                                                    <label for="slug">Error Message</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="c-menu-edit">
                                    <div class="js-menu-edit"></div>
                                    <input type="hidden" name="menu" class="js-menu-json" value="{{ $menuJson }}">
                                </div>

                            </div>
                            <div class="c-actions">
                                <div class="c-actions__group">
                                    <button type="submit" class="o-btn o-btn--primary">Save</button>
                                    <a href="{{ route('cms:menus:manage') }}" class="o-btn ">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>

@stop
