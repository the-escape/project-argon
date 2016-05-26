@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Media</h1>

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <button type="button" class="btn btn-primary btn-upload">Upload</button>

        <div class="media-library" style="position: relative;">
            <div class="media-library-sidebar" style="position: absolute; width: 200px; left: 0; top: 0; bottom: 0; background: #ccc;">
                <div id="folders">
                    <ul>
                        @each('argon::media.folder', [$root], 'folder')
                    </ul>
                </div>
                <div class="buttons">
                    <button class="btn btn-sm" id="add-folder">+</button>
                    <button class="btn btn-sm" id="del-folder">-</button>
                </div>
            </div>
            <form class="dz" style="border: 1px dashed red; margin-left: 200px; min-height: 100px;">
                <input type="hidden" name="current-folder" id="current-folder" value="1">
                <div class="files">

                </div>
            </form>
        </div>
    </div>

    <div style="display: none;" id="preview-template">
        <div class="media-item">
            <img class="thumb" data-dz-thumbnail>
            <span class="filename" data-dz-name></span>
            <span class="filesize" data-dz-size></span>

            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            <progress class="progress" value="25" max="100"></progress>
            <div class="btn-group">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" data-dz-delete href="#">Delete</a>
                    {{--<a class="dropdown-item" data-dz-move href="#">Move</a>--}}
                    {{--<a class="dropdown-item" data-dz-edit href="#">Edit</a>--}}
                    <a class="dropdown-item" data-dz-original href="" target="_blank">View Original</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('styles')
    <link rel="stylesheet" href="/argon/js/jstree/style.min.css" />
@stop

@section('footer')
    <script src="/argon/js/dropzone.min.js"></script>
    <script>
        var dropzone = new Dropzone(
            'form.dz',
            {
                url: '/admin/media/upload',
                clickable: '.btn-upload',
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                thumbnailWidth: 100,
                thumbnailHeight: 100,
                previewTemplate: $('#preview-template').html(),
                previewsContainer: '.media-library .files',
            }
        );
        dropzone.on('success', function(e, response) {
            loadItems($('#current-folder').val());
        });

        dropzone.on('error', function(file, errorMessage, xhr) {
            console.log(errorMessage);
        });

        dropzone.on('uploadprogress', function(file, progress, bytesSent) {
            $('progress', file.previewElement).val(progress);

            if (progress == 100) {
                $('progress', file.previewElement).hide();
            }
        });

        dropzone.on('addedfile', function(file) {
//            console.log(file);
            sortItems();
        });
    </script>

    <script src="/argon/js/jstree.min.js"></script>
    <script>
        var folders = $('#folders');

        folders
            .children()
                .children()
                    .attr('data-jstree', '{"opened":true,"selected":true}');

        folders.jstree({
            plugins: [
                'dnd',
                'search'
            ],
            "core" : {
                // so that create works
                "check_callback" : true,
                "multiple": false
            }
        });

        folders.on("changed.jstree", function (e, data) {
            if (data.selected.length > 0) {
                var id = data.selected[0].split('-')[1];

                loadItems(id);
            }
        });

        $('#add-folder').click(function() {

            var currentFolder = $('#folders').jstree().get_selected(true)[0].data.id;

            var name = argon.dialog.prompt("Folder name:", function(name) {
                if (name) {
                    $.ajax({
                            url: "/admin/media/folders",
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            data: {
                                "name": name,
                                "parent": currentFolder
                            }
                        })
                    .done(function(data) {
                        var id = $("#folders").jstree(true).create_node(
                            $('[data-id=' + currentFolder + ']'),
                            {
                                text: ' ' + name,
                                id: 'folder-' + data.id,
                                data: {
                                    id: data.id
                                }
                            },
                            "last",
                            function() {},
                            true
                        );

                        $('#folder-' + data.id).attr('data-id', currentFolder);
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        switch (jqXHR.status) {
                            case 409:
                                argon.dialog.alert('Folder already exists.');
                                break;
                            default:
                                argon.dialog.alert('Unknown error');
                                break;
                        }
                    });
                }
            });
        });

        $('#del-folder').click(function() {
            var selected = $('#folders').jstree().get_selected(true)[0];
            var currentFolder = selected.data.id;

            $.ajax({
                url: "/admin/media/folders/" + currentFolder,
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .done(function(data) {
                var tree = $('#folders').jstree(true);
                tree.delete_node(selected);
                tree.select_node(selected.parents[0]);
            })
            .fail(function(jqXHR) {
                switch (jqXHR.status) {
                    case 409:
                        argon.dialog.alert('Folder is not empty.');
                        break;
                    default:
                        argon.dialog.alert('Unknown error');
                        break;
                }
            });
        });

        function loadItems(id) {
            $.ajax(
                '/admin/media/items',
                {
                    data: {
                        folderId: id
                    }
                }
            ).done(function(data) {
                $('#current-folder').val(id);

                $('.dz .files').empty();

                for (var i in data) {
                    var file = data[i];

                    var node = $('#preview-template .media-item').clone();

                    node.attr('data-id', file.id);
                    node.find('img').attr('src', file.thumbUrl);
                    node.find('[data-dz-name]').text(file.filename);
                    node.find('[data-dz-size]').html(argon.helpers.filesize(file.filesize));
                    node.find('[data-dz-delete]').on('click', function(id) {
                        return function() {
                            deleteItem(id);
                        }
                    }(file.id));
                    node.find('[data-dz-original]').attr('href', file.url);
                    node.find('progress').hide();

                    node.find('[data-dz-path]').attr('data-path', file.url);

                    $('form.dz .files').append(node);
                }

                sortItems();
            });
        }

        loadItems(1);

        function deleteItem(id) {
            if (confirm("Are you sure you want to delete this file?")) {
                $.ajax(
                    {
                        url: '/admin/media/items/' + id,
                        method: 'DELETE',
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    }
                ).done(function(data) {
                   $('[data-id='+ id + ']').remove();
                });
            } else {
//                console.log('keep');
            }
        }

        function sortItems() {
            var list = $('.files .media-item').get();
            list.sort(compareItems);
            for (var i = 0; i < list.length; i++) {
                list[i].parentNode.appendChild(list[i]);
            }
        }

        function compareItems(a, b) {
            var nameA = $(a).find('.filename').text(),
                nameB = $(b).find('.filename').text();
            return nameA.localeCompare(nameB);
        }

    </script>
@stop
