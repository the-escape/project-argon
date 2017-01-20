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
        var $deleteBtn = $('#delete-button');

        $addBtn.on('click', function (e) {
            var url = this.getAttribute('data-url');
            if (url && url.length) {
                document.location.href = url;
            }
        });

        $deleteBtn.on('click', function (e) {
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

                var id = data.node.li_attr['data-id'];
                var root = argon.root();

                if (isFolder(data))
                {
                    $addBtn.prop('disabled', false);
                    $addBtn.attr('data-url', root + '/media/folders/' + id + '/add');
                    $editBtn.attr('href', root + '/media/folders/' + id);
                    $deleteBtn.prop('disabled', false);
                    var dataUrl = $deleteBtn.data('folder-delete').replace('%%ID%%', id);
//                    $deleteBtn.attr('data-url', root + '/media/folders/' + id +'/remove');
                    $deleteBtn.attr('data-url', dataUrl);
                }
                else
                {
                    $addBtn.prop('disabled', true);
                    $editBtn.attr('href', root + '/media/edit/' + id);
                    $deleteBtn.prop('disabled', false);
                    var dataUrl = $deleteBtn.data('item-delete').replace('%%ID%%', id);
//                    $deleteBtn.attr('data-url', root + '/media/delete/' + id);
                    $deleteBtn.attr('data-url', dataUrl);
                }
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