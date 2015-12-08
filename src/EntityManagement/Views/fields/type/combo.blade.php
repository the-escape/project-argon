@if(@$field)

    <div class="card combo field-{{ $field->id }}">
        <div class="card-header">{{ $field->name }}</div>

        <div class="card-block">

            @foreach($field->subfields as $subfield)

                @include('argon::fields.field', ['field'=>$subfield])

            @endforeach

        </div>
    </div>

@endif