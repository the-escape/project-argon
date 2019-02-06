@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

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

    <main class="c-container c-container--main">
        <form action="{{ route('cms:menus:save') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('argon::inc.alerts')

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
                    <div class="c-menus-form">

                        <div>
                            <div class="o-form__title">Menu tree</div>
                            <div id="navtree"></div>
                            <div>
                                <button id="navtree-add-root" class="o-btn o-btn--sm">Add new item</button>
                                <button id="navtree-add-child" class="o-btn o-btn--sm">Add child item</button>
                                <button id="navtree-remove" class="o-btn o-btn--sm">Remove item</button>
                            </div>
                        </div>

                        <div>
                            <div id="navtree-form">

                                <div class="o-form__title">Edit item</div>


                                <div class="form-group">
                                    <label for="item_label" class="required">Label</label>
                                    <input type="text" class="form-control required" id="item_label" name="item_label" placeholder="Label">
                                </div>

                                <div class="form-group">
                                    <label for="item_url" class="required">URL</label>
                                    <input type="text" class="form-control required " id="item_url" name="item_url" placeholder="URL">
                                </div>

                                <div class="form-group">
                                    <label for="item_class" class="required">Class(es)</label>
                                    <input type="text" class="form-control required " id="item_class" name="item_class" placeholder="Class(es)">
                                </div>

                                <div class="form-group">
                                    <label for="item_id" class="required">ID</label>
                                    <input type="text" class="form-control required " id="item_id" name="item_id" placeholder="ID">
                                </div>

                                <div class="form-group">
                                    <label for="item_target" class="required">Target</label>
                                    <input type="text" class="form-control required " id="item_target" name="item_target" placeholder="Target">
                                </div>

                                <div>
                                    <button id="navtree-update" class="o-btn o-btn--sm">Update item</button>
                                    <button id="navtree-deselect" class="o-btn o-btn--sm">Deselect</button>
                                </div>


                            </div>

                            <textarea id="navtree-output" class="form-control" name="menu">{{ old("menu") }}</textarea>

                        </div>
                    </div>
                </div>
                <div class="c-actions">
                    <div class="c-actions__group">
                        <button type="submit" class="o-btn o-btn--primary">save</button>
                        <a href="{{ route('cms:menus:manage') }}" class="o-btn o-btn--light-grey">Cancel Changes</a>
                    </div>
                </div>
            </div>
        </form>
    </main>
@stop

@section('styles')
    @include("argon_menus::styles")
@stop

@section('footer')
    @include("argon_menus::scripts")
@stop
