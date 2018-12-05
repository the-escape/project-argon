@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Field Group</h1>
        </div>
    </header>

    <form action="{{ route('cms:types:groups:update', [$type->id, $group->id]) }}" method="POST" autocomplete="false">

        <main class="c-container c-container--main">

            @include('argon::inc.new-alerts')

            <div class="o-form">

                <div class="o-form__title">Edit field group</div>

                <div class="o-form__group {{ hasError($errors, 'name') ? 'has-error' : '' }}">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="name">Name*</label>
                            <input type="text" id="name" name="name" placeholder="Name..." value="{{ old('name', $group->name) }}">
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

                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form__list">
                            <div class="o-checkbox">
                                <input type="hidden" name="sortable" class="js-toggle-value" value="{{ $group->sortable ? '1' : '0' }}">
                                <label>
                                    <input type="checkbox" value="1" id="sortable" class="js-toggle-input" {{ $group->sortable ? 'checked' : '' }}>
                                    <span><svg><use xlink:href="/argon/images/svgicons.svg#tick"></use></svg></span>
                                </label>
                                <label for="sortable">Sortable</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form__list">
                            <div class="o-checkbox">
                                <input type="hidden" name="renderable" class="js-toggle-value" value="{{ $group->renderable ? '1' : '0' }}">
                                <label>
                                    <input type="checkbox" value="1" id="renderable" class="js-toggle-input" {{ $group->renderable ? 'checked' : '' }}>
                                    <span><svg><use xlink:href="/argon/images/svgicons.svg#tick"></use></svg></span>
                                </label>
                                <label for="renderable">Renderable</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="o-form__title">Settings</div>




                <div class="form-group">

                    @if($settings = old('settings'))

                        @foreach($settings as $setting)
                            @include('argon::groups.setting', ['key'=>$setting['key'], 'value'=>$setting['value']])
                        @endforeach

                    @else

                        @forelse ($group->settings as $key => $value)
                            @include('argon::groups.setting')
                        @empty

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="settings[slug][key]" placeholder="slug" value="slug">
                                        <div class="input-group-addon">
                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="settings[slug][value]" placeholder="{{ str_slug(old('name', $group->name)) }}" value="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="settings[location][key]" placeholder="Key" value="location">
                                        <div class="input-group-addon">
                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="settings[location][value]" placeholder="i.e. sidebar" value="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="settings[image][key]" placeholder="Key" value="image">
                                        <div class="input-group-addon">
                                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="settings[image][value]" placeholder="url string" value="">
                                </div>
                            </div>

                            @include('argon::groups.setting')
                        @endforelse

                    @endif

                    <a href="#" class="o-btn o-btn--sm" id="settings-add">Add Option</a>
                </div>





            </div>
        </main>

        <footer class="c-footer__wrapper">
            <div class="c-footer c-container c-footer--fixed">
                <div class="c-footer__container">

                    <div class="c-footer__buttons">
                        <div></div>
                        <div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <a class="o-btn o-btn--sm" href="{{route('cms:types:groups', [$type->id])}}">Cancel</a>
                            <input type="submit" class="o-btn o-btn--sm o-btn--primary" value="Save">
                        </div>
                    </div>

                </div>
            </div>
        </footer>

    </form>

@endsection
