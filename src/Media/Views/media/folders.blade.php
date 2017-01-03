@extends('argon::layout.master')

@section('body-class', 'dashboard media media-all')

@section('content')

    <div class="main">
        <h1 class="page-header">Media Folders</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="actions-top">

            <a href="" id="edit-button" class="btn btn-primary-outline">Edit</a>
            <button id="add-button" disabled class="btn btn-primary-outline">Add Subfolder</button>
            <form id="delete-form" style="display: inline" method="POST" action="" class="confirm">
                {{csrf_field()}}
                {{method_field('DELETE')}}
                <button type="submit" class="btn btn-danger" disabled>Delete</button>
            </form>

            <div class="pull-xs-right">
                <a href="{{ route("cms:media:upload:get") }}" class="btn btn-primary btn-upload">Upload</a>
                <a href="{{ route("cms:media:all") }}" class="btn btn-primary-outline">Back to All</a>
            </div>

        </div>


        <div id="folders">
            <ul>
                @each('argon::media.folder-single', [$root], 'folder')
            </ul>
        </div>

    </div>

@stop

@section('styles')

    <style>

        .data-info {
            color: #777;
            padding: 0 0 0 10px;
        }

    </style>
@stop

@section('footer')
    <script src="/argon/js/jstree.min.js"></script>
    <script>
        function isFolder(data) {
            return (data.node.li_attr.class && data.node.li_attr.class.indexOf('folder') !== -1);
        }

        var $editBtn = $('#edit-button');
        var $addBtn = $('#add-button');

        $addBtn.on('click', function (e) {
            var url = this.getAttribute('data-url');
            if (url && url.length) {
                document.location.href = url;
            }
        });

        $('#folders').jstree({
            plugins: [
                'dnd',
                'search'
            ],
            "core" : {
                // so that create works
                "check_callback" : true,
                "multiple": false
            }
        }).jstree('open_node', ['#folder-1']);

        // 7 bind to events triggered on the tree
        $('#folders').on("changed.jstree", function (e, data) {
            if (data.selected) {

                if (isFolder(data)) {
                    $addBtn.prop('disabled', false);
                    $addBtn.attr('data-url', '/admin/media/folders/' + data.node.li_attr['data-id'] + '/add');
                    $editBtn.attr('href', '/admin/media/folders/' + data.node.li_attr['data-id']);
                } else {
                    $addBtn.prop('disabled', true);
                    $editBtn.attr('href', '/admin/media/edit/' + data.node.li_attr['data-id']);
                }

//                var id = argon.helpers.getIdFromNodeIdString(data.selected[0]);
//
//                $('#edit-button')
//                        .prop('disabled', false)
//                        .attr('href', 'pages/' + id + '/edit');
//                $('#delete-form')
//                        .attr('action', argon.root() + '/pages/' + id);
//                $('#delete-form button')
//                        .prop('disabled', false)
////                $('#create-button').attr('href', 'content/' + id + '/addchild');
//                $('.add-child-dropdown a').each(function (index, element) {
//                    var type = $(element).attr('data-type');
//                    $(element).attr('href', 'pages/' + id + '/addchild/' + type);
//                });

            }
        });

        $('#folders').on("move_node.jstree", function (e, data, foo) {
            //var nodeId = data.node.li_attr['data-id'];
            var nodeId = data.node.data.id;
            var parentId = argon.helpers.getIdFromNodeIdString(data.parent);
            var url;

            if (isFolder(data)) {
                url = "/admin/media/"+nodeId+"/folderParentUpdate/"+parentId;
            } else {
                url = "/admin/media/"+nodeId+"/itemParentUpdate/"+parentId;
            }

            // TODO: use URL below and SPLIT! for the backend (perhaps split into 2 methods?)

            $.post(url, function() {
                // if(window.console) console.log('Posted...');
            }, 'json')
            .done(function(data) {
                // TODO: implement visual feedback
                 if(window.console) console.log(data);
            });

        });

//        $('#folders').on("dblclick.jstree", function (e) {
//            var node = $(e.target).closest("li");
//            var id = argon.helpers.getIdFromNodeIdString(node[0].id);
//            location.href = 'pages/' + id + '/edit';
//        });

        $('#folders').on({
            mouseenter: function () {
                var $this = $(this);
                var $dataInfo = $this.find('.data-info');
                if (!$dataInfo.length) {
                    var dataInfo = $this.data('info');
                    if (dataInfo && dataInfo.length) {
                        var $anchor = $this.find('.jstree-anchor');
                        var txt = $anchor.html();
                        $anchor.html(txt + '<span class="data-info">' +dataInfo+ '</span>');
                    }
                }

            },
            mouseleave: function () {
                var $this = $(this);
                var $dataInfo = $this.find('.data-info');
                if ($dataInfo && $dataInfo.length) {
                    $dataInfo.remove();
                }
            }
        }, '.mediaitem');

        $('#folders').on('click', '.data-info' , function (e) {
            alert($(this).parents('.mediaitem').data('id'));
        });

    </script>
@stop
