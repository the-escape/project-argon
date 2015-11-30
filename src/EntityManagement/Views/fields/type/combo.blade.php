@if(@$field)

    @foreach($field->subfields as $subfield)

        @include('argon::fields.field', ['field'=>$subfield])

    @endforeach

@endif