@extends('argon::layout.master')

@section('content')

    <div class="main">
        <h1>Menu</h1>

        <form action="{{ route('cms:menus:create') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">

                <div class="card-header">Menu details</div>

                <div class="card-block">

                    <div class="form-group">
                        <label for="name" class="required">Name</label>
                        <input type="text" class="form-control required" id="name" name="name" placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label for="slug" class="required">Slug</label>
                        <input type="text" class="form-control required " id="slug" name="slug" placeholder="slug">
                    </div>

                </div>

            </div>

            <div id="navtree"></div>


            <div class="card" id="navtree-form">

                <div class="card-header" id="navtree-header">Edit item</div>

                <div class="card-block">

                    <div class="form-group">
                        <label for="item_label" class="required">Label</label>
                        <input type="text" class="form-control required" id="item_label" name="item_label" placeholder="Label">
                    </div>

                    <div class="form-group">
                        <label for="item_url" class="required">URL</label>
                        <input type="text" class="form-control required " id="item_url" name="item_url" placeholder="URL">
                    </div>

                    <div>
                        <button id="navtree-update" class="btn btn-primary-outline btn-sm">Update item</button>
                        <button id="navtree-deselect" class="btn btn-primary-outline btn-sm">Deselect</button>
                    </div>

                </div>

            </div>

            <div>
                <button id="navtree-add" class="btn btn-primary-outline btn-sm">Add new item</button>
                <button id="navtree-save" class="btn btn-primary-outline btn-sm">Save all</button>
            </div>


            <textarea id="navtree-output" class="form-control"></textarea>

            <button type="submit" class="btn btn-primary">Save</button>

        </form>

    </div>
@stop

@section('styles')
    <style>

        #navtree {
            margin: 20px 0;
            border-top: 1px dotted #000;
        }

        #navtree-form {
            display: none;
        }

        #navtree-output {
            display: none;
            font-family: monospace;
            margin: 20px 0;
        }

    </style>
@stop

@section('footer')
    <script src="/argon/js/jstree.min.js"></script>

    <script>

        var navtreeData = [
//            { "id" : "ajson1", "parent" : "#", "text" : "Simple root node", "li_attr" : {"item_url":"URL 1" }},
//            { "id" : "ajson2", "parent" : "#", "text" : "Root node 2", state: {"opened": true/*, 'selected' : true*/}, "li_attr" : {"item_url":"URL 2" } },
//            { "id" : "ajson3", "parent" : "ajson2", "text" : "Child 1", "li_attr" : {"item_url":"URL 3" } },
//            { "id" : "ajson4", "parent" : "ajson2", "text" : "Child 2", "li_attr" : {"item_url":"URL 4" } }
        ];


        var $navtree =  $('#navtree'),
            $navtreeAdd = $("#navtree-add"),
            $navtreeForm = $("#navtree-form"),
            $navtreeUpdate = $("#navtree-update"),
            $navtreeDeselect = $("#navtree-deselect"),
            $navtreeSave = $("#navtree-save"),
            $navtreeOutput = $("#navtree-output");

        $navtree.jstree({
            "plugins" : ['dnd'],
            "core": {
                "check_callback": true,
                "multiple": false,
                "data": navtreeData
            }
        });

        var navtreeInstance = function(){
            return $navtree.jstree(true);
        };

        $navtree.on('click', '.jstree-clicked', function () {
            navtreeInstance().deselect_node(this);
        });

        $navtree.on('create_node.jstree', function(e, data) {
            navtreeInstance().select_node('#'+data.node.id);
        });

        $navtree.on('deselect_node.jstree', function(e, data) {
            navtreeForm.clear();
        });

        $navtree.on('changed.jstree', function (e, data) {
            var selected = data.selected;

            if (selected && selected.length) {
                var node = data.instance.get_node(data.selected[0]);
                var node_id   = (node.id);
                var $node = $("#"+node_id);
                var item_label = node.text;
                var item_url = $node.attr("item_url");

                navtreeForm.setLabel(item_label);
                navtreeForm.setUrl(item_url);

                $("#item_label").data('initial_value', item_label);

                navtreeForm.edit();
            }
        });

        $navtreeDeselect.on("click",function(e) {

            var selected = navtreeInstance().get_selected(true);

            if (selected && selected.length) {
                navtreeInstance().deselect_node(selected[0]);
            }

            unfocus();

        });

        $navtreeAdd.on("click",function(e) {

            e.preventDefault();

            var parentId = null;
            var selected = navtreeInstance().get_selected(true);

            if (selected && selected.length) {
                parentId = selected[0].id;
            }

            navtreeInstance().create_node(parentId ,  {"text" : "New element", "li_attr" : {"item_label" : "New element", "item_url":"#" } }, "last", function(){
                $navtree.jstree("deselect_all");
            });
        });

        $navtreeSave.on("click", function(e) {
            navtreeForm.save();
        });

        $navtreeUpdate.on("click", function(e){
            e.preventDefault();

            var selected = navtreeInstance().get_selected(true);

            if (selected && selected.length) {
                var node = selected[0];

                var item_label = navtreeForm.getLabel();
                var item_url = navtreeForm.getUrl();

                node.li_attr["item_url"] =  item_url;

                $navtree.jstree('rename_node', node , item_label );
            }
        });

        $navtreeUpdate.on("click blur", function(e){
            unfocus();
        });

        function unfocus() {
            if (!$navtreeUpdate.hasClass("btn-primary-outline")) {
                $navtreeUpdate.addClass("btn-primary-outline");
            }

            if ($navtreeUpdate.hasClass("btn-primary")) {
                $navtreeUpdate.removeClass("btn-primary");
            }
        }

        $("input[type='text']").on('keyup', function(e) {

            var initial_value = $(this).data("initial_value");

            if (this.value != initial_value) {

                if ($navtreeUpdate.hasClass("btn-primary-outline")) {
                    $navtreeUpdate.removeClass("btn-primary-outline");
                }

                if (!$navtreeUpdate.hasClass("btn-primary")) {
                    $navtreeUpdate.addClass("btn-primary");
                }

                return;
            }

            unfocus();
        });

        var navtreeForm = (function() {

            var $item_label = $("#item_label"),
                $item_url = $("#item_url");

            function SetLabel(value) {
                return $item_label.val(value);
            }

            function GetLabel() {
                return $item_label.val();
            }

            function SetUrl(value) {
                return $item_url.val(value);
            }

            function GetUrl() {
                return $item_url.val();
            }

            function Clear() {
                SetLabel('');
                SetUrl('');
            }

            function Edit() {
                $navtreeForm.show()
            }

            function saveData() {
                var data = navtreeInstance().get_json('#', {flat:false});
                var json = JSON.stringify(data);

//                var postdata = {
//                    "json": json
//                };
//
//                $.post("/admin/menus/create", postdata, function() {
//                    console.log("Request sent...");
//                }, "json")
//                .done(function(data) {
//                    console.log('Request response data:');
//                    console.log(data);
//                })
//                .fail(function() {
//                    console.log('Request failed.');
//                })
//                .always(function() {
//                    console.log("Request finished.");
//                });
//
//                return json;
            }

            function Save() {
                var json_output = saveData();
                $navtreeOutput.text(json_output).show();
            }

            return {
                setLabel: SetLabel,
                getLabel: GetLabel,
                setUrl: SetUrl,
                getUrl: GetUrl,
                clear: Clear,
                edit: Edit,
                save: Save
            };
        })();







    </script>

@stop
