<?php
$fronEndPage = $page->toPage();
$defaultFronEndPageUrl = $fronEndPage->getUrl();
$pageLocaleSlug = $localisation->getLocale()->getSlug();
$localisedFrontEndPageUrl = $pageLocaleSlug.$defaultFronEndPageUrl;
$defaultLocalisation = $page->getDefaultLocalisation();
?>
@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')
    <script>
        window.fieldGroups = {}
        window.groups = []
    </script>

    <form action="{{ route('cms:pages:update', [$page->getId(), $localeId]) }}" class="o-form js-prevent-leave" method="POST" id="pageEditForm">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @include('argon::inc.alerts', compact($errors))

        <div class="js-tabs c-page">
            <header class="c-header c-container">
                <div class="c-header__title">
                    <div class="c-header__local-container">
                        <h1>{{$page->name}}</h1>
                    </div>

                    <div class="c-header__btns">
                        @foreach ($page->getLocalisations() as $l)
                            @if ($l->getId() == $localisation->getId())
                                <a href="@if($localSlug = $l->getLocale()->getSlug()) {{ '/'.$localSlug.$defaultFronEndPageUrl }} @else {{ $defaultFronEndPageUrl }} @endif"class="o-link" target="_blank">Go to live page</a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="c-header__nav c-tab__nav js-tabs-nav">
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
                <div class="c-tab-panel active" data-tab="page-content">
                    <main class="c-tab-panel__container c-container">
                        <div class="c-actions__container">
                            <div class="c-actions__content">
                                <div class="js-page-edit"></div>
                            </div>

                            <div class="c-actions">
                                <div class="c-actions__group">
                                    <button type="submit" class="o-btn o-btn--primary">Save</button>
                                    <a href="#" class="o-btn preview-page" data-preview-id="{{ $currentRevision->id }}">Preview</a>
                                    <button type="submit" class="o-btn" data-form-action="{{ route('cms:revisions:create', [$page->getId(), $localeId]) }}">Save draft</button>
                                    <a href="{{ route('cms:pages:manage') }}" class="o-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="c-tab-panel" data-tab="attributes">
                    <main class="c-tab-panel__container c-container">
                        <div class="c-actions__container">
                            <div class="c-actions__content c-tab-panel__inner-container l-full">
                                <h2>Page properties</h2>

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

                                <div class="o-form__group {{ hasError($errors, 'status') ? 'has-error' : '' }}">
                                    <div class="o-form-status">
                                        <div class="o-form-status__input">
                                            <label for="status1">Published</label>
                                            <div class="o-form__list">
                                                <div class="o-radio">
                                                    <label>
                                                        <input type="radio" name="status" {{ old('status', $page->status) == '1' ? 'checked="checked"' : '' }} id="status1" value="1">
                                                        <span></span>
                                                    </label>
                                                    <label for="status1">Yes</label>
                                                </div>

                                                <div class="o-radio">
                                                    <label>
                                                        <input type="radio" name="status" {{ old('status', $page->status) != '1' ? 'checked="checked"' : '' }} id="status0" value="0">
                                                        <span></span>
                                                    </label>
                                                    <label for="status0">No</label>
                                                </div>
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
                                                <label for="status1">{{ getError($errors, 'status') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h3>301 Redirects</h3>
                                @if($page->getLocalisations()->count() > 1)
                                    <div class="o-form__group">
                                        <div class="o-form-status">
                                            <div class="o-form-status__input">
                                                <label for="locale-redirect">Choose a locale redirect</label>
                                                <select name="locale-redirect" id="locale-redirect" class="field-poputale js-select" data-target="#redirect-url">
                                                    <option placeholder></option>
                                                    @foreach ($page->getLocalisations() as $l)
                                                        @if ($l->getId() != $localisation->getId())
                                                            <option value="@if($localSlug = $l->getLocale()->getSlug()){{'/'.$localSlug.$defaultFronEndPageUrl}}@else{{$defaultFronEndPageUrl}}@endif">@if($localSlug = $l->getLocale()->getSlug()) {{ '/'.$localSlug.$defaultFronEndPageUrl }} @else {{ $defaultFronEndPageUrl }} @endif</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="o-form__group">
                                    <div class="o-form-status">
                                        <div class="o-form-status__input">
                                            <label for="redirect-url" class="required">@if($page->getLocalisations()->count() > 1) Or enter @else Enter @endif redirect URL</label>
                                            <input type="text" id="redirect-url" name="redirect_url" value="{{ old('redirect_url', $fronEndPage->getRedirect($localisation->getLocale()->getId())) }}">
                                        </div>
                                    </div>
                                </div>

                                @if(($propertyGroups = $page->getGroups($localisation->getLocaleId())->filter(function($el) { return $el->getSetting('isAttribute') || $el->getSetting('isProperty'); } )) && !$propertyGroups->isEmpty())
                                    @foreach($propertyGroups as $group)

                                        <hr>

                                        <div>
                                            <?php
                                            $isRendering = $page->isGroupRender($localisation->getLocaleId(), $group->id) ? '1' : '0';
                                            ?>
                                            <script>
                                                window.fieldGroups['{{$group->id}}'] = {
                                                    fields: {!! json_encode($group->getFieldsWithValues($page, $localisation, $currentRevision),JSON_PRETTY_PRINT) !!},
                                                    header: "{!! $group->name !!}",
                                                    actions: false
                                                }
                                            </script>
                                            <div class="js-fields" data-name="{{$group->id}}"></div>
                                        </div>

                                    @endforeach
                                @endif

                            </div>

                            <div class="c-actions">
                                <div class="c-actions__group">
                                    <button type="submit" class="o-btn o-btn--primary">Save</button>
                                    <a href="#" class="o-btn preview-page" data-preview-id="{{ $currentRevision->id }}">Preview</a>
                                    <button type="submit" class="o-btn " data-form-action="{{ route('cms:revisions:create', [$page->getId(), $localeId]) }}">Save draft</button>
                                    <a href="{{ route('cms:pages:manage') }}" class="o-btn ">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>

                @if($revisionsTotal = $revisions->total())
                    <div class="c-tab-panel" data-tab="revisions">
                        <main class="c-tab-panel__container c-container">
                            <div class="c-actions__container">
                                <div class="c-actions__content c-tab-panel__inner-container l-full">
                                    <h2>Revisions ({{ $revisionsTotal }})</h2>

                                    @if($currentRevision->id != $publishedRevision->id)
                                        <span class="accordion-header-details" style="position: relative; top: -2px; float: right; font-size:83%;">
                                            You are now editing revision ID: {{ $currentRevision->id }}, created at {{ $currentRevision->created_at->format('d/m/Y H:i:s') }}, by user: {{ @$currentRevision->userWithTrashed->name }}.
                                            <a href="{{ route('cms:pages:edit_locale', ['page' => $page->getId(), 'locale'=>$localeId]) }}" class="btn btn-sm btn-warning confirm" data-confirm="This will discard any unsaved changes and take you back to published revision.\nYou can save changes as another revision without affecting live page by clickin 'Save Revision' button.\nAre you sure you want to continue?">Back to published revision</a>
                                        </span>
                                    @endif

                                    <div class="alert alert-info" role="alert">
                                        @if($currentRevision->id != $publishedRevision->id)
                                            <p>You are now editing revision ID: {{ $currentRevision->id }}, created at {{ $currentRevision->created_at->format('d/m/Y H:i:s') }}, by user: {{ @$currentRevision->userWithTrashed->name }}.</p>
                                            <p>This is not currently published revision.</p>
                                        @endif

                                        <p>Currently published revision ID: {{ $publishedRevision->id }}, created at {{ $publishedRevision->created_at->format('d/m/Y H:i:s') }}, by user: {{ @$publishedRevision->userWithTrashed->name }}.</p>

                                        @if($currentRevision->id != $publishedRevision->id)
                                            <p>
                                                <a href="{{ route('cms:pages:edit_locale', ['page' => $page->getId(), 'locale'=>$localeId]) }}" class="btn btn-sm btn-warning confirm" data-confirm="This will discard any unsaved changes and take you back to published revision.\nYou can save changes as another revision without affecting live page by clickin 'Save Revision' button.\nAre you sure you want to continue?">Back to published revision</a>
                                            </p>
                                        @endif
                                    </div>

                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Created At</th>
                                            <th>Created By</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($revisions as $revision)
                                            <tr>
                                                <td>{{ $revision->id }}</td>
                                                <td>{{ $revision->created_at->format('d/m/Y H:i:s') }}</td>
                                                <td>{{ $revision->user->name }}</td>
                                                <td>
                                                    <a href="{{ url($localisedFrontEndPageUrl) }}?preview_page={{ $revision->id }}" class="btn btn-primary preview-revision" data-preview-id="{{ $revision->id }}">Preview</a>

                                                    <a href="{{ route('cms:pages:edit_locale', [$page->getId(), $localeId, $revision->id]) }}" class="btn btn-primary confirm" data-confirm="This will load and allow editing the selected revision from {{ $revision->created_at->format('d/m/Y H:i:s') }} saved by user: {{ @$revision->userWithTrashed->name }} without affecting published page unless 'Save and Publish' button clicked.\nYou can load and edit and click 'Save Revision' to capture as new snapshot for further checks and review without impact on live - published page.\nAre you sure you want to continue?">Load/Edit Revision</a>

                                                    <a href="{{ route('cms:revisions:restore', [$revision->id]) }}" class="btn btn-warning confirm" data-confirm="This will overwrite current page content.\nSelected revision is from {{ $revision->created_at->format('d/m/Y H:i:s') }}.\nAre you sure you want to continue?">Restore Revision</a>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    @if($revisionsPagination['pages_count'] > 1)

                                        <?php
                                        $revisionsPresenter = paginationPresenter($revisionsPagination, '...', 1, 2, function($element, $hellip, $current_page_number)
                                        {
                                            if ($element != $hellip)
                                            {
                                                return '<li class="page-item class="'.(($element == $current_page_number) ? "active" : "").'"><a class="page-link" href="'.getUrlWithQueryString(['revisions'=>$element]).'">'.$element.'</a></li>';
                                            }
                                            return '<li class="page-item"><span class="page-link">'.$element.'</span></li>';
                                        });
                                        ?>

                                        <nav>
                                            <ul class="pagination pagination-sm">
                                                <li class="page-item @if(!$revisionsPagination['page_prev']) disabled @endif">
                                                    @if($revisionsPagination['page_prev'])
                                                        <a class="page-link" href="{{ getUrlWithQueryString(['revisions'=>$revisionsPagination['page_prev']])  }}" tabindex="-1">Previous</a>
                                                    @else
                                                        <span class="page-link">Previous</span>
                                                    @endif
                                                </li>

                                                @foreach ($revisionsPresenter as $li)
                                                    {!! $li !!}
                                                @endforeach

                                                <li class="page-item @if(!$revisionsPagination['page_next']) disabled @endif">
                                                    @if($revisionsPagination['page_next'])
                                                        <a class="page-link" href=" {{ getUrlWithQueryString(['revisions'=>$revisionsPagination['page_next']])  }}">Next</a>
                                                    @else
                                                        <span class="page-link">Next</span>
                                                    @endif
                                                </li>
                                            </ul>
                                        </nav>

                                    @endif
                                </div>

                                <div class="c-actions">
                                    <div class="c-actions__group">
                                        <button type="submit" class="o-btn o-btn--primary js-tab-btn" data-tab="page-content">Back</button>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                @endif

                @if(!$page->getGroups($localisation->getLocaleId())->isEmpty())
                    @foreach($page->getGroups($localisation->getLocaleId()) as $group)

                        @if(!$group->getSetting('isProperty') && !$group->getSetting('isAttribute'))

                            <div class="c-tab-panel" data-tab="group-{{ $group->id }}">
                                <main class="c-tab-panel__container c-container">
                                    <?php
                                        $isRendering = $page->isGroupRender($localisation->getLocaleId(), $group->id) ? '1' : '0';
                                    ?>
                                    <script>
                                        window.groups.push({
                                            id: '{{$group->id}}',
                                            isRenderable: {{ $group->isRenderable() ? 1 : 0 }},
                                            isRendering: {{ $isRendering }},
                                            isSortable: {{ $group->isSortable() ? 1 : 0 }},
                                            name: '{!! $group->name !!}',
                                            isTab: {{ $group->getSetting('isTab') ? 1 : 0 }},
                                            image: '{{ $group->getSetting("image") }}'
                                        });
                                        window.fieldGroups['{{$group->id}}'] = {
                                            fields: {!! json_encode($group->getFieldsWithValues($page, $localisation, $currentRevision), JSON_PRETTY_PRINT) !!},
                                            header: "{!! $group->name !!}"
                                        }
                                    </script>
                                    <div class="js-fields" data-name="{{$group->id}}"></div>
                                </main>
                            </div>

                        @endif

                    @endforeach
                @endif
            </div>

            {{-- <main class="c-container c-container--main" hidden>

                <div class="l-space-between l-space">
                    @foreach ($page->getLocalisations() as $l)
                        @if ($l->getId() == $localisation->getId())
                            <a href="@if($localSlug = $l->getLocale()->getSlug()) {{ '/'.$localSlug.$defaultFronEndPageUrl }} @else {{ $defaultFronEndPageUrl }} @endif" class="o-btn o-btn--sm o-btn--primary" target="_blank">View page</a>
                        @endif
                    @endforeach

                    @if(!$groups->isEmpty())
                        <button class="accordion-expand-collapse o-btn o-btn--sm" data-expand="Expand All" data-collapse="Collapse All">Expand all</button>
                    @endif
                </div>

                @if(\Escape\Argon\Locales\Eloquent\Locale::count() > 1)

                    <ul class="nav nav-tabs">
                        @foreach ($page->getLocalisations() as $l)
                            <li class="nav-item">
                                <a class="nav-link @if ($l->getLocaleId() == $localeId) active @endif"
                                href="{{ route('cms:pages:edit_locale', [$page->getId(), $l->getLocaleId()])}}" title="@if($localSlug = $l->getLocale()->getSlug()) {{ '/'.$localSlug.$defaultFronEndPageUrl }} @else {{ $defaultFronEndPageUrl }} @endif">
                                    {{$l->getLocale()->getName()}}
                                </a>
                                @if($defaultLocalisation->getLocaleId() !== $l->getLocaleId())
                                    <a href="{{ route('cms:pages:delete_locale', [$page->getId(), $l->getLocaleId()]) }}" class="locale-delete confirm" data-confirm="Are you sure you want to delete '{{$l->getLocale()->getName()}}' locale."><i class="fa fa-times" aria-hidden="true"></i></a>
                                @endif
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
        </div>
    </form>

    {{-- <div id="medialibrary" class="modal fade" role="dialog" aria-labelledby="medialibraryLabel" aria-hidden="true">
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
    </div> --}}

    {{-- @include('argon::pages.partials.medialib') --}}

    {{-- <div style="display: none;" id="preview-template">
        <div class="media-item">
            <img class="thumb" data-dz-thumbnail>
            <span class="filename" data-dz-name></span>
            <span class="filesize" data-dz-size></span>

            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            <progress class="progress" value="25" max="100"></progress>
        </div>
    </div> --}}

    <div class="modal fade" id="newLocalisationModal" tabindex="-1" role="dialog" aria-labelledby="newLocalisationLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="newLocalisationLabel">Add A New Localisation</h4>
                </div>
                <form action="{{ route('cms:pages:create_locale', [$page->getId()]) }}" method="POST">

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

@section('footer')
    @parent

    @include('argon::fields.templates')
@stop
