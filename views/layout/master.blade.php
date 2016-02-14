<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}">
        <title>Argon Admin Area</title>
        <link rel="stylesheet" href="/argon/js/jstree/style.min.css" />
        <link rel="stylesheet" href="/argon/css/app.css">
        <link rel="adminroot" href="/admin">
        @section('styles')
        @show
    </head>

    <body class="dashboard">

        <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
            <ul class="nav navbar-nav pull-xs-right">
                @if($currentUser->hasPermission('cms:settings'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('settings') }}">Settings</a></li>
                @endif
                <li class="nav-item"><a class="nav-link" href="{{ route('cms:user:profile') }}">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
            </ul>
            <a class="navbar-brand" href="{{ route('dashboard') }}">Argon</a>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    @foreach ($plugins->getNavLinksForUser($currentUser) as $group)
                        <ul class="nav nav-pills nav-stacked">
                            @foreach ($group as $plugin)
                                <li class="nav-item"><a class="nav-link" href="{{$plugin->url}}">{{$plugin->name}}</a></li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>

                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
                    @yield('content')
                </div>
            </div>
        </div>

        <script src="/argon/js/jquery.min.js"></script>
        <script src="/argon/js/core.js"></script>
        <script src="/argon/js/widget.js"></script>
        <script src="/argon/js/mouse.js"></script>
        <script src="/argon/js/accordion.js"></script>
        <script src="/argon/js/sortable.js"></script>
        <script src="/argon/js/tether.min.js"></script>
        <script src="/argon/js/bootstrap.min.js"></script>
        <script src="/argon/js/ckeditor/ckeditor.js"></script>
        <script src="/argon/js/jstree.min.js"></script>
        <script src="/argon/js/bootstrap-datepicker.min.js"></script>
        <script src="/argon/js/argon.js"></script>

        <script>

            <?php
            // enable ajax post requests as per http://laravel.com/docs/master/routing#csrf-x-csrf-token ?>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "<?=csrf_token();?>"
                }
            });

            <?php
            // ACCORDIONS: Handle all accordion instances on the page with .accordion-expand-collapse trigger ?>
            var $accordionExpandCollapse = $('.accordion-expand-collapse');

            $accordionExpandCollapse.click(function()
            {
                var isExpanded = this.getAttribute('data-expanded');

                if (isExpanded)
                {
                    $('.accordion-header.ui-state-active').trigger('click');
                }
                else
                {
                    $('.accordion-header:not(.ui-state-active)').trigger('click');
                }

                return false;
            });


            <?php
            // ACCORDIONS: Handle individial accordions ?>
            $('.accordion').accordion(
            {
                active: false,
                header: ".accordion-header",
                collapsible: true,
                heightStyle: "content",
                icons: {
                    activeHeader: "accordion-header-open",
                    header: "accordion-header-close"
                },
                animate: {
                    duration: 400
                },
                activate: function()
                {
                    var isActive = $(this).accordion("option", "active");

                    if (isActive === false)
                    {
                        $accordionExpandCollapse.each(function()
                        {
                            var $self = $(this);
                            var expandAllText = $self.data('data-expand') || 'Expand all';

                            if(!$('.accordion-header.ui-state-active').length)
                            {
                                $self.removeClass('expanded');
                            }

                            $self.text(expandAllText);
                            $self.removeAttr('data-expanded');
                        });
                    }
                    else
                    {
                        $accordionExpandCollapse.each(function()
                        {
                            var $self = $(this);
                            var collapseAllText = $self.data('data-collapse') || 'Collapse all';

                            $self.addClass('expanded');
                            $self.text(collapseAllText);
                            $self.attr('data-expanded', true);
                        });
                    }
                }
            });


            <?php
            // ACCORDIONS: expand all instances on load after slight delay. ?>
            setTimeout(function(){
                $accordionExpandCollapse.trigger('click');
            }, 0);


            <?php
            // FIELDS CLONING: based on data attr, allows to move around the 'clone' button, since data-clone attr reference. ?>
            $(document).on('click', '.field-clone', function()
            {
		// Disabled prior to removal.
		// No longer used for cloning text, select or combo fields. Wysiwyg still outstanding.
		return;
                var $self = $(this);
                var $parentFormGroup = $self.closest('.form-group');

                if ($parentFormGroup && $parentFormGroup.length)
                {
                    var $el = $parentFormGroup.children('.form-control, .input-group').first();
                    var isInputGroup = $el.hasClass('input-group');

                    if (typeof this.dataset.field !== 'undefined')
                    {
                        var field = parseInt(this.dataset.field, 10);

                        if (!isNaN(field))
                        {
                            if(window.console) console.log("Firing ajax...");

                            var postdata = {};

                            if (typeof this.dataset.hash !== 'undefined')
                            {
                                postdata.hash = this.dataset.hash;
                            }

                            $.post("/admin/clone/" + field, postdata, function(){ if(window.console) console.log('POSTED...'); })
                            .done(function(data) {
                                if(window.console) console.log('Data returned:');
                                if(window.console) console.log($(data));

                                $self.before($(data));

                                // notify all observers
                                $.publish('field/clone', {'id':field});

                                // force all wysiwyg fields to populate native equivalents and remove before cloning
                                for (var i in CKEDITOR.instances)
                                {
                                    CKEDITOR.instances[i].updateElement();
                                    CKEDITOR.instances[i].destroy();
                                }
                                $('.ckeditor').each(function(i, el)
                                {
                                    CKEDITOR.config.toolbar = getWysiwygToolbarOptions(el);
                                    CKEDITOR.config.height = getWysiwygHeight(el);
                                    CKEDITOR.config.format_tags = getWysiwygFormatTagsOptions(el);
                                    CKEDITOR.config.on = {
                                        'instanceReady': function(evt)
                                        {
//                                            if (el.id == field) // set the focus to cloned editor
//                                            {
//                                                this.focus();
//                                            }
                                        }
                                    };
                                    CKEDITOR.replace(el, CKEDITOR.config); // initialize manually with custom config
                                });
                            })
                            .fail(function() {
                                if(window.console) console.log('Failed while getting data.');
                            })
                            .always(function() {
                                if(window.console) console.log("Finished getting data.");
                            });
                        }

                        return false;
                    }

//                    var $elInput = (isInputGroup) ? $el.find('.form-control') : $el // find input field within cloned html
//
//                    var isWysiwyg = $elInput.hasClass('ckeditor');
//
//                    if (isWysiwyg)
//                    {
//                        // force all wysiwyg fields to populate native equivalents and remove before cloning
//                        for (var i in CKEDITOR.instances)
//                        {
//                            CKEDITOR.instances[i].updateElement();
//                            CKEDITOR.instances[i].destroy();
//                        }
//                    }
//
//                    var $cloned = $el.clone(true, true); // clone element
//                    var $clonedInput = (isInputGroup) ? $cloned.find('.form-control') : $cloned // find input field within cloned html
//                    var matches = $clonedInput.attr('name').match(/fields\[(\d+)\]/); // get field value by running a regex match
//                    if (matches) {
//                        $clonedInput.prop('name', 'fields[' + matches[1]+ '][]'); // update cloned name
//                    } else {
//                        var matches = $clonedInput.attr('name').match(/combo\[(\d+)\]\[(\d+)\]\[fields\]\[(\d+)\]/); // get field value by running a regex match
//                        $clonedInput.prop('name', 'combo[' + matches[1]+ '][' + matches[2]+ '][fields][' + matches[3]+ '][]'); // update cloned name
//                    }
//                    $clonedInput.val('').removeAttr('value'); // clear cloned value
//                    $clonedInput.removeClass('error'); // remove error class if exists from cloned element
//
//                    if (isWysiwyg)
//                    {
//                        var ID = new Date().getTime();
//                        $clonedInput.attr('id', ID); // add generated ID, just to satisfy sortable on wysiwyg
//                    }
//                    else
//                    {
//                        $clonedInput.removeAttr('id');
//                    }
//
//                    if (isInputGroup)
//                    {
//                        // insert cloned element after last of the same type. Note, copied one may be moved with sortable, so can't just insert after
//                        $parentFormGroup.children('.input-group').last().after($cloned).next().find('.form-control').focus();
//                    }
//                    else
//                    {
//                        // insert cloned element after last of the same type. Note, copied one may be moved with sortable, so can't just insert after
//                        $parentFormGroup.children('.form-control').last().after($cloned).next('.form-control').focus();
//                    }
//
//                    if (isWysiwyg)
//                    {
//                        // rebuild all wysiwyg fields
//                        $('.ckeditor').each(function(i, el)
//                        {
//                            CKEDITOR.config.toolbar = getWysiwygToolbarOptions(el);
//                            CKEDITOR.config.height = getWysiwygHeight(el);
//                            CKEDITOR.config.format_tags = getWysiwygFormatTagsOptions(el);
//                            CKEDITOR.config.on = {
//                                'instanceReady': function(evt)
//                                {
//                                    if (el.id == ID) // set the focus to cloned editor
//                                    {
//                                        this.focus();
//                                    }
//                                }
//                            };
//                            CKEDITOR.replace(el, CKEDITOR.config); // initialize manually with custom config
//                        });
//                    }
                }

                $self.trigger('blur'); // unfocus the button
                return false;
            });

            <?php
            // SORTING: with custom classes for easier and more generic setup on various elements ?>
            $('.sortable').sortable(
            {
                containment: "parent",
                handle: ".sortable-handle",
                items: ".sortable-item",
                axis: "y",
                update: function(event, ui)
                {

                    var orderFieldId = $(this).data('sortable_field');
                    var $field = $('#'+orderFieldId);
                    if ($field.length)
                    {
                        var data = [];

                        $(this).find('.sortable-item').each(function(i, el){
                            data.push($(el).data('sortable_item'));
                        });

                        // update hidden fields value with updated order
                        $field.val(data.join(','));
                    }
                },
                start: function(event, ui)
                {
                    // force all wysiwyg fields to populate native equivalents
                    for (var i in CKEDITOR.instances)
                    {
                        CKEDITOR.instances[i].updateElement();
                    }
                },
                stop: function(event, ui)
                {
                    // remove all wysiwyg instances
                    for (var i in CKEDITOR.instances)
                    {
                        CKEDITOR.instances[i].destroy();
                    }

                    // rebuild all wysiwyg fields
                    $('.ckeditor').each(function(idx, el)
                    {
                        CKEDITOR.config.toolbar = getWysiwygToolbarOptions(el);
                        CKEDITOR.config.height = getWysiwygHeight(el);
                        CKEDITOR.config.format_tags = getWysiwygFormatTagsOptions(el);
                        CKEDITOR.replace(el, CKEDITOR.config);
                    });
                }
            }).disableSelection();


            <?php
            // FIELD REMOVING: except last one ?>
            $(document).on('click', '.field-remove', function()
            {
                var $field;

                var $self = $(this);
                var $inputGroup = $self.parent('.input-group');

                $field = ($inputGroup.length) ? $inputGroup :$self.siblings('.form-control');

                if (!$field.siblings('.form-control, .input-group').length)
                {
                    alert("Can't remove.\nAt least one field instance must be present.");
                    return false;
                }

                if(doubleCheck(this))
                {
                    $field.remove();
                    return;
                }
            });


            $('[data-toggle="tooltip"]').tooltip();


            $('#locale-select').change(function () {
                var val = $(this).val();
                var url = "{!! route('cms:locales:set', ['_ID_']) !!}";
                url = url.replace('_ID_', val);
                document.location = url + '?return=' + encodeURI(document.location);
            });


            <?php
            // Add confirm class to elements that should trigger confirm window
            // To show custom text, add data-confirm attribute on html element ?>
            $('.confirm').on('click', function(){
                return doubleCheck(this);
            });

            <?php
            // Generic js confirm window wrapper.
            // To show confirm window, just add confirm class to html elements that should trigger confirm window.
            // To show custom text either pass it as a second parameter (text) or add data-confirm attribute on html element. ?>
            function doubleCheck(el, text)
            {
                if(!text){
                    <?php // Get value of data-confirm attribute if present or use default confirm text. ?>
                    text = el.dataset.confirm || "Are you sure you want to continue?";
                    text = text.replace(/\\n/g,"\n");// respect escaped newlines
                }
                return confirm(text);
            }

            $('.groupCreate').on('change', function(){
                return groupCreate(this);
            });

            function groupCreate(el)
            {
                if(el.options[el.selectedIndex].text == 'Create new')
                {
                    var g = prompt('Please enter group name');
                    if (g != null && (g.replace(/\s*/g, '') !== ''))
                    {
                        el.appendChild(new Option(g, g));
                        el.value = g;
                        return el;
                    }
                    else
                    {
                        el.options[0].selected = 'selected';
                        return el;
                    }
                }
                return null;
            }


            $('.field-type-settings.parent').on('click', 'input.parent', (function()
            {
                updateFieldTypeSettings(this);
            }));


            function updateFieldTypeSettings(el)
            {
                if (typeof el === 'undefined')
                {
                    $('input.parent').each(function(i, elm)
                    {
                        updateFieldTypeSettings(elm);
                    });
                }
                else
                {
                    var $inputParent = $(el);
                    var $parentFieldTypeSettings = $inputParent.parents('.field-type-settings.parent');

                    if (el.checked)
                    {
                        $parentFieldTypeSettings.find('.field-type-settings.child').removeClass('disabled').find('.child').removeAttr('disabled');
                    }
                    else
                    {
                        $parentFieldTypeSettings.find('.field-type-settings.child').addClass('disabled').find('.child').attr('disabled', 'disabled');
                    }
                }
            }

            updateFieldTypeSettings();


        </script>
        @section('footer')
        @show

    </body>
</html>
