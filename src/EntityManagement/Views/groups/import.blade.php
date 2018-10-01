@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Import Field Group</h1>

        <div class="js-alerts">
            @include('argon::inc.alerts', compact($errors))
        </div>

        <form action="{{ route('cms:types:groups:post-import-json', [$type->id]) }}" method="POST" autocomplete="false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">
                <div class="card-header js-editor-title">Json Editor</div>
                <div class="card-block json-editor-wrapper">
                    <div class="loading-overlay js-loading-block"></div>
                    <div class="editor-tools">
                        <span class="settings fa fa-cog"></span>
                        <span class="expand fa fa-expand"></span>
                        <span class="collapse fa fa-compress"></span>
                    </div>

                    @if(env('BLOCKS_LIB_URL', false))
                        <div class="c-library-tools library-tools js-library-tools">
                            <span class="c-library-tools__button c-library-tools__create create fa fa-plus"></span>
                            <span class="c-library-tools__button c-library-tools__save save fa fa-save"></span>
                            <span class="c-library-tools__button c-library-tools__input"><input type="text" name="lib_block_name"></span>
                            <label class="">
                                <span class="c-library-tools__button c-library-tools__image image fa fa-image"></span>
                                <input type="file" name="lib_block_image_tmp" style="display:none;">
                                <input type="hidden" name="lib_block_image">
                            </label>
                            <span class="c-library-tools__button c-library-tools__toggle toggle toggle-json active" data-mode="json">json</span>
                            <span class="c-library-tools__button c-library-tools__toggle toggle toggle-blade" data-mode="blade">blade</span>
                            <span class="c-library-tools__button c-library-tools__toggle toggle toggle-mappers" data-mode="mappers">php</span>
                            <span class="c-library-tools__button c-library-tools__delete delete fa fa-trash"></span>
                            <span class="c-library-tools__button c-library-tools__close  js-library-close-block fa fa-close"></span>
                        </div>
                    @endif

                    <textarea class="form-control hidden js-block-lib-data" id="json-textarea" name="json">{{ old('json') }}</textarea>
                    <textarea class="form-control hidden js-block-lib-data" id="blade-textarea" name="blade"></textarea>
                    <textarea class="form-control hidden js-block-lib-data" id="mappers-textarea" name="mappers"></textarea>

                    <div id="json-editor"></div>


                </div>
            </div>

            <div class="card c-blocks-library__settings-wrapper js-settings-wrapper">
                <div class="card-block">

                    <div class="form-group">
                        <label>Settings</label>
                        <div>
                            <label class="checkbox-inline"><input type="checkbox" class="" name="smart_import" value="1" {{ session()->get('smartImportFieldGroups') ? 'checked="checked"' : '' }}>
                                Smart Import
                                <small class="text-muted">If the fields already exist append number at the end of the field name and carry on with the import</small>
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            @if(env('BLOCKS_LIB_URL', false))
                <div class="card accordion">
                    <div class="card-header accordion-header">Blocks Library</div>
                    <div class="card-block accordion-body">
                        <div class="c-blocks-library js-blocks-library">

                            @foreach($blocks as $b)
                                <div class="c-blocks-library__item js-get-library-block" data-block-id="{{$b->id}}" data-block-url="{{ route('cms:blockslibrary:get',[$b->id]) }}" >
                                    <div class="c-blocks-library__item-name">{{ $b->name }}</div>
                                    <div class="c-blocks-library__item-image" style="background-image: url('{{ $b->image }}')"></div>
                                </div>
                            @endforeach

                            @if(empty($blocks))
                                <p class="text-muted">No blocks in the library.</p>
                            @endif
                        </div>
                        <div class="c-blocks-library__item--template js-block-template">
                            <div class="c-blocks-library__item-name"></div>
                            <div class="c-blocks-library__item-image" style="background-image: url()"></div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card accordion">
                <div class="card-header accordion-header">Local Field Groups</div>
                <div class="card-block accordion-body">
                    <div id="navtree">
                        <ul>
                            @foreach($types as $t)
                                <li>
                                    {{ $t->name }}
                                    <ul>
                                        @foreach($t->groups as $g)
                                            <li data-jstree='{"icon":"fa fa-file-code-o"}' data-export-target="{{ route('cms:types:groups:export', [$t->id, $g->id]) }}">
                                                {{ $g->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-primary js-import">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:edit',[$type->id])}}">Back to edit type</a>
        </form>
    </div>
@endsection

@section('footer')
    @parent

    <script src="/argon/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/js/ace/theme-twilight.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/js/ace/mode-json.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/js/ace/mode-php.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/js/jstree.min.js"></script>

    <script>

        var BlocksLib = {};

        $(function(){

            var editor = ace.edit("json-editor"),
                jsonTextarea = $('#json-textarea').hide(),
                bladeTextarea = $('#blade-textarea').hide(),
                mappersTextarea = $('#mappers-textarea').hide(),
                JsonMode = ace.require("ace/mode/json").Mode,
                PhpMode = ace.require("ace/mode/php").Mode,
                blockNameInput = $('[name=lib_block_name]');

            BlocksLib.mode = 'json';
            BlocksLib.selectedBlock = null;

            editor.setTheme("ace/theme/twilight");
            editor.session.setMode(new JsonMode());

            editor.getSession().setValue(jsonTextarea.val());
            editor.getSession().on('change', function(){

                switch(mode){
                    case 'blade':
                        bladeTextarea.val(editor.getSession().getValue());
                        break;
                    case 'mappers':
                        mappersTextarea.val(editor.getSession().getValue());
                        break;
                    case 'json':
                    default:
                        jsonTextarea.val(editor.getSession().getValue());
                        break;
                }
            });

            $('.editor-tools').on('click', '.expand, .collapse', function(){
                $('.json-editor-wrapper').toggleClass('expanded');
                editor.resize();
            }).on('click', '.settings', function(){
                $('.js-settings-wrapper').toggleClass('expanded');
            });



            $('.js-export-json').on('click' ,function(e){
                e.preventDefault();

                var $btn = $(this),
                    url = $btn.attr('href');

                $.ajax(url).done(function(r){
                    if ($('.modals').find('#groupExport').length){
                        $('.modals').find('#groupExport .modal-content').html($(r).find('.modal-content').html());
                    } else {
                        $('.modals').append($(r));
                    }

                    $('#groupExport').modal('show');
                });
            });



            $('.modals').on('click','.js-copy-to-clip', function(e){

                $('[name=group-export-json]').select()
                    .on("focus", function() {
                        document.execCommand('selectAll',false,null)
                    })
                    .focus();

                var success = document.execCommand("copy");

                if(success){
                    $(this).html('Copied!').addClass('btn-success').removeClass('btn-primary').prop('disabled',true);
                }

                setTimeout(function(){
                    $('#groupExport').modal('hide');
                }, 300);

            });



            $('.js-blocks-library').on('dblclick', '.js-get-library-block', function(e) {
                e.preventDefault();

                if ($(this).hasClass('editing'))
                {
                    unsetBlock();
                    changeEditorMode('json');
                    editor.getSession().setValue('');
                }
                else
                {
                    var url = $(this).data('blockUrl');

                    $(this).siblings().removeClass('editing');
                    $(this).addClass('editing');

                    $('.js-loading-block').addClass('show');

                    $.ajax(url).done(function(r) {

                        if(r.json !== undefined){

                            r.json = r.json || {};
                            var json = JSON.stringify(r.json, null, 4);

                            BlocksLib.selectedBlock = r.id;
                            $('.js-lib-block').val(r.id);
                            jsonTextarea.val(json);
                            bladeTextarea.val(r.blade);
                            mappersTextarea.val(r.mappers);
                            blockNameInput.val(r.name);

                            $('.js-loading-block').removeClass('show');

                            changeEditorMode('json');
                        }
                    });
                }
            });



            $('.js-library-close-block').on('click', function(){
                unsetBlock();
                changeEditorMode('json');
            });



            $('.js-library-tools').on('click', '.toggle', function(){
                var mode = $(this).data('mode');
                changeEditorMode(mode);
            }).on('click', '.save', function() {
                saveBlock();
            }).on('click', '.delete', function() {
                deleteBlock();
            }).on('click', '.create', function() {
                createBlock();
            });



            $('[name=lib_block_image_tmp]').on('change', function(){
                encodeImagetoBase64(this);
            });



            $('#navtree')
                .on('dblclick.jstree', function(e){

                    var el = $('#navtree').jstree().get_selected(true);
                    target = el[0].data.exportTarget;

                    $('.js-loading-block').addClass('show');

                    unsetBlock();

                    if(target){

                        $.ajax({
                            url: target,
                            data: {
                                json: true
                            }
                        }).done(function(r){

                            var json = JSON.stringify(r, null, 4);

                            jsonTextarea.val(json);
                            changeEditorMode('json');
                            $('.js-loading-block').removeClass('show');


                        });
                    }
                })
                .jstree({
                    "core": {
                        "multiple": false,
                        "dblclick_toggle": false
                    }
                });

            $('.js-import').on('click', function(e) {
                e.preventDefault();

                var btn = $(this),
                    form = btn.closest('form'),
                    action = form.attr('action'),
                    data = form.serializeArray(),
                    alerts = $('.js-alerts');

                alerts.html('');
                btn.prop('disabled',true).html('Saving...');

                $.ajax({
                    url: action,
                    type: 'post',
                    data: data
                }).done(function(r) {
                    var msg = '',
                        closeBtn = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';

                    btn.prop('disabled',false).html('Save');

                    if(r.success)
                    {
                        var message = r.msg ? r.msg : 'Field group has been successfully imported.';
                        msg += '<div class="alert alert-success">'+closeBtn+'<p>'+message+'</p>';
                    }
                    else
                    {
                        msg += '<div class="alert alert-danger">'+closeBtn+'<p><strong>Submission failed</strong></p>';

                        if (r.error) {
                            msg += "<ul>";
                            $.each(r.error, function(k, v) {
                                msg += "<li>" + v + "</li>";
                            });
                            msg += "</ul>";
                        }
                    }

                    msg += '</div>';
                    alerts.html(msg);

                });

            });


            function changeEditorMode(selectedMode){

                mode = selectedMode || BlocksLib.mode;

                var activeToggle = $('.js-library-tools .toggle.active'),
                    currentMode = activeToggle.data('mode'),
                    currentData = editor.getSession().getValue();

                activeToggle.removeClass('active');

                if (BlocksLib.selectedBlock !== null){

                    $('.js-library-tools').addClass('show');

                    switch(mode){
                        case 'blade':
                            $('.js-library-tools .toggle-blade').addClass('active');

                            editor.getSession().setValue(bladeTextarea.val());
                            editor.session.setMode(new PhpMode());

                            break;
                        case 'mappers':
                            $('.js-library-tools .toggle-mappers').addClass('active');

                            editor.getSession().setValue(mappersTextarea.val());
                            editor.session.setMode(new PhpMode());
                            break;
                        case 'json':
                        default:
                            $('.js-library-tools .toggle-json').addClass('active');

                            editor.getSession().setValue(jsonTextarea.val());
                            editor.session.setMode(new JsonMode());
                            break;
                    }


                } else {

                    $('.js-library-tools .toggle-json').addClass('active');

                    editor.getSession().setValue(jsonTextarea.val());
                    editor.session.setMode(new JsonMode());

                    $('.js-library-tools').removeClass('show');

                }
            }

            function deleteBlock(){
                var url = '/admin/blockslibrary/delete/'+BlocksLib.selectedBlock;

                $.ajax({
                    url: url,
                    type: 'post'
                }).done(function(r){
                    if(r.success){
                        $('.js-get-library-block[data-block-id='+BlocksLib.selectedBlock+']').remove();
                        editor.getSession().setValue('');

                        unsetBlock();
                        changeEditorMode('json');
                    }
                });
            }

            function createBlock(){
                BlocksLib.selectedBlock = 'new';
                changeEditorMode('json');
            }

            function saveBlock(){
                var url = '/admin/blockslibrary';

                blockNameInput.parent().removeClass('error');

                if(blockNameInput.val() === '')
                {
                    blockNameInput.parent().addClass('error');
                    return false;
                }

                if(BlocksLib.selectedBlock && BlocksLib.selectedBlock != 'new')
                {
                    url += '/' + BlocksLib.selectedBlock;
                }

                var data = {
                    name: blockNameInput.val(),
                    json: jsonTextarea.val(),
                    blade: bladeTextarea.val(),
                    mappers: mappersTextarea.val(),
                };

                if($('[name=lib_block_image]').val() !== '')
                {
                    data.image = $('[name=lib_block_image]').val();
                }

                $.ajax({
                    url: url,
                    type: 'post',
                    data: data
                }).done(function(r){
                    if(r.success){

                        if(BlocksLib.selectedBlock === 'new' && r.block){

                            BlocksLib.selectedBlock = r.block.id;

                            var newBlock = $('.js-block-template').clone();

                            newBlock.removeClass('js-block-template').removeClass('c-blocks-library__item--template');
                            newBlock.addClass('c-blocks-library__item').addClass('js-get-library-block editing');
                            newBlock.data('blockId', r.block.id);
                            newBlock.attr('data-block-id', r.block.id);
                            newBlock.data('blockUrl', '/admin/blockslibrary/'+r.block.id);
                            newBlock.find('.c-blocks-library__item-name').text(data.name);
                            newBlock.find('.c-blocks-library__item-image').css('background-image', 'url("'+data.image+'")');


                            $('.c-blocks-library').prepend(newBlock);

                        } else {

                            var blockItem = $('.js-get-library-block[data-block-id='+BlocksLib.selectedBlock+']');

                            blockItem.find('.c-blocks-library__item-name').text(data.name);
                            if(data.image){
                                blockItem.find('.c-blocks-library__item-image').css('background-image', 'url("'+data.image+'")');
                            }

                        }
                    }
                    else{
                        blockNameInput.parent().addClass('error');
                    }
                });
            }


            function unsetBlock(){
                $('.js-get-library-block.editing').removeClass('editing');

                BlocksLib.selectedBlock = null;
                $('.js-lib-block').val();
                bladeTextarea.val('');
                mappersTextarea.val('');
                blockNameInput.val('');
            }



            function encodeImagetoBase64(element) {
                var file = element.files[0];
                var reader = new FileReader();
                reader.onloadend = function() {
                    $("[name=lib_block_image]").val(reader.result);
                }
                reader.readAsDataURL(file);
            }



        });
    </script>
@endsection


@section('styles')
    @parent

    <style>
        .json-editor-wrapper{
            position: relative;
        }

        .json-editor-wrapper #json-editor{
            position: relative;
            width: 100%;
            height: 350px;
        }

        .json-editor-wrapper.expanded #json-editor {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 2998;
        }

        .json-editor-wrapper .editor-tools{
            position: absolute;
            top: 25px;
            right: 40px;
            z-index: 2999;
        }

        .json-editor-wrapper.expanded .editor-tools {
            position: fixed;
            top: 10px;
            right: 20px;
        }

        .json-editor-wrapper .editor-tools > *{
            background-color: white;
            padding: 7px 8px;
            margin-left: 5px;
            cursor: pointer;
        }

        .json-editor-wrapper .editor-tools .collapse{
            display: none;
        }

        .json-editor-wrapper.expanded .editor-tools .expand,
        .json-editor-wrapper.expanded .editor-tools .settings{
            display: none;
        }

        .json-editor-wrapper.expanded .editor-tools .collapse{
            display: inline-block;
        }

        .c-library-tools{
            position: absolute;
            bottom: 25px;
            right: 40px;
            z-index: 2999;
            display: flex;
            height: 30px;
        }

        .json-editor-wrapper.expanded .c-library-tools {
            position: fixed;
            bottom: 10px;
            right: 20px;
        }

        /*.c-library-tools.show{*/
            /*display: flex;*/
        /*}*/

        .c-library-tools__button{
            background-color: white;
            padding: 7px 8px;
            margin-right: 10px;
            cursor: pointer;
            min-width: 30px;
            text-align: center;

            display: none;
        }

        .c-library-tools.show .c-library-tools__button{
            display: block;
        }

        .c-library-tools__create{
            display: block;
            margin-right: 0;
        }

        .c-library-tools.show .c-library-tools__create{
            display: none;
        }

        .c-library-tools__input.error {
            background-color: rgb(255, 150, 150)
        }

        .c-library-tools__delete{
            margin-left: 10px;
        }

        .c-library-tools__close{
            margin-right: 0;
        }

        .c-library-tools__toggle{
            padding: 3px 8px;
            margin-right: 1px;
        }

        .c-library-tools__toggle.active{
            background-color: #cdcdcd;
        }

        .c-library-tools__input{
            padding: 0;
        }

        .c-library-tools__input input {
            background-color: transparent;
            border: 0 none;
            outline: 0 none;
            padding: 2px 10px;
        }

        .c-library-tools__input input:active {
            outline: 0 none
        }

        .c-blocks-library__settings-wrapper {
            padding: 20px 30px 10px;
            display: none;
        }

        .c-blocks-library__settings-wrapper.expanded{
            display: block;
        }

        #navtree {
            margin: 0 0 10px;
            padding: 0 20px 10px;
        }

        .card-block {
            padding: 0;
        }

        .loading-overlay{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            align-items: center;
            justify-content: center;
            z-index: 99;

            display: none;
        }

        .loading-overlay.show{
            display: flex;
        }

        .loading-overlay:after{
            content: "loading...";
            display: block;
            text-align: center;
            color: white;
        }

        .c-blocks-library{
            display: flex;
            flex-wrap: wrap;
            overflow-y: auto;
            padding: 5px;
            width: 100%;
            max-height: 450px;
        }

        .c-blocks-library__item {
            flex: 0 0 400px;
            width: 400px;
            min-height: 70px;
            margin: 5px;
            transition: opacity linear 200ms;
            opacity: .7;
            cursor: pointer;
            display: flex;
            flex-direction: row-reverse;
            border: 1px solid #c1c1c1;
            box-sizing: border-box;
        }

        .c-blocks-library__item--template{
            display: none;
        }

        .c-blocks-library__item:hover {
            opacity: 1;
        }

        .c-blocks-library__item-name{
            flex: 0 1 300px;
            text-align: left;
            align-self: center;
            padding: 5px 15px;
            /*background-color: black;*/
            /*color: white;*/
            /*border-radius: 5px 5px 0 0;*/
        }

        .c-blocks-library__item-name::selection {
            background-color: transparent;
        }

        .c-blocks-library__item-image{
            flex: 0 0 100px;
            width: 100px;
            height: 70px;

            /*background-color: #cdcdcd;*/
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            border-right: 1px solid #c1c1c1;

            /*border-top: 0 none;*/
            /*border-radius: 0 0 5px 5px;*/
        }

        .c-blocks-library__item.editing{
            opacity: 1;
            border-color: #0275d8;
        }

        .c-blocks-library__item.editing .c-blocks-library__item-name{

        }

        .c-blocks-library__item.editing .c-blocks-library__item-image{
            border-color: #0275d8;
        }
    </style>

@endsection