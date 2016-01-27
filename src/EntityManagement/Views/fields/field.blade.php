<?php
/*
 * For the rare occasions when you will want to override the default html
 * just pass $html_open, $html_close to the include view
 *
 */
if (isset($clone) && $field->getId() == $clone)
{
    $html_open ='';
    $html_close = '';
}
elseif(isset($clone) )
{
    unset($clone);
    $html_open = '<div class="form-group sortable">';
    $html_close = '</div>';
}
else
{
    $html_open = (isset($html_open)) ? $html_open : '<div class="form-group">';
    $html_close = (isset($html_close)) ? $html_close : '</div>';
}
?>

{!! $html_open !!}

    @if($field instanceof \Escape\Argon\EntityManagement\FieldTypes\TextFieldType)

        @if($field->isMultiline())
            @include('argon::fields.type.textarea')
        @else
            @include('argon::fields.type.text')
        @endif

    @elseif($field instanceof \Escape\Argon\EntityManagement\FieldTypes\ImageFieldType)

        @include('argon::fields.type.image')

    @elseif($field instanceof \Escape\Argon\EntityManagement\FieldTypes\FileFieldType)

        @include('argon::fields.type.file')

    @elseif($field instanceof \Escape\Argon\EntityManagement\FieldTypes\BooleanFieldType)

        @include('argon::fields.type.boolean')

    @elseif($field instanceof \Escape\Argon\EntityManagement\FieldTypes\ComboFieldType)

        @include('argon::fields.type.combo')

    @elseif($field instanceof \Escape\Argon\EntityManagement\FieldTypes\SelectFieldType)

        @include('argon::fields.type.select')

    @elseif($field instanceof \Escape\Argon\EntityManagement\FieldTypes\WysiwygFieldType)

        @include('argon::fields.type.wysiwyg')

    @elseif($field instanceof \Escape\Argon\EntityManagement\FieldTypes\DatetimeFieldType)

        @include('argon::fields.type.datetime')

    {{--@elseif($field->field_type == 'video')--}}

        {{--@include('argon::fields.type.video')--}}

    {{--@elseif($field->field_type == 'item')--}}

        {{--@include('argon::fields.type.item')--}}

    {{--@elseif($field->field_type == 'colourpicker')--}}

        {{--@include('argon::fields.type.colourpicker')--}}

    {{--@elseif($field->field_type == 'location')--}}

        {{--@include('argon::fields.type.location')--}}

    {{--@elseif($field->field_type == 'user')--}}

        {{--@include('argon::fields.type.user')--}}

    @endif

{!! $html_close !!}
