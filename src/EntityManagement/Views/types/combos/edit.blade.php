@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Combo</h1>
        </div>
    </header>

    <form action="{{ route('cms:types:combos:update', [$type->id, $combo->id]) }}" method="POST" autocomplete="off">

        <main class="c-container c-container--main">

            @include('argon::inc.alerts')

            <div class="o-form">

                <div class="o-form__title">Edit combo</div>

                <div class="o-form__group {{ hasError($errors, 'name') ? 'has-error' : '' }}">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="name">Name*</label>
                            <input type="text" id="name" name="name" placeholder="Name..." value="{{ old('name', $combo->name) }}">
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
                            <input type="text" id="field_slug" name="field_slug" placeholder="Slug..." value="{{ old('field_slug', $combo->field_slug) }}">
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

                <div class="o-form__group {{ hasError($errors, 'group') ? 'has-error' : '' }}">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="group">Field Group*</label>
                            <div class="l-halves l-internal-columns">
                                <select name="group" id="group" class="js-select">
                                    <option value>Choose one...</option>
                                    <?php
                                        $submittedGroup = old('group', $combo->entity_group_id);
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

                @include('argon::types.fields.loop', ['field'=>$combo, 'items'=>$combo->type->getProperties()])

                <div class="o-form__title">Subfields</div>

                @if(($subfields = $combo->subfields) && (!$subfields->isEmpty()))

                    <input id="order-{{$combo->id}}" type="hidden" name="subfields_order">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Type</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="sortable" data-sortable_field="order-{{$combo->id}}">
                        @foreach($subfields as $field)
                            <tr class="sortable-item" data-sortable_item="{{$field->id}}">
                                <td>
                                    <span class="sortable-handle btn">&#8645;</span>
                                </td>
                                <td>
                                    <span data-toggle="tooltip" data-placement="left" title="Field ID: {{ $field->id }}">{{ $field->name }}</span>
                                </td>
                                <td>
                                    {{ $field->field_slug }}
                                </td>
                                <td>
                                    {{ $field->field_type }}
                                </td>
                                <td>
                                    <a class="o-btn o-btn--xs" href="{{ route('cms:types:combos:fields:edit', [$type->id, $combo->id, $field->id]) }}">Edit</a>
                                    <a class="o-btn o-btn--xs o-btn--danger confirm" href="{{ route('cms:types:combos:fields:delete', [$type->id, $combo->id, $field->id]) }}">Remove</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                @endif

                <a href="{{ route('cms:types:combos:fields:add', [$type->id, $combo->id]) }}" class="o-btn o-btn--sm">Add Subfield</a>

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
