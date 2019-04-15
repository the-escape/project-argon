@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')
    <script>
        window.fieldGroups = {}
        window.groups = []
    </script>

    <form action="{{ route('cms:blocks:save', [$type->id]) }}" class="o-form js-prevent-leave" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        @include('argon::inc.alerts', compact($errors))

        <div class="js-tabs c-page">
            <header class="c-header c-container">
                <div class="c-header__title">
                    <h1>Create {{ $type->name }}</h1>
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
                <div class="c-tab-panel active" data-tab="attributes">
                    <main class="c-tab-panel__container c-container">
                        <div class="c-actions__container">
                            <div class="c-actions__content c-tab-panel__inner-container l-full">
                                <h2>Attributes</h2>
                                <div class="o-form__group {{ hasError($errors, 'name') ? 'has-error' : '' }}">
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

                                @if(($propertyGroups = $groups->filter(function($el) { return $el->getSetting('isAttribute') || $el->getSetting('isProperty'); } )) && !$propertyGroups->isEmpty())
                                    @foreach($propertyGroups as $group)

                                        <hr>

                                        <div>
                                            <script>
                                                window.fieldGroups['{{$group->id}}'] = {
                                                    fields: {!! json_encode($group->getFieldsWithValues(),JSON_PRETTY_PRINT) !!},
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
                                    <a href="{{ route('cms:blocks:manage') }}" class="o-btn ">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
                <div class="c-tab-panel" data-tab="page-content">
                    <main class="c-tab-panel__container c-container">
                        <div class="c-actions__container">
                            <div class="c-actions__content">
                                <div class="js-page-edit"></div>
                            </div>

                            <div class="c-actions">
                                <div class="c-actions__group">
                                    <button type="submit" class="o-btn o-btn--primary">Save</button>
                                    <a href="{{ route('cms:blocks:manage') }}" class="o-btn ">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>

                @if(!$groups->isEmpty())
                    @foreach($groups->filter(function($el) {
                            return !$el->getSetting('isAttribute') && !$el->getSetting('isProperty');
                        }) as $group)
                        <div class="c-tab-panel" data-tab="group-{{ $group->id }}">
                            <main class="c-tab-panel__container c-container">
                                <script>
                                    window.groups.push({
                                        id: '{{$group->id}}',
                                        isRenderable: {{ $group->isRenderable() ? 1 : 0 }},
                                        isRendering: false,
                                        isSortable: {{ $group->isSortable() ? 1 : 0 }},
                                        name: '{{ $group->name }}',
                                        isTab: {{ $group->getSetting('isTab') ? 1 : 0 }},
                                        image: '{{ $group->getSetting("image") }}'
                                    });
                                    window.fieldGroups['{{$group->id}}'] = {
                                        fields: {!! json_encode($group->getFieldsWithValues(),JSON_PRETTY_PRINT) !!},
                                        header: "{!! $group->name !!}"
                                    }
                                </script>
                                <div class="js-fields" data-name="{{$group->id}}"></div>
                            </main>
                        </div>
                    @endforeach
                @endif
            </div>
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

    @include('argon::pages.partials.medialib') --}}

    {{-- <div style="display: none;" id="preview-template">
        <div class="media-item">
            <img class="thumb" data-dz-thumbnail>
            <span class="filename" data-dz-name></span>
            <span class="filesize" data-dz-size></span>

            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            <progress class="progress" value="25" max="100"></progress>
        </div>
    </div> --}}
@stop


