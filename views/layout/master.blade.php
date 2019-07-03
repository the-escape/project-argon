<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CMS Admin Area</title>
    @include('argon::inc.primary-colour-css-variable')
    <link rel="stylesheet" href="/argon/css/old-cms.css">
    <link rel="stylesheet" href="{{ getAssetPath('argon/css/main.css') }}">
    <link rel="adminroot" href="/admin">
    @foreach ($assetsManager->outputStyles() as $styles)
        <link rel="stylesheet" href="{{$styles}}">
    @endforeach
    @section('styles')
    @show
    <style>
        {{ config('argon.admin_css', '') }}
    </style>
</head>

<body id="@yield('body-id','')" class="@yield('body-class', 'dashboard')">

@include('argon::inc.nav')

@section('header')
@show

@yield('content')

<div class="modals">@yield('modals')</div>

<div class="o-modal__container js-modal-container">
    <script class="js-modal-template" type="text/template">
        <div class="o-modal" data-modal-item-id="{id}">
            <div class="o-modal__content typography h-text--centre">
                {content}
            </div>
        </div>
    </script>
</div>

<script src="/argon/vendor/jquery.min.js"></script>
<script src="/argon/js/core.js"></script>
<script src="/argon/js/widget.js"></script>
<script src="/argon/js/mouse.js"></script>
<script src="/argon/js/accordion.js"></script>
<script src="/argon/js/sortable.js"></script>
<script src="/argon/js/tether.min.js"></script>
<script src="/argon/js/bootstrap.min.js"></script>
<script src="/argon/vendor/ckeditor/ckeditor.js"></script>
<script src="/argon/vendor/jstree.min.js"></script>
<script src="/argon/js/bootstrap-datepicker.min.js"></script>
<script src="/argon/js/handlebars.min.js"></script>
{{--<script src="/argon/js/dropzone.min.js"></script>--}}
<script src="/argon/js/jquery.fancybox.pack.js"></script>
<script src="/argon/js/argon.js"></script>

@foreach($assetsManager->outputScripts() as $script)
    <script src="{{$script}}"></script>
@endforeach

<script src="/argon/vendor/libs.js"></script>
<script>
    function fetchJs() {
            fetch('/argon/js/manifest.json')
                .then(function (data) {
                    return data.json();
                })
                .then(function (manifestfiles) {
                    if (!loadjs.isDefined('js')) {
                        var files = []

                        files.push('/argon' + manifestfiles['main.js'])

                        if(manifestfiles['vendor.js']){
                            files.push('/argon' + manifestfiles['vendor.js'])
                        }

                        loadjs(files, 'js', {
                            async: false
                        });
                    }
                });
        }

        if (typeof window.fetch === "undefined") {
            loadjs(['/argon/vendor/polyfill.min.js', '/argon/vendor/fetch.js'], {
                success: fetchJs
            });
        } else {
            fetchJs();
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
    $('[data-toggle="popover"]').popover();
    $('.preview-popover')
        .on('click',function(e){
            e.preventDefault();
            e.stopPropagation();
        })
        .popover({
            template: '{!! config('argon.block_preview_popover_template', '<div class="popover" role="tooltip" style="max-width: 600px;"><div class="popover-arrow"></div><h3 class="popover-title"></h3><div class="popover-content"><div class="data-content"></div></div></div>') !!}',
            html: true,
            trigger: 'hover',
            content: function () {
                return '<img src="'+$(this).data('img') + '" />';
            }
        });



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


    $( ".accordion-header-details a" ).click(function(e){
        e.stopPropagation();
        e.preventDefault();

        var $this = $(this);
        var confirm = $this.attr('confirm');

        if (confirm == 'true')
        {
            window.location.href = $this.attr("href");
        }
    });


</script>
@section('footer')
@show

</body>
</html>
