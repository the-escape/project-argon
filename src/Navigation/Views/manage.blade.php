@extends('argon::layout.master')

@section('content')


    <div class="main">
        <h1>Navigation</h1>

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

        <div id="navtree-output" class="form-control">

        </div>

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

        });

        $navtreeAdd.on("click",function(e) {

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
//            var v = navtreeInstance().get_json('#', {flat:false});
//            var output = JSON.stringify(v);
//            $navtreeOutput.text(output).show();
        });

        $navtreeUpdate.on("click", function(e){
            var selected = navtreeInstance().get_selected(true);

            if (selected && selected.length) {
                var node = selected[0];

                var item_label = navtreeForm.getLabel();
                var item_url = navtreeForm.getUrl();

                node.li_attr["item_url"] =  item_url;

                $navtree.jstree('rename_node', node , item_label );
            }
        });


//        $( "input[type='text']" ).change(function() {
//           console.log("change event: " + this.value);
//        });

        $( "input[type='text']" ).on('keyup', function(e) {

            var initial_value = $(this).data("initial_value");

            if (this.value != initial_value) {
                $navtreeUpdate.removeClass("btn-primary-outline");
                $navtreeUpdate.addClass("btn-primary");
            } else {
                $navtreeUpdate.addClass("btn-primary-outline");
                $navtreeUpdate.removeClass("btn-primary");
            }


        });

//        $.ajaxSetup({
//            headers: {
//                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//            }
//        });

        console.log($('meta[name="csrf-token"]').attr('content'));

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
                var v = navtreeInstance().get_json('#', {flat:false});
                var json_output = JSON.stringify(v);

                $.post("/admin/navigation/save", json_output, function() {
                    if(window.console) console.log('Getting location details...');
                }, "json")
                .done(function(data) {
                    if(window.console) console.log('Location details:');
                    if(window.console) console.log(data);
                    // Reload the page

                    if (data && data == "us")
                    {
                        window.location.href = window.location.pathname;
                    }
                })
                .fail(function() {
                    if(window.console) console.log('Failed while getting location details.');
                })
                .always(function() {
                    if(window.console) console.log("Finished getting location details.");
                });

                return json_output;
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
