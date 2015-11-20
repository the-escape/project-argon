@if(@$field && ($field instanceof Escape\Argon\EntityManagement\Eloquent\EntityField))

    @if($field->field_type == 'text')

        @include('argon::fields.type.text')

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

    @elseif($field->field_type == 'user')

        @include('argon::fields.type.user')

    @endif

@endif