@if(@$field)
    
    @if($field->field_type == 'text')

        @include('argon::fields.text')

    @elseif($field->field_type == 'image')

        @include('argon::fields.field.image')

    @elseif($field->field_type == 'file')

        @include('argon::fields.field.file')

    @elseif($field->field_type == 'video')

        @include('argon::fields.field.video')

    @elseif($field->field_type == 'boolean')

        @include('argon::fields.field.boolean')

    @elseif($field->field_type == 'item')

        @include('argon::fields.field.item')

    @elseif($field->field_type == 'wysiwyg')

        @include('argon::fields.field.wysiwyg')

    @elseif($field->field_type == 'datetime')

        @include('argon::fields.field.datetime')

    @elseif($field->field_type == 'colourpicker')

        @include('argon::fields.field.colourpicker')

    @elseif($field->field_type == 'location')

        @include('argon::fields.field.location')

    @elseif($field->field_type == 'user')

        @include('argon::fields.field.user')

    @endif

@endif