@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Page</h1>
        </div>
        <div class="c-tab__nav">
            <ul>
                <li>
                    <a class="c-tab__btn active" href="{{ route('cms:content:create') }}">
                        <div class="c-tab__btn-container">
                            <span>Details</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </header>

    <form action="{{ route('cms:content:save', [$parentId, $type->id]) }}" method="POST">

        <main class="c-container c-container--main">

            @include('argon::inc.alerts', compact($errors))

            <div class="o-form">
                <div class="pull-right">
                    @if(!$groups->isEmpty())
                        <a href="#" class="accordion-expand-collapse pull-md-right" data-expand="Expand All" data-collapse="Collapse All">Expand all</a>
                    @endif
                </div>

                <div class="o-form__title">Create Content</div>



                <div class="card">
                    <div class="card-header">Details</div>
                    <div class="card-block">
                        <div class="o-form__group {{ hasError($errors, 'name') ? 'has-error' : '' }}">
                            <div class="o-form-status">
                                <div class="o-form-status__input">
                                    <label for="name">Name*</label>
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
                                    <label for="slug">URL Slug*</label>
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

                        <div class="o-form__group {{ hasError($errors, 'status') ? 'has-error' : '' }}">
                            <div class="o-form-status">
                                <div class="o-form-status__input">
                                    <label for="status1">Published</label>
                                </div>
                                <div></div>
                                <div class="o-form__list">

                                    <div class="o-radio">
                                        <label>
                                            <input type="radio" name="status" {{ old('status') == '1' ? 'checked="checked"' : '' }} id="status1" value="1">
                                            <span></span>
                                        </label>
                                        <label for="status1">Yes</label>
                                    </div>

                                    <div class="o-radio">
                                        <label>
                                            <input type="radio" name="status" {{ old('status') != '1' ? 'checked="checked"' : '' }} id="status0" value="0">
                                            <span></span>
                                        </label>
                                        <label for="status0">No</label>
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
                                        <label for="roles">{{ getError($errors, 'status') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card accordion">

                    <div class="card-header accordion-header">301 Redirect</div>

                    <div class="card-block accordion-body">

                        <div class="form-group">
                            <label for="redirect-url" class="required">Enter redirect URL</label>
                            <input type="text" id="redirect-url" class="form-control" name="redirect_url" value="{{ old('redirect_url') }}">
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

                                    @if($group->isRenderable())
                                        <div class="o-checkbox checkbox">
                                            <label>
                                                <input type="hidden" name="group_render[{{$group->id}}]" value="0" class="js-toggle-value">
                                                <input class="js-toggle-input" type="checkbox" name="group_render[{{$group->id}}]" value="1" @if($page->isGroupRender($localisation->getLocaleId(), $group->id)) checked @endif>
                                                <span><svg><use xlink:href="/argon/images/svgicons.svg#tick"></use></svg></span>
                                                <label>Render?</label>
                                            </label>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-block accordion-body">

                                    <script>
                                        window.fieldGroups = window.fieldGroups || {}
                                        window.fieldGroups['{{$group->id}}'] = {!! json_encode($group->getFieldsWithValues(),JSON_PRETTY_PRINT) !!}
                                    </script>
                                    <div class="js-fields" data-name="{{$group->id}}"></div>
                                    <!-- <div class="o-form l-container js-temple-forms" data-group-id="{{$group->id}}"></div> -->

                                    <?php /*
                                    @foreach ($group->getFields() as $field)

                                        <div class="form-group sortable">

                                            {!! $field->render() !!}

                                        </div>

                                    @endforeach
                                    */ ?>

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

                                                @if($group->isRenderable())
                                                    <div class="o-checkbox checkbox">
                                                        <label>
                                                            <input type="hidden" name="group_render[{{$group->id}}]" value="0" class="js-toggle-value">
                                                            <input class="js-toggle-input" type="checkbox" name="group_render[{{$group->id}}]" value="1">
                                                            <span><svg><use xlink:href="/argon/images/svgicons.svg#tick"></use></svg></span>
                                                            <label>Render?</label>
                                                        </label>
                                                    </div>
                                                @endif

                                            </div>

                                            <div class="card-block accordion-body">

                                                <script>
                                                    window.fieldGroups = window.fieldGroups || {}
                                                    window.fieldGroups['{{$group->id}}'] = {!! json_encode($group->getFieldsWithValues(),JSON_PRETTY_PRINT) !!}
                                                </script>
                                                <div class="js-fields" data-name="{{$group->id}}"></div>
                                                <!-- <div class="o-form l-container js-temple-forms" data-group-id="{{$group->id}}"></div> -->
                                                <?php /*
                                                @foreach ($group->getFields() as $field)

                                                    <div class="form-group sortable">

                                                        {!! $field->render() !!}

                                                    </div>

                                                @endforeach
                                                */ ?>

                                            </div>

                                        </div>

                                    </div>

                                @endif

                            @endforeach

                        </div>

                    @endif


                @endif

            </div>

        </main>

        <footer class="c-footer__wrapper">
            <div class="c-footer c-container c-footer--fixed">
                <div class="c-footer__container">

                    <div class="c-footer__buttons">
                        <div></div>
                        <div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <a href="{{ route('cms:pages:manage') }}" class="o-btn o-btn--sm">Cancel</a>
                            <input type="submit" class="o-btn o-btn--sm o-btn--primary js-save" value="Save">
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

                    <button type="button" class="btn btn-primary btn-upload">Upload</button>
                    <button type="button" class="btn btn-primary btn-list">Change View</button>

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
                    <button type="button" class="btn btn-primary btn-submit" disabled>Select</button>
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

@section('footer')
    @parent

    @include('argon::fields.templates')
@stop


