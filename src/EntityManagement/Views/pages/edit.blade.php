
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
                <div class="c-header__title c-header__title--deep">
                    <div class="c-header__local-container">
                        <h1>{{ $page->name }}<small>{{ $localisedFrontEndPageUrlNoHttp }}</small></h1>
                    </div>

                    <div class="c-header__btns">
                        <a href="{{ url($localisedFrontEndPageUrl) }}" class="o-link" target="_blank">Go to live page</a>
                    </div>
                </div>
                <div class="c-header__nav c-tab__nav js-tabs-nav">
                    <ul>
                        @foreach($tabNav as $tab)
                        <li>
                            <a class="c-tab__btn @if($tab['isActive']) active @endif" data-tab="{{ $tab['slug'] }}">
                                <div class="c-tab__btn-container">
                                    <span>{{ $tab['name'] }}</span>
                                    @if($tab['slug'] === 'revisions' && $currentRevision->id != $publishedRevision->id)
                                        <svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg>
                                    @endif
                                </div>
                            </a>
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
                                    <a href="{{ url($localisedFrontEndPageUrl) }}?preview_page={{ $currentRevision->id }}" class="o-btn" target="_blank">Preview</a>
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

                                @if(!$groups->isEmpty() && ($propertyGroups = $groups->filter(function($el) { return $el->getSetting('isAttribute') || $el->getSetting('isProperty'); } )) && !$propertyGroups->isEmpty())
                                    @foreach($propertyGroups as $group)

                                        <hr>

                                        <div>
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
                                    <a href="{{ url($localisedFrontEndPageUrl) }}?preview_page={{ $currentRevision->id }}" class="o-btn preview-page1" target="_blank">Preview</a>
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
                                        <div class="l-space">
                                            <p><span class="o-icon o-icon--danger"><svg><use xlink:href="/argon/images/svgicons.svg#alert"></use></svg></span> You're editing a {{ $currentRevision->status == 1 ? 'draft' : 'revision' }} created by {{ $currentRevision->user->name }} {{ $currentRevision->created_at->diffForHumans() }}. If you want to edit the published version of the page, please click <a href="{{ route('cms:pages:edit_locale', [$page->getId(), $localeId, $publishedRevision->id]) }}" class="confirm" data-confirm="This will discard any unsaved changes and take you back to published revision.\nYou can save changes as another revision without affecting live page by clickin 'Save Revision' button.\nAre you sure you want to continue?">here</a>.</p>
                                        </div>
                                    @endif


                                    <div class="o-table o-table--max-content--6 l-full">
                                        <div class="o-table__header o-table--center">ID</div>
                                        <div class="o-table__header">Status</div>
                                        <div class="o-table__header">Created At</div>
                                        <div class="o-table__header o-table--center">Created By</div>
                                        <div class="o-table__header o-table--end">Actions</div>
                                        <div class="o-table__header o-table--center"></div>

                                        @foreach ($revisions as $revision)
                                            <?php
                                                $rowClass = $currentRevision->id === $revision->id ? ' o-table__data--grey-white ' : '' ;
                                                $rowClass .= $publishedRevision->id === $revision->id ? ' o-table__data--green ' : '' ;
                                            ?>
                                            <div class="o-table__data {{ $rowClass }} o-table--center">

                                                {{ $revision->id }}
                                            </div>
                                            <div class="o-table__data {{ $rowClass }}">
                                                @if($revision->status != 5)
                                                    @if($currentRevision->id === $revision->id)
                                                        <strong>Editing -&nbsp;</strong>
                                                    @endif
                                                    {{ $revision->getStatusName() }}
                                                @elseif($currentRevision->id === $revision->id)
                                                    <strong>Editing</strong>
                                                @endif
                                            </div>
                                            <div class="o-table__data {{ $rowClass }}">
                                                {{ $revision->created_at->format('d/m/Y H:i:s') }}
                                            </div>
                                            <div class="o-table__data {{ $rowClass }} o-table--center">
                                                {{ $revision->user->name }}
                                            </div>
                                            <div class="o-table__data {{ $rowClass }} o-table--end">
                                                <div class="o-confirm-btn__container">
                                                    <div class="o-confirm-btn__questions">
                                                        @if($currentRevision->id != $revision->id)
                                                            <a href="{{ route('cms:pages:edit_locale', [$page->getId(), $localeId, $revision->id]) }}" class="o-confirm-btn confirm" data-balloon="Load/edit revision" data-confirm="This will load and allow editing the selected revision from {{ $revision->created_at->format('d/m/Y H:i:s') }} saved by user: {{ @$revision->userWithTrashed->name }} without affecting published page unless 'Save and Publish' button clicked.\nYou can load and edit and click 'Save Revision' to capture as new snapshot for further checks and review without impact on live - published page.\nAre you sure you want to continue?">
                                                                <svg><use xlink:href="/argon/images/svgicons.svg#edit"></use></svg>
                                                            </a>
                                                        @else
                                                            <button class="o-confirm-btn o-confirm-btn--fade" disabled>
                                                                <svg><use xlink:href="/argon/images/svgicons.svg#edit"></use></svg>
                                                            </button>
                                                        @endif

                                                        <a href="{{ url($localisedFrontEndPageUrl) }}?preview_page={{ $revision->id }}" class="o-confirm-btn" data-balloon="Preview revision" target="_blank">
                                                            <svg><use xlink:href="/argon/images/svgicons.svg#see"></use></svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="o-table__data  {{ $rowClass }} o-table--center">
                                                @if($publishedRevision->id != $revision->id)
                                                    <a href="{{ route('cms:revisions:restore', [$revision->id]) }}" class="o-btn o-btn--primary o-btn--xs confirm" data-confirm="This will overwrite current page content.\nSelected revision is from {{ $revision->created_at->format('d/m/Y H:i:s') }}.\nAre you sure you want to continue?">Publish</a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    @if($revisions->lastPage() > 1)
                                        <div class="l-full">
                                            @include('argon::inc.listing.pagination', ['items' => $revisions])
                                        </div>
                                    @endif

                                </div>

                                {{-- <div class="c-actions">
                                    <div class="c-actions__group">
                                        <button type="submit" class="o-btn o-btn--primary js-tab-btn" data-tab="page-content">Back</button>
                                    </div>
                                </div> --}}
                            </div>
                        </main>
                    </div>
                @endif

                @if(!$groups->isEmpty())
                    @foreach($groups as $group)

                        @if(!$group->getSetting('isProperty') && !$group->getSetting('isAttribute'))

                            <div class="c-tab-panel" data-tab="group-{{ $group->id }}">
                                <main class="c-tab-panel__container c-container">
                                    <script>
                                        window.groups.push({
                                            id: '{{$group->id}}',
                                            isRenderable: {{ $group->isRenderable() ? 1 : 0 }},
                                            isRendering: {{ $currentRevision->isGroupRender($group->id) ? '1' : '0' }},
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
                                    <div class="js-fields" data-name="{{$group->id}}">
                                        <input type="hidden" name="group_render[{{$group->id}}]" value="{{ $page->isGroupRender($localisation->getLocaleId(), $group->id) ? '1' : '0' }}">
                                        <?php
                                            $fields = $group->getFields();
                                            foreach($fields as $field){
                                                $fieldValue = $currentRevision->getField($field->getId());
                                                echo $field->renderHidden($fieldValue);
                                            }
                                        ?>
                                    </div>
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

    @if($currentRevision->status == \Escape\Argon\EntityManagement\RevisionStatus::DRAFT)
        <script>
            window.modals = window.modals || [];

            window.modals.push({
                id: 'dyn-test',
                content: `
                <h1>You're editing a draft</h1>
                <p>Created by {{ $currentRevision->user->name }} {{ $currentRevision->created_at->diffForHumans() }}. If you want to edit the published version of the page, please click the button below, otherwise click continue.</p>
                <p>
                    <a href="{{ route('cms:pages:edit_locale', [$page->getId(), $localeId, $publishedRevision->id]) }}" class="o-btn o-btn--danger">Go to Published</a>
                    <button class="o-btn o-btn--white js-modal-close">Continue</button>
                </p>
                `,
                open: true
            })
        </script>
    @endif
@stop
