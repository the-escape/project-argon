@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Field</h1>
        </div>
    </header>

    <form action="{{ route('cms:types:fields:save', [$type->id]) }}" method="POST" autocomplete="off">

        <main class="c-container c-container--main">

            @include('argon::inc.new-alerts')

            <div class="o-form">

                <div class="o-form__title">Create new field</div>

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
                            <label for="field_slug">Slug*</label>
                            <input type="text" id="field_slug" name="field_slug" placeholder="Slug..." value="{{ old('field_slug') }}">
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
                                <label for="field_slug">Error Message</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="field_type">Type*</label>
                            <select name="field_type" id="field_type" class="js-select">
                                <option value>Choose one...</option>
                                @foreach ($fieldTypes as $fieldType)
                                    <option value="{{$fieldType->getKey()}}" {{  $fieldType->getKey() == old('field_type') ? 'selected' : '' }}>{{$fieldType->getName()}}</option>
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
                                <label for="field_type">Error Message</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="group">Field Group*</label>
                            <div class="l-halves l-internal-columns">
                                <select name="group" id="group" class="js-select">
                                    <option value>Choose one...</option>
                                    <?php
                                    $submittedGroup = old('group');
                                    $selected = 0;
                                    ?>
                                    @foreach ($fieldGroups as $fieldGroup)
                                        @if($fieldGroup->id == $submittedGroup)
                                            <?php $selected = 1;?>
                                            <option value="{{$fieldGroup->id}}" selected>{{$fieldGroup->name}}</option>
                                        @else
                                            <option value="{{$fieldGroup->id}}">{{$fieldGroup->name}}</option>
                                        @endif
                                    @endforeach

                                    @if($submittedGroup && !$selected)
                                        <option value="{{$submittedGroup}}" selected="selected">{{$submittedGroup}}</option>
                                    @endif
                                </select>
                                <input type="text" class="js-create-new-group" placeholder="... or create new">
                            </div>
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
                                <label for="group">Error Message</label>
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
                        <div></div>
                        <div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <a class="o-btn o-btn--sm" href="{{route('cms:types:edit', [$type->id])}}">Cancel</a>
                            <input type="submit" class="o-btn o-btn--sm o-btn--primary" value="Save">
                        </div>
                    </div>

                </div>
            </div>
        </footer>

    </form>

@endsection

@section('footer')
    @parent

    <script>
        $(function(){
            $('.js-create-new-group').on('keydown', function(e){
                if(e.key === "Enter" || e.which === 13 || e.keyCode === 13) {
                    e.preventDefault();

                    var newGroup = $(this).val(),
                        select = $(this).closest('.o-form__group').find('.js-select')[0];

                    select.choices.setValue([newGroup]);

                    return false;
                }
            })
        });
    </script>
@endsection