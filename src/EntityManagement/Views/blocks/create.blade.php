@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')
    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Blocks</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:content:create') }}">
                        <div class="c-tab__btn-container">
                            <span>Create</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <form action="{{ route('cms:blocks:save', [$type->id]) }}" class="o-form" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <main class="c-container c-container--main">
            @include('argon::inc.alerts', compact($errors))

            <div class="l-align-end l-space">
                @if(!$groups->isEmpty())
                    <button class="accordion-expand-collapse o-btn o-btn--light-grey o-btn--sm" data-expand="Expand All" data-collapse="Collapse All">Expand all</button>
                @endif
            </div>

            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="o-form__group {{ hasError($errors, 'name') ? 'has-error' : '' }}"">
                        <div class="o-form-status">
                            <div class="o-form-status__input">
                                <label for="name" class="required">Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}">
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
                    <div class="o-form__group {{ hasError($errors, 'slug') ? 'has-error' : '' }}">
                        <div class="o-form-status">
                            <div class="o-form-status__input">
                                <label for="slug" class="required">URL Slug</label>
                                <input type="text" id="slug" name="slug" value="{{ old('slug') }}">
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
                                    <label for="slug">{{ getError($errors, 'slug') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(!$groups->isEmpty())

                <?php $sortable = []; ?>

                @foreach($groups as $group)

                    @if($group->isSortable())

                        <?php $sortable[] = $group; ?>

                    @else

                        <div class="card accordion">

                            <div class="card-header accordion-header">
                                <span>{{ $group->name }}</span>
                            </div>

                            <div class="card-block accordion-body">

                                <script>
                                    window.fieldGroups = window.fieldGroups || {}
                                    window.fieldGroups['{{$group->id}}'] = {!! json_encode($group->getFieldsWithValues(),JSON_PRETTY_PRINT) !!}
                                </script>
                                <div class="js-fields" data-name="{{$group->id}}"></div>

                            </div>

                        </div>
                    @endif
                @endforeach


                @if($sortable)

                    <?php $mt = str_replace('.', '', microtime(1)); ?>
                    <input id="order-{{ $mt }}" type="hidden" name="group_order" value="{{ old('group_order') }}">
                    <div class="sortable sortable-groups" data-sortable_field="order-{{ $mt }}">

                        @foreach($groups as $group)

                            @if($group->isSortable())

                                <div class="input-group sortable-item" data-sortable_item="{{$group->id}}">

                                    <div class="card accordion">

                                        <div class="card-header accordion-header">
                                            <span class="sortable-handle">&#8645;</span>
                                            <span>{{ $group->name }}</span>
                                        </div>

                                        <div class="card-block accordion-body">

                                            <script>
                                                window.fieldGroups = window.fieldGroups || {}
                                                window.fieldGroups['{{$group->id}}'] = {!! json_encode($group->getFieldsWithValues(),JSON_PRETTY_PRINT) !!}
                                            </script>
                                            <div class="js-fields" data-name="{{$group->id}}"></div>

                                        </div>

                                    </div>

                                </div>

                            @endif

                        @endforeach

                    </div>

                @endif


            @endif


        </main>

        <footer class="c-footer__wrapper">
            <div class="c-footer c-container c-footer--fixed">
                <div class="c-footer__container">

                    <div class="c-footer__buttons">
                        <div>
                            <a href="{{ route('cms:blocks:manage') }}" class="o-btn o-btn--sm">Back to blocks</a>
                        </div>
                        <div>
                            <button type="submit" class="o-btn o-btn--sm o-btn--primary">Save</button>
                        </div>
                    </div>

                </div>
            </div>
        </footer>
    </form>


    <div id="medialibrary" class="modal fade" role="dialog" aria-labelledby="medialibraryLabel" aria-hidden="true">
        <input type="hidden" id="selectedMediaItem" value="">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="medialibraryLabel">Media Library</h4>
                </div>
                <div class="modal-body">
                    <div class="media-library" style="position: relative;">
                        <div class="media-library-sidebar" style="position: absolute; width: 200px; left: 0; top: 0; bottom: 0; background: #ccc;">
                            <div class="folders">
                                <ul>
                                    @each('argon::media.folder', [$root], 'folder')
                                </ul>
                            </div>
                        </div>
                        <form class="dz" style="border: 1px dashed red; margin-left: 200px; min-height: 100px;">
                            <input type="hidden" name="current-folder" id="current-folder" value="1">
                            <div class="files">

                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" disabled>Select</button>
                </div>
            </div>
        </div>
    </div>

    @include('argon::pages.partials.medialib')

    <div style="display: none;" id="preview-template">
        <div class="media-item">
            <img class="thumb" data-dz-thumbnail>
            <span class="filename" data-dz-name></span>
            <span class="filesize" data-dz-size></span>

            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            <progress class="progress" value="25" max="100"></progress>
        </div>
    </div>
@stop


