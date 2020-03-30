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

        <form action="{{ route('cms:content:saveroot', $type->id) }}" method="POST">
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
                    <div class="form-group">
                        <label>Published</label>
                        <div>
                            <label class="checkbox-inline">
                                <input type="radio" name="status" value="1"> Yes
                            </label>
                            <label class="checkbox-inline">
                                <input type="radio" name="status" value="0" checked> No
                            </label>
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

            @if($type->getSetting("pointer"))

                <div class="card accordion">

                    <div class="card-header accordion-header">
                        Pointer / Page reference

                        <span class="pointer">
                            <span class="pointer--on">On</span> | <span class="pointer--off pointer--active">Off</span>
                        </span>

                    </div>

                    <div class="card-block accordion-body">

                        <div class="alert alert-info">
                            <p><strong>Heads up!</strong> Selecting a page from the site tree below will instruct to use it's content instead of content stored here.</p>
                        </div>

                        <div id="sitetree">
                            <ul>
                                @each('argon::pages.tree.item', $tree, 'entity')
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="entity_pointer_label" class="required">Select poiter from the site tree.</label>
                            <input type="text" id="entity_pointer_label" class="form-control" name="entity_pointer_label" value="{{ old('entity_pointer_label') }}" disabled>
                            <input type="hidden" id="entity_pointer" class="form-control" name="entity_pointer" value="{{ old('entity_pointer') }}">

                        </div>
                        <button id="entity_pointer_clear" class="btn btn-primary-outline btn-sm">Clear selection</button>
                    </div>

                </div>

            @endif

            @if(!$groups->isEmpty())

                <?php $sortable = []; ?>

                @foreach($groups as $group)

                    @if($group->isSortable())

                        <?php $sortable[] = $group; ?>

                    @else

                        <div class="card accordion">

                            <div class="card-header accordion-header">
                                {{ $group->name }}

                                @if($group->isRenderable())
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" name="group_render[{{$group->id}}]" value="0">
                                            <input type="checkbox" name="group_render[{{$group->id}}]" value="1">
                                            Render?
                                        </label>
                                    </div>
                                @endif
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

                                            @if($group->isRenderable())
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="hidden" name="group_render[{{$group->id}}]" value="0">
                                                        <input type="checkbox" name="group_render[{{$group->id}}]" value="1">
                                                        Render?
                                                    </label>
                                                </div>
                                            @endif

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

            <button type="submit" class="btn btn-primary" onclick="this.disabled=true; this.textContent='Submitting ...'; this.form.submit();">Save</button>

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
@stop


@section('footer')
    <script src="/argon/js/jstree.min.js"></script>
    <script>

        (function() {

            var $sitetree = $("#sitetree");
            var $entity_pointer_label = $('#entity_pointer_label');
            var $entity_pointer = $('#entity_pointer');
            var $entity_pointer_clear = $("#entity_pointer_clear");

            $sitetree.jstree({
                plugins: [
                    'dnd',
                    'search'
                ],
                "core" : {
                    // so that create works
                    "check_callback" : true,
                    "multiple": false
                }
            }).jstree({!! config('argon.jstree.load.open', 'open_all') !!});

            var sitetreeInstance = function(){
                return $sitetree.jstree(true);
            };

            function trim(value) {
                return value.replace(/^\s+|\s+$/g, '');
            }

            $sitetree.on("changed.jstree", function (e, data) {
                var selected = data.selected;

                if (selected && selected.length) {
                    if (data.node) {
                        var id = argon.helpers.getIdFromNodeIdString(data.selected[0]);
                        var name = argon.helpers.trim(data.node.text);
                        console.log("Sitetree selection (id => label): %d => %s", id, name);
                        $entity_pointer.val(id);
                        $entity_pointer_label.val(name);
                    }
                }
            });

            $entity_pointer_clear.on("click", function (e) {
                e.preventDefault();
                $entity_pointer.val('');
                $entity_pointer_label.val('');
                var selected = sitetreeInstance().get_selected(true);
                if (selected && selected.length) {
                    sitetreeInstance().deselect_node(selected[0]);
                }
            });

            @if($entity_pointer = old('entity_pointer'))
                sitetreeInstance().select_node("node-{{ $entity_pointer }}");
            @endif

        })();

    </script>
@stop
