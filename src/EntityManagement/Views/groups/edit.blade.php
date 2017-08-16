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
                                            <a href="" data-toggle="modal" data-target="#medialib">
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







        <div id="medialib" class="modal fade" role="dialog" aria-labelledby="medialibraryLabel" aria-hidden="true">
            <input type="hidden" id="selectedMediaItem" value="">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="medialibraryLabel">Media Library</h4>
                    </div>
                    <div class="modal-body">

                        <div class="media-library" style="position: relative;">

                            <iframe id="medialib-iframe" frameborder="0"></iframe>

                        </div>
                    </div>
                </div>
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