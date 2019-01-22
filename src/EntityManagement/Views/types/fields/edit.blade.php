@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Field</h1>
        </div>
    </header>

    <form action="{{ route('cms:types:fields:update', [$type->id, $field->id]) }}" method="POST" autocomplete="off">

        <main class="c-container c-container--main">

            @include('argon::inc.alerts')

            <div class="o-form">

                <div class="o-form__title">Edit field</div>

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


                <div class="o-form__group {{ hasError($errors, 'group') ? 'has-error' : '' }}">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="group">Field Group*</label>
                            <div class="l-halves l-internal-columns">
                                <select name="group" id="group" class="js-select">
                                    <option value>Choose one...</option>
                                    <?php
                                    $submittedGroup = old('group', $field->entity_group_id);
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
                                <input type="text" name="group_new" id="group_new" placeholder="... or create new" value="{{ old('group_new') }}">
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
                                <label for="group">{{ getError($errors, 'group') }}</label>
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

                            <a class="o-btn o-btn--sm" href="{{route('cms:types:edit', [$type->id])}}">Cancel</a>
                            <input type="submit" class="o-btn o-btn--sm o-btn--primary" value="Save">
                        </div>
                    </div>

                </div>
            </div>
        </footer>

    </form>








<?php /*







    <div class="main">
        <h1 class="page-header">Edit Field</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:types:fields:update', [$type->id, $field->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'name') }}" id="name" name="name" placeholder="Name" value="{{ old('name', $field->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="field_slug" class="required">Slug</label>
                        <input type="text" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'field_slug') }}" id="field_slug" name="field_slug" placeholder="Slug" value="{{ old('field_slug', $field->field_slug) }}">
                    </div>
                    <div class="form-group">
                        <label for="field_type" class="required">Type</label>
                        <select class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'field_type') }}" name="field_type" id="field_type">
                            <option value="">Choose one...</option>
                            @foreach ($fieldTypes as $fieldType)
                                <option value="{{$fieldType->getKey()}}" @if (old('field_type', $field->field_type) == $fieldType->getKey()) selected="selected" @endif >{{$fieldType->getName()}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="group" class="required">Field Group</label>
                        <select class="form-control groupCreate required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'group') }}" name="group" id="group">
                            <option value="">Choose one...</option>

                            <?php
                                $submittedGroup = old('group', $field->entity_group_id);
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

                            <option class="create-new" value="">Create new</option>
                        </select>
                    </div>

                    @include('argon::types.fields.loop', ['items'=>$field->type->getProperties()])

                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
        </form>
    </div>


 */ ?>
@endsection

@section('footer')
    @parent

    <script>
        $(function(){
            $('.js-create-new-group').on('keydown', function(e){
                if(event.key === "Enter" || e.which == 13 || e.keyCode == 13) {
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
