@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')
    <script>
        window.fieldGroups = {}
        window.groups = []
    </script>

    <form action="{{ route('cms:blocks:update', [$page->getId(), $localisation->getLocaleId()]) }}" class="o-form" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @include('argon::inc.alerts', compact($errors))

        <div class="js-tabs c-page">
            <header class="c-header c-container">
                <div class="c-header__title">
                    <h1>{{$page->name}}</h1>
                </div>
                <div class="c-tab__nav js-tabs-nav">
                    <ul>
                        @foreach($tabNav as $tab)
                        <li>
                            <button class="c-tab__btn @if($tab['isActive']) active @endif" data-tab="{{ $tab['slug'] }}">
                                <div class="c-tab__btn-container">
                                    <span>{{ $tab['name'] }}</span>
                                </div>
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </header>

            <div class="c-tab-panel__list js-tabs-list">
                <div class="c-tab-panel active" data-tab="block-content">
                    <main class="c-tab-panel__container c-container">
                        <div class="c-actions__container">
                            <div class="c-actions__content">
                                <div class="js-page-edit"></div>
                            </div>

                            <div class="c-actions">
                                <div class="c-actions__group">
                                    <a href="{{ route('cms:blocks:create', ['typeId'=>$page->type->id]) }}" class="o-icon-btn preview-page" >
                                        <div class="o-icon-btn__wrap">
                                            <div class="o-icon-btn__icon">
                                                <svg>
                                                    <use xlink:href="/argon/images/svgicons.svg#add"></use>
                                                </svg>
                                            </div>
                                            <div class="o-icon-btn__label">Add another</div>
                                        </div>
                                    </a>
                                    <button type="submit" class="o-icon-btn o-icon-btn--success save-publish js-save">
                                        <div class="o-icon-btn__wrap">
                                            <div class="o-icon-btn__icon">
                                                <svg>
                                                    <use xlink:href="/argon/images/svgicons.svg#tick"></use>
                                                </svg>
                                            </div>
                                            <div class="o-icon-btn__label">Save</div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="c-tab-panel" data-tab="attributes">
                    <main class="c-tab-panel__container c-container">
                        <div class="c-actions__container">
                            <div class="c-actions__content c-tab-panel__inner-container l-full">
                                <h2>Attributes</h2>

                                <div class="o-form__group {{ hasError($errors, 'name') ? 'has-error' : '' }}">
                                    <div class="o-form-status">
                                        <div class="o-form-status__input">
                                            <label for="name" class="required">Name*</label>
                                            <input type="text" id="name" name="name" value="{{ old('name', $page->name) }}">
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
                                            <label for="slug" class="required">URL Slug*</label>
                                            <input type="text" id="slug" name="slug" value="{{ old('slug', $page->slug) }}">
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

                            <div class="c-actions">
                                <div class="c-actions__group">
                                    <a href="{{ route('cms:blocks:create', ['typeId'=>$page->type->id]) }}" class="o-icon-btn preview-page" >
                                        <div class="o-icon-btn__wrap">
                                            <div class="o-icon-btn__icon">
                                                <svg>
                                                    <use xlink:href="/argon/images/svgicons.svg#add"></use>
                                                </svg>
                                            </div>
                                            <div class="o-icon-btn__label">Add another</div>
                                        </div>
                                    </a>
                                    <button type="submit" class="o-icon-btn o-icon-btn--success save-publish js-save">
                                        <div class="o-icon-btn__wrap">
                                            <div class="o-icon-btn__icon">
                                                <svg>
                                                    <use xlink:href="/argon/images/svgicons.svg#tick"></use>
                                                </svg>
                                            </div>
                                            <div class="o-icon-btn__label">Save</div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>

                @if(!$page->getGroups($localisation->getLocaleId())->isEmpty())
                    @foreach($page->getGroups($localisation->getLocaleId()) as $group)
                        <div class="c-tab-panel" data-tab="group-{{ $group->id }}">
                            <main class="c-tab-panel__container c-container">
                                <div class="c-tab-panel__inner-container l-full">
                                    <h2>{{ $group->name }}</h2>
                                    <?php
                                        $isRendering = $page->isGroupRender($localisation->getLocaleId(), $group->id) ? '1' : '0';
                                    ?>
                                    <script>
                                        window.groups.push({
                                            id: '{{$group->id}}',
                                            isRenderable: {{ $group->isRenderable() ? 1 : 0 }},
                                            isRendering: {{ $isRendering }},
                                            isSortable: {{ $group->isSortable() ? 1 : 0 }},
                                            name: '{{ $group->name }}',
                                            isTab: {{ $group->getSetting('isTab') ? 1 : 0 }},
                                            image: '{{ $group->getSetting("image") }}'
                                        });
                                        window.fieldGroups['{{$group->id}}'] = {!! json_encode($group->getFieldsWithValues($page, $localisation, $latest),JSON_PRETTY_PRINT) !!}
                                    </script>
                                    <div class="js-fields" data-name="{{$group->id}}"></div>
                                </div>
                            </main>
                            <footer class="c-footer__wrapper">
                                <div class="c-footer c-container c-footer--fixed">
                                    <div class="c-footer__container">
                                        <div class="c-footer__buttons">
                                            <div>
                                                <button class="o-btn o-btn--sm js-tab-btn" data-tab="block-content">Back</a>
                                            </div>
                                            <div>
                                                <button class="o-btn o-btn--sm o-btn--success js-tab-btn" data-tab="block-content">OK</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </footer>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- <main class="c-container c-container--main" hidden>
            @if(\Escape\Argon\Locales\Eloquent\Locale::count() > 1)

                <ul class="nav nav-tabs">
                    @foreach ($page->getLocalisations() as $l)
                        <li class="nav-item">
                            <a class="nav-link @if ($l->getId() == $localisation->getId()) active @endif"
                                href="{{ route('cms:blocks:edit_locale', [$page->getId(), $l->getLocaleId()])}}">
                                {{$l->getLocale()->getName()}}
                            </a>
                        </li>
                    @endforeach
                    @if (!$locales->isEmpty())
                        <li class="nav-item">
                            <a class="nav-link add-localisation" href="">+ Add Localisation</a>
                        </li>
                    @endif
                </ul>

                <br>
            @endif
        </main> --}}
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

    <div class="modal fade" id="newLocalisationModal" tabindex="-1" role="dialog" aria-labelledby="newLocalisationLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="newLocalisationLabel">Add A New Localisation</h4>
                </div>
                <form action="{{ route('cms:blocks:create_locale', [$page->getId()]) }}" method="POST">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <select name="locale">
                                    <option value="">Select a Locale</option>
                                    @foreach ($locales as $locale)
                                        <option value="{{$locale->getId()}}">{{$locale->getName()}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="chk-field chk-label">
                                    <input type="hidden" name="clone" value="0" class="chk-default">
                                    <input type="checkbox" name="clone" value="1" class="chk-input">
                                    <span class="chk-text">Clone content</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@stop
