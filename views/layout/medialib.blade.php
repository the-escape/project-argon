<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}">
    <title>CMS Admin Area</title>
    <link rel="stylesheet" href="/argon/css/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="/argon/js/jstree/style.min.css">
    <link rel="stylesheet" href="/argon/css/app.css">
    <link rel="adminroot" href="/admin">
    @foreach ($assetsManager->outputStyles() as $styles)
        <link rel="stylesheet" href="{{$styles}}">
    @endforeach
    @section('styles')
    @show
    <style>
        .navbar.bg-inverse {
            background-color: {{config('argon.neutral_color', '#373a3c')}};
        }

        a,
        .nav-link,
        .btn-link,
        .btn-primary-outline {
            color: {{config('argon.highlight_color', '#0275d8')}};
        }

        .btn-primary {
            background-color: {{config('argon.highlight_color', '#0275d8')}};
        }

        .btn-primary,
        .btn-primary-outline {
            border-color: {{config('argon.highlight_color', '#0275d8')}};
        }

        .btn-primary-outline:hover,
        .btn-primary-outline:focus,
        .btn-primary-outline:active,
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .open .btn-primary-outline.dropdown-toggle {
            background-color: {{config('argon.highlight_color_darker', config('argon.highlight_color', '#025aa5'))}};
        }

        .btn-primary-outline:hover,
        .btn-primary-outline:focus,
        .btn-primary-outline:active,
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .open .btn-primary-outline.dropdown-toggle {
            border-color: {{config('argon.highlight_color_darker', config('argon.highlight_color', '#025aa5'))}};
        }

        a:hover,
        .btn-link:hover,
        .btn-link:active,
        .btn-link:focus {
            color: {{config('argon.highlight_color_darker', config('argon.highlight_color', '#025aa5'))}};
        }

        .navbar {
            {{config('argon.navbar')}}
        }
        .navbar .navbar-nav {
            {{config('argon.navbar-nav')}}
        }
        .navbar .navbar-nav .nav-item {
            {{config('argon.nav-item')}}
        }
        .navbar .navbar-nav .nav-link {
            {{config('argon.nav-link')}}
        }

        .navbar .navbar-brand {
            {{config('argon.navbar-brand')}}
        }
        .navbar .navbar-brand .logo-admin {
            {{config('argon.logo-admin')}}
        }

    </style>
</head>

<body class="@yield('body-class', 'dashboard')">

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            @yield('content')
        </div>
    </div>
</div>

<div class="modals"></div>

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
<script src="/argon/js/handlebars.min.js"></script>
<script src="/argon/js/dropzone.min.js"></script>
<script src="/argon/js/jquery.fancybox.pack.js"></script>
<script src="/argon/js/argon.js"></script>

<script>

    var $formDZ = $('form.dz');

    if ($formDZ && $formDZ.length)
    {
        var dropzone = new Dropzone(
                'form.dz',
                {
                    url: '/admin/media/upload',
                    clickable: '.btn-upload',
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    thumbnailWidth: 100,
                    thumbnailHeight: 100,
                    previewTemplate: $('#preview-template').html(),
                    previewsContainer: '.media-library .files'
                }
        );
        dropzone.on('success', function(e, response) {
            loadItems($('#current-folder').val());
        });

        dropzone.on('error', function(file, errorMessage, xhr) {
            console.log(errorMessage);
        });

        dropzone.on('uploadprogress', function(file, progress, bytesSent) {
            $('progress', file.previewElement).val(progress);

            if (progress == 100) {
                $('progress', file.previewElement).hide();
            }
        });

        dropzone.on('addedfile', function(file) {
            sortItems();
        });
    }


</script>

@foreach($assetsManager->outputScripts() as $script)
    <script src="{{$script}}"></script>
@endforeach

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
        activate: function(event, ui)
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

    $('.accordion-header .checkbox').on({
      click: function(e) {
          e.stopPropagation();
      }, mouseenter: function(e) {
          $(this).addClass("hover");
      }, mouseleave: function(e) {
          $(this).removeClass("hover");
      }
    });


    <?php
    // ACCORDIONS: expand all instances on load after slight delay. ?>
    setTimeout(function(){
        //$accordionExpandCollapse.trigger('click');
    }, 0);


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

                $(this).children('.sortable-item').each(function(i, el){
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
                WYSIWYG.init(el);
            });
        }
    });


    <?php
    // FIELD REMOVING: except last one ?>
//    $(document).on('click', '.field-remove', function()
//    {
//        var $field;
//
//        var $self = $(this);
//        var $inputGroup = $self.parent('.input-group');
//
//        $field = ($inputGroup.length) ? $inputGroup :$self.siblings('.form-control');
//
//        if (!$field.siblings('.form-control, .input-group').length)
//        {
//            alert("Can't remove.\nAt least one field instance must be present.");
//            return false;
//        }
//
//        if(doubleCheck(this))
//        {
//            $field.remove();
//            return;
//        }
//    });


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
        var boolean = argon.dialog.confirm(this);
        $(this).attr('confirm', boolean);
        return boolean;
    });

    <?php
    // Generic js confirm window wrapper.
    // To show confirm window, just add confirm class to html elements that should trigger confirm window.
    // To show custom text either pass it as a second parameter (text) or add data-confirm attribute on html element. ?>
    //function doubleCheck(el, text)
    //{
    //    if(!text){
    //        <?php // Get value of data-confirm attribute if present or use default confirm text. ?>
    //        text = el.dataset.confirm || "Are you sure you want to continue?";
    //        text = text.replace(/\\n/g,"\n");// respect escaped newlines
    //    }
    //    return confirm(text);
    //}

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
