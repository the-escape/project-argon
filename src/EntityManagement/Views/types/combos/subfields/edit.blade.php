@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Subfield</h1>
        </div>
    </header>

    <form action="{{ route('cms:types:combos:fields:update', [$type->id, $combo->id, $field->id]) }}" method="POST">

        <main class="c-container c-container--main">

            @include('argon::inc.new-alerts')

            <div class="o-form">

                <div class="o-form__title">Edit subfield</div>

                <div class="o-form__group {{ hasError($errors, 'name') ? 'has-error' : '' }}">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="name">Name*</label>
                            <input type="text" id="name" name="name" placeholder="Name..." value="{{ old('name', $field->name) }}">
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

                <div class="o-form__group {{ hasError($errors, 'field_slug') ? 'has-error' : '' }}">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="field_slug">Slug*</label>
                            <input type="text" id="field_slug" name="field_slug" placeholder="Slug..." value="{{ old('field_slug', $field->field_slug) }}">
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
                                <label for="field_slug">{{ getError($errors, 'field_slug') }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="o-form__group {{ hasError($errors, 'field_type') ? 'has-error' : '' }}">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="field_type">Type*</label>
                            <select name="field_type" id="field_type" class="js-select">
                                <option value>Choose one...</option>
                                @foreach ($fieldTypes as $fieldType)
                                    <option value="{{$fieldType->getKey()}}" {{  $fieldType->getKey() == old('field_type', $field->field_type) ? 'selected' : '' }}>{{$fieldType->getName()}}</option>
                                @endforeach
                            </select>
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
                                <label for="field_type">{{ getError($errors, 'field_type') }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="o-form__title">Details</div>

                @include('argon::types.fields.loop', ['items'=>$field->type->getProperties()])

            </div>
        </main>

        <footer class="c-footer__wrapper">
            <div class="c-footer c-container c-footer--fixed">
                <div class="c-footer__container">

                    <div class="c-footer__buttons">
                        <div></div>
                        <div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <a class="o-btn o-btn--sm" href="{{route('cms:types:combos:edit', [$type->id, $combo->id])}}">Cancel</a>
                            <input type="submit" class="o-btn o-btn--sm o-btn--primary" value="Save">
                        </div>
                    </div>

                </div>
            </div>
        </footer>

@endsection
