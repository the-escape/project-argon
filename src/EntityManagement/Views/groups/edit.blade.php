@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Edit Group</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:types:groups:update', [$type->id, $group->id]) }}" method="POST" autocomplete="false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" class="form-control required {{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'name') }}" id="name" name="name" placeholder="Name" value="{{ old('name', $group->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="sortable">
                            <input type="hidden" value="0" name="sortable">
                            <input type="checkbox" class="{{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'sortable') }}" @if($group->sortable) checked @endif id="sortable" name="sortable" value="1">
                            Sortable
                        </label>
                    </div>

                    @if($type->isPage())
                        <div class="form-group">
                            <label for="renderable">
                                <input type="hidden" value="0" name="renderable">
                                <input type="checkbox" class="{{ Escape\Argon\EntityManagement\Helpers\Validation::getErrorClass(@$errors, 'renderable') }}" @if($group->renderable) checked @endif id="renderable" name="renderable" value="1">
                                Renderable
                            </label>
                        </div>
                    @endif

                    @if($type->isPage())
                    <div class="form-group">
                        <div class="col-xs-9">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div id="boxshadow">
                                        <a href="" data-toggle="modal" data-target="#medialibrary">
                                            @if($group->thumbnail==0)
                                                <img class="thumbnail-image" title="Click to add thumbnail"
                                                     src="{{config('argon.group-no-image', '/argon/images/no-image.png')}}">
                                                <input type="hidden" id="thumbUrl" value="">
                                            @else
                                                <img class="thumbnail-image" title="Click to change thumbnail"
                                                     src="{{ $thumbnail->getThumbnail() }}">
                                                <input type="hidden" id="thumbUrl" value="{{ $thumbnail->getThumbnail() }}">
                                            @endif
                                            <input type="hidden" id="thumbnail" name="thumbnail" value="0">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:groups', [$type->id])}}">Back to manage groups</a>
            <a class="btn btn-link" href="{{route('cms:types:edit', [$type->id])}}">Back to edit type</a>
            <a class="btn btn-link" href="{{route('cms:types:manage')}}">Back to types</a>
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
                        <button type="button" class="btn btn-primary btn-submit" disabled onclick="renderThumbnail()" >Select</button>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: none;" id="preview-template">
            <div class="media-item">
                <img class="thumb" data-dz-thumbnail onclick="getUrl(this.src)">
                <span class="filename" data-dz-name></span>
                <span class="filesize" data-dz-size></span>

                <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                <progress class="progress" value="25" max="100"></progress>
            </div>
        </div>
        @endsection

        <script>

            function getUrl($imageUrl) {
                $('#thumbUrl').val($imageUrl);
            }

            function renderThumbnail() {
                var selectedId = $('#selectedMediaItem').val();
                if (selectedId != 0) {
                    $('.thumbnail-image').attr('src', $('#thumbUrl').val());
                    $('#thumbnail').val(selectedId);
                }
            }
        </script>

        <style>
            #boxshadow img {
                width:100px;
                height:100px;
                border: 1px solid #8a4419;
                border-style: inset;
            }
        </style>