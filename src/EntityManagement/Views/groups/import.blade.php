@extends('argon::layout.master')

@section('content')
    <div class="main">
        <h1 class="page-header">Import Group Beta*</h1>

        @include('argon::inc.alerts', compact($errors))

        <form action="{{ route('cms:types:groups:post-import-json', [$type->id]) }}" method="POST" autocomplete="false">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="card">
                <div class="card-header">Json Editor</div>
                <div class="card-block json-editor-wrapper">
                    <div class="editor-tools">
                        <span class="settings fa fa-cog"></span>
                        <span class="expand fa fa-expand"></span>
                        <span class="collapse fa fa-compress"></span>
                    </div>
                    <textarea class="form-control hidden" id="json-textarea" name="json">{{ old('json') }}</textarea>
                    <div id="json-editor"></div>

                    <div class="settings-wrapper">
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
            </div>

            <div class="card accordion">
                <div class="card-header accordion-header">Browse Field Groups</div>
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

            <p class="text-muted">* This functionality is still being tested and is not meant to be used in Production yet. Use with caution and please report all the bugs.</p>

            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link" href="{{route('cms:types:edit',[$type->id])}}">Back to edit type</a>
        </form>
    </div>
@endsection

@section('footer')
    @parent

    <script src="/argon/js/ace/ace.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/js/ace/theme-twilight.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/js/ace/mode-json.js" type="text/javascript" charset="utf-8"></script>
    <script src="/argon/js/jstree.min.js"></script>

    <script>
        $(function(){
            var editor = ace.edit("json-editor"),
                textarea = $('#json-textarea').hide(),
                JsonMode = ace.require("ace/mode/json").Mode;

            editor.setTheme("ace/theme/twilight");
            editor.session.setMode(new JsonMode());
            editor.getSession().setValue(textarea.val());
            editor.getSession().on('change', function(){
                textarea.val(editor.getSession().getValue());
            });

            $('.editor-tools').on('click', '.expand, .collapse', function(){
                $('.json-editor-wrapper').toggleClass('expanded');
                editor.resize();
            }).on('click', '.settings', function(){
                $('.settings-wrapper').toggleClass('expanded');
            });


            $('#navtree')
                .on('dblclick.jstree', function(e){

                    var el = $('#navtree').jstree().get_selected(true);
                        target = el[0].data.exportTarget;

                    if(target){

                        console.log('loading');

                        $.ajax({
                            url: target,
                            data: {
                                json: true
                            }
                        }).done(function(r){

                            var json = JSON.stringify(r, null, 4);

                            editor.getSession().setValue(json);

                        });
                    }
                })
                .jstree({
                    "core": {
                        "multiple": false,
                        "dblclick_toggle": false
                    }
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

            })
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
            right: 10px;
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

        .settings-wrapper{
            padding: 20px 30px 10px;
            display: none;
        }

        .settings-wrapper.expanded{
            display: block;
        }

        #navtree {
            margin: 0 0 10px;
            padding: 0 20px 10px;
        }

        .card-block {
            padding: 0;
        }
    </style>

@endsection