<script src="/argon/js/jstree.min.js"></script>
<script>

    var $navtree =  $('#navtree'),
        $navtreeAddRoot = $("#navtree-add-root"),
        $navtreeAddChild = $("#navtree-add-child"),
        $navtreeForm = $("#navtree-form"),
        $navtreeUpdate = $("#navtree-update"),
        $navtreeDeselect = $("#navtree-deselect"),
        $navtreeOutput = $("#navtree-output");

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

        function Hide() {
            $navtreeForm.hide();
        }

        function Edit() {
            $navtreeForm.show()
        }

        function saveData() {
            var data = navtreeInstance().get_json('#', {flat:false});
            var json = JSON.stringify(data);
            $navtreeOutput.val(json);
            return json;
        }

        function Save() {
            saveData();
            //$navtreeOutput.show();
        }

        function GetData() {
            var data = $navtreeOutput.val();

            if (data && data.length) {
                return JSON.parse(data);
            }

            return [];
        }

        function UnfocusUpdateBtn() {
            if (!$navtreeUpdate.hasClass("btn-primary-outline")) {
                $navtreeUpdate.addClass("btn-primary-outline");
            }

            if ($navtreeUpdate.hasClass("btn-primary")) {
                $navtreeUpdate.removeClass("btn-primary");
            }
        }

        function FocusUpdateBtn() {
            if ($navtreeUpdate.hasClass("btn-primary-outline")) {
                $navtreeUpdate.removeClass("btn-primary-outline");
            }

            if (!$navtreeUpdate.hasClass("btn-primary")) {
                $navtreeUpdate.addClass("btn-primary");
            }
        }

        return {
            setLabel: SetLabel,
            getLabel: GetLabel,
            setUrl: SetUrl,
            getUrl: GetUrl,
            clear: Clear,
            hide: Hide,
            edit: Edit,
            save: Save,
            getData:GetData,
            unfocusUpdateBtn:UnfocusUpdateBtn,
            focusUpdateBtn:FocusUpdateBtn
        };
    })();

    $navtree.jstree({
        "plugins" : ['dnd'],
        "core": {
            "check_callback": true,
            "multiple": false,
            "data": navtreeForm.getData()
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
        navtreeForm.hide();
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

            $navtreeAddChild.show()

        } else {

            $navtreeAddChild.hide()

        }

        navtreeForm.save();
    });

    $navtreeDeselect.on("click",function(e) {
        e.preventDefault();

        var selected = navtreeInstance().get_selected(true);

        if (selected && selected.length) {
            navtreeInstance().deselect_node(selected[0]);
        }

        navtreeForm.unfocusUpdateBtn();
    });

    $navtreeAddRoot.on("click",function(e) {

        e.preventDefault();

        navtreeInstance().create_node(null ,  {"text" : "New element", "li_attr" : {"item_label" : "New element", "item_url":"#" } }, "last", function(){
            $navtree.jstree("deselect_all");
        });
    });

    $navtreeAddChild.on("click",function(e) {

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
        navtreeForm.unfocusUpdateBtn();
    });



    $("input[type='text']").on('keyup', function(e) {

        var initial_value = $(this).data("initial_value");

        if (this.value != initial_value) {


            navtreeForm.focusUpdateBtn();

            return;
        }

        navtreeForm.unfocusUpdateBtn();
    });



</script>
