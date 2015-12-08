@if(@$field && ($field instanceof Escape\Argon\EntityManagement\Eloquent\EntityField))

    @if($field->field_type == 'combo')

        @include('argon::fields.type.combo')

    @else

        <?php
        /*
         * For the rare occasions when you will want to override the default html
         * just pass $html_open, $html_close to the include view
         *
         */
        $html_open = (isset($html_open)) ? $html_open : '<div class="form-group">';
        $html_close = (isset($html_close)) ? $html_close : '</div>';
        ?>

        {!! $html_open !!}

            @if($field->field_type == 'text')

                @if(@$field->settings->multiline)
                    @include('argon::fields.type.textarea')
                @else
                    @include('argon::fields.type.text')
                @endif

            @elseif($field->field_type == 'image')

                @include('argon::fields.type.image')

            @elseif($field->field_type == 'file')

                @include('argon::fields.type.file')

            @elseif($field->field_type == 'video')

                @include('argon::fields.type.video')

            @elseif($field->field_type == 'boolean')

                @include('argon::fields.type.boolean')

            @elseif($field->field_type == 'item')

                @include('argon::fields.type.item')

            @elseif($field->field_type == 'wysiwyg')

                @include('argon::fields.type.wysiwyg')

            @elseif($field->field_type == 'datetime')

                @include('argon::fields.type.datetime')

            @elseif($field->field_type == 'colourpicker')

                @include('argon::fields.type.colourpicker')

            @elseif($field->field_type == 'location')

                @include('argon::fields.type.location')

            @elseif($field->field_type == 'select')

                @include('argon::fields.type.select')

            @elseif($field->field_type == 'user')

                @include('argon::fields.type.user')

            @endif

        {!! $html_close !!}

    @endif

@endif