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
                    <a class="c-tab__btn" href="{{ route('cms:types:create') }}">
                        <div class="c-tab__btn-container">
                            <span>New type</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:types:edit', [$type->id]) }}">
                        <div class="c-tab__btn-container">
                            <span>Edit {{ $type->name }}</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <form action="{{ route('cms:types:update', [$type->id]) }}" method="POST" autocomplete="false">

        <main class="c-container c-container--main">

            @include('argon::inc.new-alerts')

            <div class="o-form">
                <div class="o-form__title">Edit type</div>
                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form-status__input">
                            <label for="name">Name*</label>
                            <input type="text" id="name" name="name" placeholder="Name..." value="{{ old('name', $type->name) }}">
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

                <div class="o-form__title">Type</div>
                <div class="o-form__group">
                    <div class="o-form-status">
                        <div class="o-form__list">

                            <div class="o-radio">
                                <label>
                                    <input type="checkbox" name="type" {{ $type->type == 'page' ? 'checked="checked"' : '' }} id="type-page" value="page">
                                    <span></span>
                                </label>
                                <label for="type-page">Page</label>
                            </div>
                            <div class="o-radio">
                                <label>
                                    <input type="checkbox" name="type" {{ $type->type == 'block' ? 'checked="checked"' : '' }} id="type-block" value="block">
                                    <span></span>
                                </label>
                                <label for="type-block">Block</label>
                            </div>
                            <div class="o-radio">
                                <label>
                                    <input type="checkbox" name="type" {{ $type->type == 'email' ? 'checked="checked"' : '' }} id="type-email" value="email">
                                    <span></span>
                                </label>
                                <label for="type-email">Email</label>
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
                                <label for="type">Error Message</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="o-form__title">Fields</div>

                <div class="o-form__group">
                    @if(($groups = $type->groups) && (!$groups->isEmpty()))

                        <input id="order-{{$type->id}}" type="hidden" name="order">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Type</th>
                                <th>Group</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="sortable" data-sortable_field="order-{{$type->id}}">
                            @foreach ($groups as $group)
                                @foreach ($group->fields as $field)
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
                                            {{ @$field->group->name }}

                                            @if(empty($lastGroup) || $lastGroup !== $field->group->id)
                                                <textarea class="json-textbox">{!! json_encode($field->group->exportJson(), JSON_PRETTY_PRINT)  !!}</textarea>
                                                <a class="js-export-copy-to-clipboard text-muted" data-toggle="tooltip" data-placement="top" title="Export Field Group" href="{{ route('cms:types:groups:export', [$type->id,$field->group->id]) }}"><span class="fa fa-files-o"></span></a>
                                                <span class="result"></span>
                                                {{--<a class="js-export-json text-muted" data-group-id="{{ $field->group->id }}" data-toggle="tooltip" data-placement="top" title="Export Field Group" href="{{ route('cms:types:groups:export', [$type->id,$field->group->id]) }}"><span class="fa fa-files-o"></span></a>--}}
                                                <?php $lastGroup = $field->group->id; ?>
                                            @endif
                                        </td>
                                        <td>
                                            @if($field->field_type == $comboFieldType->getKey())
                                                <a class="o-btn o-btn--xs" href="{{ route('cms:types:combos:edit', [$type->id, $field->id]) }}">Edit</a>
                                                <a class="o-btn o-btn--xs o-btn--danger confirm" data-confirm="This will remove combo and all subfields.\nAre you sure you want to continue?" href="{{ route('cms:types:combos:delete', [$type->id, $field->id]) }}">Remove</a>
                                            @else
                                                <a class="o-btn o-btn--xs" href="{{ route('cms:types:fields:edit', [$type->id, $field->id]) }}">Edit</a>
                                                <a class="o-btn o-btn--xs o-btn--danger confirm" href="{{ route('cms:types:fields:delete', [$type->id, $field->id]) }}">Remove</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    @endif

                        <a href="{{ route('cms:types:fields:add', [$type->id]) }}" class="o-btn o-btn--sm">Add Field</a>
                        <a href="{{ route('cms:types:combos:add', [$type->id]) }}" class="o-btn o-btn--sm">Add Combo</a>
                        <a href="{{ route('cms:types:groups', [$type->id]) }}" class="o-btn o-btn--sm">Show All Groups</a>
                        <a href="{{ route('cms:types:groups:import-json', [$type->id]) }}" class="o-btn o-btn--sm">Import Group</a>
                </div>


            </div>
        </main>

        <footer class="c-footer__wrapper">
            <div class="c-footer c-container c-footer--fixed">
                <div class="c-footer__container">

                    <div class="c-footer__buttons">
                        <div>
                            <a href="{{ route('cms:types:delete', ['id' => $type->id]) }}" onclick="return confirm('Are you sure you want to delete this user?');" class="o-btn o-btn--sm o-btn--danger">Delete</a>
                        </div>
                        <div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <a href="{{ route('cms:types:manage') }}" class="o-btn o-btn--sm">Cancel</a>
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
            $('.js-export-copy-to-clipboard').on('click', function(e){
                e.preventDefault();

                var $btn = $(this),
                    $textarea = $btn.parent().find('.json-textbox'),
                    $result = $btn.parent().find('.result');

                $textarea.select()
                    .on("focus", function() {
                        document.execCommand('selectAll',false,null)
                    })
                    .focus();

                var success = document.execCommand("copy");

                if(success){
                    $result.html('Copied!');

                    setTimeout(function(){
                        $result.html('');
                    }, 1000);
                }

            });
        });
    </script>
@endsection

@section('styles')

    <style>
        .json-textbox {
            display: inline-block !important;
            min-width: 1px !important;
            min-height: 1px !important;
            width: 1px !important;
            height: 1px !important;
            opacity: 0 !important;
            padding: 0 !important;
        }
    </style>

    @parent
@endsection