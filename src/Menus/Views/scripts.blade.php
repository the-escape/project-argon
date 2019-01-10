<script src="/argon/js/jstree.min.js"></script>
<script>

    var $navtree =  $('#navtree'),
        $navtreeAddRoot = $("#navtree-add-root"),
        $navtreeAddChild = $("#navtree-add-child"),
        $navtreeRemove = $("#navtree-remove"),
        $navtreeForm = $("#navtree-form"),
        $navtreeUpdate = $("#navtree-update"),
        $navtreeDeselect = $("#navtree-deselect"),
        $navtreeOutput = $("#navtree-output");

    var navtreeForm = (function() {

        var $item_label = $("#item_label"),
            $item_url = $("#item_url"),
            $item_class = $("#item_class"),
            $item_id = $("#item_id"),
            $item_target = $("#item_target");

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

        function SetClass(value) {
            return $item_class.val(value);
        }

        function GetClass() {
            return $item_class.val();
        }

        function SetId(value) {
            return $item_id.val(value);
        }

        function GetId() {
            return $item_id.val();
        }

        function SetTarget(value) {
            return $item_target.val(value);
        }

        function GetTarget() {
            return $item_target.val();
        }

        function Clear() {
            SetLabel('');
            SetUrl('');
            SetClass('');
            SetId('');
            SetTarget('');
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
//            if (!$navtreeUpdate.hasClass("btn-primary-outline")) {
//                $navtreeUpdate.addClass("btn-primary-outline");
//            }

            if ($navtreeUpdate.hasClass("o-btn--primary")) {
                $navtreeUpdate.removeClass("o-btn--primary");
            }
        }

        function FocusUpdateBtn() {
            if ($navtreeUpdate.hasClass("btn-primary-outline")) {
                $navtreeUpdate.removeClass("btn-primary-outline");
            }

            if (!$navtreeUpdate.hasClass("o-btn--primary")) {
                $navtreeUpdate.addClass("o-btn--primary");
            }
        }

        return {
            setLabel: SetLabel,
            getLabel: GetLabel,
            setUrl: SetUrl,
            getUrl: GetUrl,
            setClass: SetClass,
            getClass: GetClass,
            setId: SetId,
            getId: GetId,
            setTarget: SetTarget,
            getTarget: GetTarget,
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
            var item_label = node.text;
            var item_url = node.data.url;
            var item_class = node.data.class;
            var item_id = node.data.id;
            var item_target = node.data.target;

            navtreeForm.setLabel(item_label);
            navtreeForm.setUrl(item_url);
            navtreeForm.setClass(item_class);
            navtreeForm.setId(item_id);
            navtreeForm.setTarget(item_target);

            $("#item_label").data('initial_value', item_label);

            navtreeForm.edit();

            $navtreeAddChild.show()
            $navtreeRemove.show()

        } else {

            $navtreeAddChild.hide()
            $navtreeRemove.hide()

        }

        navtreeForm.save();
    });

    $navtree.on('move_node.jstree', function (e, data) {
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

        navtreeInstance().create_node(null ,  {"text" : "New element", "data":{"label" : "New element", "url":"#", "class": "", "id": "", "target": "" } }, "last", function(){
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

        navtreeInstance().create_node(parentId ,  {"text" : "New element", "data":{"label" : "New element", "url":"#", "class": "", "id": "", "target": "" }  }, "last", function(){
            $navtree.jstree("deselect_all");
        });
    });


    $navtreeRemove.on("click", function(e){
        e.preventDefault();

        var selected = navtreeInstance().get_selected(true);

        if (selected && selected.length) {
            var node = selected[0];
            navtreeInstance().delete_node(node)
            navtreeForm.save();
        }
    });

    $navtreeUpdate.on("click", function(e){
        e.preventDefault();

        var selected = navtreeInstance().get_selected(true);

        if (selected && selected.length) {
            var node = selected[0];

            var item_label = navtreeForm.getLabel();
            var item_url = navtreeForm.getUrl();
            var item_class = navtreeForm.getClass();
            var item_id = navtreeForm.getId();
            var item_target = navtreeForm.getTarget();

            node.data["label"] = item_label;
            node.data["url"] = item_url;
            node.data["class"] = item_class;
            node.data["id"] = item_id;
            node.data["target"] = item_target;

            $navtree.jstree('rename_node', node , item_label );

            navtreeForm.save();
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
