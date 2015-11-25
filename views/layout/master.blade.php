<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Argon Admin Area</title>
        <link rel="stylesheet" href="/argon/css/app.css">
        @section('styles')
        @show
    </head>

    <body class="dashboard">

        <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
            <ul class="nav navbar-nav pull-right">
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
        <script src="/argon/js/bootstrap.min.js"></script>

        <script>


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
            }, 300);


            <?php
            // FIELDS CLONING: based on data attr, allows to move around the 'clone' button, since data-clone attr reference. ?>
            $(document).on('click', '.field-clone', function()
            {
                var $self = $(this);
                var $parentFormGroup = $self.parent('.form-group');

                if ($parentFormGroup && $parentFormGroup.length)
                {
                    var $el = $parentFormGroup.children('.form-control, .input-group').first();
                    var selfData = $self.data();



                    var $cloned = $el.clone(true, true); // clone element
                    var isInputGroup = $el.hasClass('input-group');

                    var $clonedInput = (isInputGroup) ? $cloned.find('.form-control') : $cloned // find input field within cloned html

                    var matches = $clonedInput.attr('name').match(/fields\[(\d+)\]/); // get field value by running a regex match
                    $clonedInput.val('').removeAttr('value'); // clear cloned value
                    $clonedInput.prop('name', 'fields[' + matches[1]+ '][]'); // update cloned name
                    $clonedInput.removeAttr('id'); // update cloned id
                    $clonedInput.removeClass('error'); // remove error class if exists from cloned element

                    if (isInputGroup)
                    {
                        // insert cloned element after last of the same type. Note, copied one may be moved with sortable, so can't just insert after
                        $parentFormGroup.children('.input-group').last().after($cloned).next().find('.form-control').focus();
                    }
                    else
                    {
                        // insert cloned element after last of the same type. Note, copied one may be moved with sortable, so can't just insert after
                        $parentFormGroup.children('.form-control').last().after($cloned).next('.form-control').focus();
                    }
                }

                $self.trigger('blur'); // unfocus the button
            });


            <?php
            // FIELDS SORTING: ?>
            $('.form-group').sortable(
            {
                handle: ".field-reorder",
                items: "> .sortable",
                axis: "y"
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

        </script>
        @section('footer')
        @show

    </body>
</html>
