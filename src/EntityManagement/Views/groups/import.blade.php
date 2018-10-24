@extends('argon::layout.master')

@section('body-class', 'medialib medialib-all')

@section('body-id', 'argon-ui')

@section('content')

    <header class="c-header c-container">
        <div class="c-header__title">
            <h1>Import Field Group</h1>
        </div>
    </header>


    {{-- need some refactoring, I noticed some issues with blocks library saving and retrieving blocks + problems with alerts --}}


    <form action="{{ route('cms:types:groups:post-import-json', [$type->id]) }}" method="POST" autocomplete="false">

        <main class="c-container c-container--main">

            @include('argon::inc.new-alerts')

            <div class="o-form">

                <div class="js-alerts"></div>

                <div class="json-editor-wrapper c-json-editor">
                    <div class="loading-overlay c-json-editor__loading-overlay js-loading-block"></div>
                    <div class="editor-tools c-json-editor__editor-tools">
                        <span class="settings fa fa-cog"></span>
                        <span class="expand fa fa-expand"></span>
                        <span class="collapse fa fa-compress"></span>
                    </div>

                    @if(env('BLOCKS_LIB_URL', false))
                        <div class="c-library-tools library-tools js-library-tools">
                            <span class="c-library-tools__button c-library-tools__create create fa fa-plus"></span>
                            <span class="c-library-tools__button c-library-tools__save save fa fa-save"></span>
                            <span class="c-library-tools__button c-library-tools__input"><input type="text" name="lib_block_name"></span>
                            <label class="js-select-image">
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

                    <div id="json-editor" class="c-json-editor__editor"></div>
                </div>


                <div class="c-blocks-library__settings-wrapper js-settings-wrapper">

                    <div class="o-form__group">
                        <div class="o-form-status">
                            <div class="o-form__list">
                                <div class="o-checkbox">
                                    <input type="hidden" name="smart_import" class="js-toggle-value" value="0">
                                    <label>
                                        <input type="checkbox" value="1" name="" id="smart_import" class="js-toggle-input" {{ session()->get('smartImportFieldGroups') ? 'checked="checked"' : '' }}>
                                        <span><svg><use xlink:href="/argon/images/svgicons.svg#tick"></use></svg></span>
                                    </label>
                                    <label for="smart_import">Smart Import</label>
                                </div>
                            </div>
                        </div>
                        <div class="o-form__help-text l-full">
                            <p>If the fields already exist append number at the end of the field name and carry on with the import</p>
                        </div>
                    </div>

                </div>



                <div class="l-halves l-internal-columns c-import-field-groups">

                    <div>
                        <div class="c-import-field-groups__title">
                            <h4>Local templates</h4>
                            <p>Copy field groups from another template existing in this project.</p>
                        </div>
                        <div class="c-import-field-groups__search">
                            <div class="o-form__group o-form__group--icon-btn">
                                <input type="text" class="js-search-navtree" name="local_search" placeholder="Search field groups">
                                <button class="js-search-navtree-trigger">
                                    <svg>
                                        <use xlink:href="/argon/images/svgicons.svg#search"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="c-import-field-groups__column">
                            <div id="navtree" class="c-import-field-groups__navtree">
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

                    <div>
                        @if(env('BLOCKS_LIB_URL', false))
                            <div class="c-import-field-groups__title">
                                <h4>Blocks Library</h4>
                                <p>Import blocks stored in the cloud.</p>
                            </div>
                            <div class="c-import-field-groups__search">
                                <div class="o-form__group o-form__group--icon-btn">
                                    <input type="text" class="js-search-blocks-library" name="cloud_search" placeholder="Search field groups">
                                    <button class="js-search-blocks-library-trigger">
                                        <svg>
                                            <use xlink:href="/argon/images/svgicons.svg#search"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="c-import-field-groups__column">
                                <div class="c-blocks-library js-blocks-library">

                                    @foreach($blocks as $b)
                                        <div class="c-blocks-library__item js-get-library-block show" data-block-id="{{$b->id}}" data-block-url="{{ route('cms:blockslibrary:get',[$b->id]) }}" >
                                            <div class="c-blocks-library__item-name">{{ $b->name }}</div>
                                            <div class="c-blocks-library__item-image" style="background-image: url('{{ $b->image }}')"></div>
                                        </div>
                                    @endforeach

                                    <div class="c-blocks-library__no-blocks-message">No blocks in the library.</div>
                                </div>
                                <div class="c-blocks-library__item--template js-block-template">
                                    <div class="c-blocks-library__item-name"></div>
                                    <div class="c-blocks-library__item-image" style="background-image: url()"></div>
                                </div>
                            </div>
                        @endif
                    </div>


                </div>

            </div>
        </main>

        <footer class="c-footer__wrapper">
            <div class="c-footer c-container c-footer--fixed"> <!-- .c-footer--fixed -->
                <div class="c-footer__container">

                    <div class="c-footer__buttons">
                        <div></div>
                        <div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <a class="o-btn o-btn--sm" href="{{route('cms:types:edit', [$type->id])}}">Cancel</a>
                            <input type="submit" class="o-btn o-btn--sm o-btn--primary js-import" value="Import">
                        </div>
                    </div>

                </div>
            </div>
        </footer>

    </form>


@endsection


@section('footer')
    @parent

    <script src="/argon/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/js/ace/theme-twilight.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/js/ace/mode-json.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/js/ace/mode-php.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/js/jstree.min.js"></script>

    <script>

        var BlocksLib = {
            mode: 'json',
            json: null,
            mappers: null,
            blade: null,
            selectedBlock: null
        };

        $(function(){

            var editor = ace.edit("json-editor"),
                jsonTextarea = $('#json-textarea').hide(),
                bladeTextarea = $('#blade-textarea').hide(),
                mappersTextarea = $('#mappers-textarea').hide(),
                JsonMode = ace.require("ace/mode/json").Mode,
                PhpMode = ace.require("ace/mode/php").Mode,
                blockImageInput = $('[name=lib_block_image]'),
                blockImageBtn = $('.js-select-image'),
                blockNameInput = $('[name=lib_block_name]');

            BlocksLib.mode = 'json';
            BlocksLib.selectedBlock = null;

            editor.setTheme("ace/theme/twilight");
            editor.session.setMode(new JsonMode());

//            editor.getSession().setValue(jsonTextarea.val());
            BlocksLib.blade = bladeTextarea.val();
            BlocksLib.mappers = mappersTextarea.val();
            BlocksLib.json = jsonTextarea.val();

            editor.getSession().on('change', function(){
                console.log('change');

                switch(BlocksLib.mode){
                    case 'blade':
                        BlocksLib.blade = editor.getSession().getValue();
//                        bladeTextarea.val(editor.getSession().getValue());
                        break;
                    case 'mappers':
                        BlocksLib.mappers = editor.getSession().getValue();
//                        mappersTextarea.val(editor.getSession().getValue());
                        break;
                    case 'json':
                    default:
                        BlocksLib.json = editor.getSession().getValue();
//                        jsonTextarea.val(editor.getSession().getValue());
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

                            BlocksLib.json = json;
                            BlocksLib.mappers = r.mappers;
                            BlocksLib.blade = r.blade;


//                            jsonTextarea.val(json);
//                            bladeTextarea.val(r.blade);
//                            mappersTextarea.val(r.mappers);

                            blockNameInput.val(r.name);

                            if (r.image) {
                                blockImageInput.val(r.image);
                                blockImageBtn.addClass('selected');
                            } else {
                                unsetImage();
                            }

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
            }).on('click', '.js-select-image.selected', function(e) {
                e.preventDefault();
                unsetImage();
            }).on('mouseover', '.js-select-image.selected', function() {
                var src = blockImageInput.val(),
                    el = $('<div class="c-blocks-library__img-preview"><img src="'+src+'"></div>');
                $('.c-json-editor').append(el);
            }).on('mouseout', '.js-select-image.selected', function() {
                $('.c-json-editor').find('.c-blocks-library__img-preview').remove();
            });


            $('.js-alerts').on('click', '.js-close-alert', function(e) {
                e.preventDefault();
                $(this).parent().remove();
            })



            $('[name=lib_block_image_tmp]').on('change', function(){
                encodeImagetoBase64(this);
                console.log('selected image');
                $('.js-select-image').addClass('selected');
            });



            var navtree = $('#navtree')
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

                            BlocksLib.json = json;
                            BlocksLib.mappers = '';
                            BlocksLib.blade = '';

//                            jsonTextarea.val(json);

                            changeEditorMode('json');
                            $('.js-loading-block').removeClass('show');


                        });
                    }
                })
                .jstree({
                    plugins: ['contextmenu', 'dnd', 'search', 'state'],
                    core: {
                        multiple: false,
                        dblclick_toggle: false,
                        themes: {
                            stripes: true
                        }
                    },
                    search : {
                        show_only_matches : true,
//                        search_callback : function (str, node) {
//                            if(node.text === str) { return true; }
//                        }
                    },
                });

//            $('.js-search-navtree').on('keyup', function(e) {
//                navtree.jstree(true).search($(this).val());
//            });

            $('.js-search-navtree').on('keyup', searchNavTree);
            $('.js-search-navtree-trigger').on('click', searchNavTree);

            $('.js-search-blocks-library').on('keyup', searchCloud);
            $('.js-search-blocks-library-trigger').on('click', searchCloud);



            $('.js-import').on('click', function(e) {
                e.preventDefault();

                jsonTextarea.val(BlocksLib.json);
                bladeTextarea.val(BlocksLib.blade);
                mappersTextarea.val(BlocksLib.mappers);

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
                        closeBtn = '<button type="button" class="close js-close-alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';

                    btn.prop('disabled',false).html('Save');

                    if(r.success)
                    {
                        var message = r.msg ? r.msg : 'Field group has been successfully imported.';
                        msg += '<div class="o-alert o-alert--success">'+closeBtn+'<p>'+message+'</p>';
                    }
                    else
                    {
                        msg += '<div class="o-alert o-alert--danger">'+closeBtn+'<p><strong>Submission failed</strong></p>';

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

            function searchNavTree(e){
                e.preventDefault();

                var search = $('.js-search-navtree').val();
                navtree.jstree(true).search(search);
            }

            function searchCloud(e){
                e.preventDefault();

                var search = $('.js-search-blocks-library').val();

                if (search === '') {
                    $('.c-blocks-library__item').addClass('show');
                } else {

                    // todo: refactor - case insensitive
                    $('.c-blocks-library__item').removeClass('show');
                    $('.c-blocks-library__item-name:contains(' + search + ')').parent().addClass('show');
                }
            }

            function changeEditorMode(selectedMode){

                mode = selectedMode || BlocksLib.mode;

                BlocksLib.mode = mode;

                var activeToggle = $('.js-library-tools .toggle.active');

                activeToggle.removeClass('active');

                if (BlocksLib.selectedBlock !== null){

                    $('.js-library-tools').addClass('show');

                    switch(mode){
                        case 'blade':
                            $('.js-library-tools .toggle-blade').addClass('active');

//                            editor.getSession().setValue(bladeTextarea.val());
                            editor.session.setMode(new PhpMode());
                            editor.getSession().setValue(BlocksLib.blade);

                            break;
                        case 'mappers':
                            $('.js-library-tools .toggle-mappers').addClass('active');

//                            editor.getSession().setValue(mappersTextarea.val());
                            editor.session.setMode(new PhpMode());
                            editor.getSession().setValue(BlocksLib.mappers);
                            break;
                        case 'json':
                        default:
                            $('.js-library-tools .toggle-json').addClass('active');

//                            editor.getSession().setValue(jsonTextarea.val());
                            editor.session.setMode(new JsonMode());
                            editor.getSession().setValue(BlocksLib.json);
                            break;
                    }


                } else {

                    $('.js-library-tools .toggle-json').addClass('active');

//                    editor.getSession().setValue(jsonTextarea.val());
                    editor.session.setMode(new JsonMode());
                    editor.getSession().setValue(BlocksLib.json);

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

//                var data = {
//                    name: blockNameInput.val(),
//                    json: jsonTextarea.val(),
//                    blade: bladeTextarea.val(),
//                    mappers: mappersTextarea.val(),
//                };

                var data = {
                    name: blockNameInput.val(),
                    json: BlocksLib.json,
                    blade: BlocksLib.blade,
                    mappers: BlocksLib.mappers,
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

                            newBlock.removeClass('js-block-template c-blocks-library__item--template');
                            newBlock.addClass('c-blocks-library__item js-get-library-block editing show');
                            newBlock.data('blockId', r.block.id);
                            newBlock.attr('data-block-id', r.block.id);
                            newBlock.data('blockUrl', '/admin/blockslibrary/'+r.block.id);
                            newBlock.find('.c-blocks-library__item-name').text(data.name);
                            newBlock.find('.c-blocks-library__item-image').css('background-image', 'url("'+data.image+'")');


                            $('.js-blocks-library').prepend(newBlock);

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

            function unsetImage() {
                blockImageBtn.removeClass('selected');
                blockImageBtn.find('[name=lib_block_image_tmp]').val('');
                blockImageInput.val('');
                $('.c-json-editor').find('.c-blocks-library__img-preview').remove();
            }



        });
    </script>
@endsection