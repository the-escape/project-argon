@extends('argon::layout.master')

@section('content')
    <div class="main">

        <div class="row">
            <div class="col-md-9">
                <h1>Create Content</h1>
            </div>
            <div class="col-md-3">
                @if(!$groups->isEmpty())
                    <a href="#" class="accordion-expand-collapse pull-md-right" data-expand="Expand All" data-collapse="Collapse All">Expand all</a>
                @endif
            </div>
        </div>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:blocks:save', [$type->id]) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" id="name" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'name') }}" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="slug" class="required">URL Slug</label>
                        <input type="text" id="slug" class="form-control required slug {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'slug') }}" name="slug" value="{{ old('slug') }}">
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
                                {{ $group->name }}
                            </div>

                            <div class="card-block accordion-body">

                                @foreach ($group->getFields() as $field)

                                    <div class="form-group sortable">

                                        {!! $field->render() !!}

                                    </div>

                                @endforeach

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
                                            {{ $group->name }}
                                        </div>

                                        <div class="card-block accordion-body">

                                            @foreach ($group->getFields() as $field)

                                                <div class="form-group sortable">

                                                    {!! $field->render() !!}

                                                </div>

                                            @endforeach

                                        </div>

                                    </div>

                                </div>

                            @endif

                        @endforeach

                    </div>

                @endif


            @endif

            <button type="submit" class="btn btn-primary">Save</button>

            <a href="{{ route('cms:blocks:manage') }}" class="btn btn-link">Back to blocks</a>

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


