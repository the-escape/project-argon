<?php
$fronEndPage = $page->toPage();
$defaultFronEndPageUrl = $fronEndPage->getUrl();
$pageLocaleSlug = $localisation->getLocale()->getSlug();
$localisedFrontEndPageUrl = $pageLocaleSlug.$defaultFronEndPageUrl;
?>
@extends('argon::layout.master')

@section('content')
    <div class="main">

        <div class="row">
            <div class="col-md-9">
                <h1>Edit Page</h1>
            </div>
            <div class="col-md-3">
                @if(!$groups->isEmpty())
                    <a href="#" class="accordion-expand-collapse pull-md-right" data-expand="Expand All" data-collapse="Collapse All">Expand all</a>
                @endif
            </div>
        </div>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:pages:update', [$page->getId(), $localeId]) }}" method="POST" id="pageEditForm">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">
                    Details

                    @foreach ($page->getLocalisations() as $l)

                        @if ($l->getId() == $localisation->getId())
                            <a href="@if($localSlug = $l->getLocale()->getSlug()) {{ '/'.$localSlug.$defaultFronEndPageUrl }} @else {{ $defaultFronEndPageUrl }} @endif" class="view-page btn btn-primary-outline btn-sm" target="_blank">View page</a>
                        @endif

                    @endforeach

                </div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" id="name" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'name') }}" name="name" value="{{ old('name', $page->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="slug" class="required">URL Slug</label>
                        <input type="text" id="slug" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'slug') }}" name="slug" value="{{ old('slug', $page->slug) }}">
                    </div>
                    <div class="form-group">
                        <label>Published</label>
                        <div>
                            <label class="checkbox-inline">
                                <input type="radio" name="status" value="1" @if($page->status == '1') checked @endif> Yes
                            </label>
                            <label class="checkbox-inline">
                                <input type="radio" name="status" value="0" @if($page->status == '0') checked @endif> No
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            @if(\Escape\Argon\Locales\Eloquent\Locale::count() > 1)
                <ul class="nav nav-tabs">
                    @foreach ($page->getLocalisations() as $l)
                        <li class="nav-item">
                            <a class="nav-link @if ($l->getLocaleId() == $localeId) active @endif"
                               href="{{ route('cms:pages:edit_locale', [$page->getId(), $l->getLocaleId()])}}" title="@if($localSlug = $l->getLocale()->getSlug()) {{ '/'.$localSlug.$defaultFronEndPageUrl }} @else {{ $defaultFronEndPageUrl }} @endif">
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


            @if($revisionsTotal = $revisions->total())
                <div class="card accordion">

                    <div class="card-header accordion-header">Revisions ({{ $revisionsTotal }})</div>

                    <div class="card-block accordion-body">

                        <div class="alert alert-info" role="alert">
                            Current published revision ID: {{ $latest->id }}, created at {{ $latest->created_at->format('d/m/Y H:i:s') }}, by user: {{ @$latest->userWithTrashed->name }}.
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
                                        <a href="{{ route('cms:revisions:restore', [$revision->id]) }}" class="btn btn-primary confirm" data-confirm="This will overwrite current page content.\nSelected revision is from {{ $revision->created_at->format('d/m/Y H:i:s') }}.\nAre you sure you want to continue?">Restore Revision</a>
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

                </div>
            @endif


            <div class="card accordion">

                <div class="card-header accordion-header">301 Redirect</div>

                <div class="card-block accordion-body">

                    @if($page->getLocalisations()->count() > 1)
                        <div class="form-group">

                            <label for="locale-redirect">Choose a locale redirect</label>
                            <select id="locale-redirect" class="form-control inline field-poputale" data-target="#redirect-url">
                                <option value="">Please select:</option>

                                @foreach ($page->getLocalisations() as $l)
                                    @if ($l->getId() != $localisation->getId())
                                        <option value="@if($localSlug = $l->getLocale()->getSlug()){{'/'.$localSlug.$defaultFronEndPageUrl}}@else{{$defaultFronEndPageUrl}}@endif">@if($localSlug = $l->getLocale()->getSlug()) {{ '/'.$localSlug.$defaultFronEndPageUrl }} @else {{ $defaultFronEndPageUrl }} @endif</option>
                                    @endif
                                @endforeach

                            </select>

                        </div>
                    @endif
                    <div class="form-group">
                        <label for="redirect-url" class="required">@if($page->getLocalisations()->count() > 1) Or enter @else Enter @endif redirect URL</label>
                        <input type="text" id="redirect-url" class="form-control" name="redirect_url" value="{{ old('redirect_url', $fronEndPage->getRedirect($localisation->getLocale()->getId())) }}">
                    </div>

                </div>

            </div>

            @if(!$page->getGroups($localisation->getLocaleId())->isEmpty())

                @foreach($page->getNonSortableGroups($localisation->getLocaleId()) as $group)
                    <div class="card accordion">

                        <div class="card-header accordion-header">

                            @include('argon::pages.partials.group-thumb')

                            {{ $group->name }}

                            @if($group->isRenderable())
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" name="group_render[{{$group->id}}]" value="0">
                                        <input type="checkbox" name="group_render[{{$group->id}}]" value="1" @if($page->isGroupRender($localisation->getLocaleId(), $group->id)) checked @endif>
                                        Render?
                                    </label>
                                </div>
                            @endif
                        </div>

                        <div class="card-block accordion-body">

                            @foreach ($group->getFields() as $field)

                                <div class="form-group sortable">

                                    <?php
                                    $fieldValue = $latest->getField($field->getId());
                                    $event = event(new Escape\Argon\Events\RenderField($field, $fieldValue, $group, $page, $localisation)); ?>

                                    @if(isset($event[0]->fieldHtml))

                                        <div class="field-html">

                                            {!! $event[0]->fieldHtml !!}

                                        </div>

                                    @endif

                                    {!! $field->render($fieldValue) !!}

                                </div>

                            @endforeach

                        </div>

                    </div>
                @endforeach

                @if(!$page->getSortableGroups($localisation->getLocaleId())->isEmpty())
                    <input id="order-{{ $page->getId() }}-{{ $localisation->getLocaleId() }}" type="hidden" name="group_order" value="{{ old('group_order', implode(',',$page->getGroupOrder($localisation->getLocaleId())) ) }}">
                    <div class="sortable sortable-groups" data-sortable_field="order-{{ $page->getId() }}-{{ $localisation->getLocaleId() }}">

                        @foreach($page->getSortableGroups($localisation->getLocaleId()) as $group)

                            <div class="input-group sortable-item" data-sortable_item="{{$group->id}}">

                                <div class="card accordion">

                                    <div class="card-header accordion-header">


                                        <span class="sortable-handle">&#8645;</span>

                                        @include('argon::pages.partials.group-thumb')

                                        {{ $group->name }}

                                        @if($group->isRenderable())
                                            <div class="checkbox">
                                                <label>
                                                    <input type="hidden" name="group_render[{{$group->id}}]" value="0">
                                                    <input type="checkbox" name="group_render[{{$group->id}}]" value="1" @if($page->isGroupRender($localisation->getLocaleId(), $group->id)) checked @endif>
                                                    Render?
                                                </label>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="card-block accordion-body">

                                        @foreach ($group->getFields() as $field)

                                            <div class="form-group sortable">

                                                <?php
                                                $fieldValue = $latest->getField($field->getId());
                                                $event = event(new Escape\Argon\Events\RenderField($field, $fieldValue, $group, $page, $localisation)); ?>

                                                @if(isset($event[0]->fieldHtml))

                                                    <div class="field-html">

                                                        {!! $event[0]->fieldHtml !!}

                                                    </div>

                                                @endif

                                                {!! $field->render($latest->getField($field->getId())) !!}

                                            </div>

                                        @endforeach

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>
                @endif

            @endif

            <button type="submit" class="btn btn-primary save-publish">Save and Publish</button>
            <button type="submit" class="btn btn-primary-outline save-revision" data-form-action="{{ route('cms:revisions:create', [$page->getId(), $localeId]) }}">Save Revision</button>
            <a href="#" class="btn btn-warning preview-page" data-preview-id="{{ $latest->id }}">Preview</a>

            <a href="{{ route('cms:pages:manage') }}" class="btn btn-link">Back to pages</a>

        </form>
    </div>

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
