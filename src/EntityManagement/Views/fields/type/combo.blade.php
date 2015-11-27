@if(@$field)

    @foreach($field->subfields as $subfield)

        <div class="form-group sortable">
            @include('argon::fields.field', ['field'=>$subfield])
        </div>

    @endforeach

@endif