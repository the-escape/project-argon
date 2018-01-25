@extends('argon::layout.master')

@section('content')


    <div class="main">
        <h1>Navigation</h1>

        <div id="navtree"></div>


        <div class="card" id="navtree-edit">

            <div class="card-header">Edit item</div>

            <div class="card-block">

                <div class="form-group">
                    <label for="item_label" class="required">Label</label>
                    <input type="text" class="form-control required" id="item_label" name="item_label" placeholder="Label">
                </div>

                <div class="form-group">
                    <label for="item_url" class="required">URL</label>
                    <input type="text" class="form-control required " id="item_url" name="item_url" placeholder="URL">
                </div>

            </div>

        </div>

        <button id="navtree-add" class="btn btn-primary-outline btn-sm">Add new item</button>

    </div>
@stop

@section('styles')
    <style>

        #navtree {
            margin: 20px 0;
            border-top: 1px dotted #000;
        }

        #navtree-edit {
            display: none;
        }

    </style>
@stop

@section('footer')
    <script src="/argon/js/jstree.min.js"></script>

    <script>

        $('#navtree').jstree({
            "plugins" : ['dnd'],
            "core" : {
                "check_callback" : true,
                "multiple": false,
                "data" : [
                    { "id" : "ajson1", "parent" : "#", "text" : "Simple root node", "li_attr" : {"item_label" : "Simple root node", "item_url":"URL 1" }},
                    { "id" : "ajson2", "parent" : "#", "text" : "Root node 2", state: {"opened": true/*, 'selected' : true*/}, "li_attr" : {"item_label" : "Root node 2", "item_url":"URL 2" } },
                    { "id" : "ajson3", "parent" : "ajson2", "text" : "Child 1", "li_attr" : {"item_label" : "Child 1", "item_url":"URL 3" } },
                    { "id" : "ajson4", "parent" : "ajson2", "text" : "Child 2", "li_attr" : {"item_label" : "Child 2", "item_url":"URL 4" } }
                ]
            }
        }).on('create_node.jstree', function(e, data) {
            console.log('on.create_node.jstree');
        });

        $('#navtree').on("select_node.jstree", function (e, data)
        {
            var node_id   = (data.node.id);
            var $node = $("#"+node_id);
            var item_label = $node.attr("item_label");
            var item_url = $node.attr("item_url");

            var $navtreeEdit = $("#navtree-edit");
            $navtreeEdit.find("#item_label").val(item_label);
            $navtreeEdit.find("#item_url").val(item_url);
            $navtreeEdit.show();
        });


        $("#navtree-add").on("click",function() {
            var id = "test123";
            $('#navtree').jstree().create_node('#' ,  {"id":id, "text" : "New element", "li_attr" : {"item_label" : "New element", "item_url":"#" } }, "last", function(){
                if(window.console) console.log("fire: create_node");
                $('#navtree').jstree("select_node","#" + id);
            });
        });

    </script>

@stop
